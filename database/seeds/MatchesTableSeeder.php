<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Character;
use App\FileManaged;

class CharactersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $events = DB::connection('everything')->select('
                SELECT
                    eventID,
                    title,
                    type,
                    length,
                    pages,
                    status,
                    `end`,
                    views,
                    `last`
                FROM
                    event
            ');

            foreach ($events as $event) {
                // Save basic attributes
                $match = Match::findOrNew($event['eventID']);
                $character->id = $fighter['id'];
                $character->name = htmlspecialchars(stripslashes($fighter['name']));
                $character->gender = stripslashes($fighter['sex']);
                $character->height = stripslashes($fighter['height']);
                $character->bio = stripslashes($fighter['bio']);
                $character->type = $fighter['type'];
                $character->status = $fighter['status'];
                $character->created_at = $fighter['born'];
                $character->intro_id_legacy = $fighter['intro_id_legacy'];

                // We'll be copying character images manually since filenames
                // won't change, but we need to create FileManaged objects and
                // link their id's here:
                $fighterImagesPath = app()->basePath('public/images/character/') . $character->id . '/';
                // Icon
                $icon = self::pathToFileManaged($fighterImagesPath . stripslashes($fighter['image']), $character);
                $character->icon_id = $icon ? $icon->id : null;
                // Design Sheet
                $designSheet = self::pathToFileManaged($fighterImagesPath . stripslashes($fighter['normimage']), $character);
                $character->design_sheet_id = $designSheet ? $designSheet->id : null;
                // Supplementary art (previously `winimage` and `loseimage`)
                $win = self::pathToFileManaged($fighterImagesPath . stripslashes($fighter['winimage']), $character);
                $lose = self::pathToFileManaged($fighterImagesPath . stripslashes($fighter['loseimage']), $character);

                // Finally, save the Character
                $character->save();
            }
        });
    }

    /**
    * Helper function to conver existing path to UploadedFile object
    * @param     string $path
    * @param     bool $public default false
    * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
    * @author    Alexandre Thebaldi
    */
    public static function pathToFileManaged($path, $character)
    {
        try {
            $name = File::name($path);
            $extension = File::extension($path);
            $originalName = $name . '.' . $extension;
            $mimeType = File::mimeType($path);
            $size = File::size($path);
            $uploadedFile = new UploadedFile($path, $originalName, $mimeType, $size, null, true);
        } catch (Exception $e) {
            // No image or image doesn't exist; don't create managed file entry
            return null;
        }
        $filename = $uploadedFile->getFilename();

        $fileManaged = FileManaged::firstOrNew([
            'filename' => $filename,
            'attacher_type' => 'character',
            'attacher_id' => $character->id,
        ]);
        $fileManaged->mime = $uploadedFile->getClientMimeType();
        $fileManaged->original_filename = $uploadedFile->getClientOriginalName();
        $fileManaged->filename = $filename;
        $fileManaged->attacher_id = $character->id;
        $fileManaged->attacher_type = 'character';
        $fileManaged->save();

        return $fileManaged;
    }
}
