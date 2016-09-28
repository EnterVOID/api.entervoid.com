<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Character;
use App\CharacterStatus;
use App\CharacterType;
use App\ManagedFile;

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
            $fighters = DB::connection('everything')->select('
                SELECT
                    f.id,
                    f.name,
                    f.sex,
                    f.height,
                    f.bio,
                    f.type,
                    f.status,
                    f.born,
                    CONCAT(i.eventID, "-", i.side) AS intro_id_legacy,
                    f.image,
                    f.winimage,
                    f.loseimage,
                    f.normimage
                FROM
                    fighter f
                LEFT JOIN (
                    SELECT
                        en.eventID,
                        en.side,
                        en.fighterID
                    FROM entry en
                    JOIN event ev
                        ON en.eventID = ev.eventID
                        AND ev.title = "Intro Story"
                    GROUP BY en.eventID, en.side
                ) i ON i.fighterID = f.id
            ');

            foreach ($fighters as $fighter) {
                // Save basic attributes
                $character = Character::findOrNew($fighter['id']);
                $character->id = $fighter['id'];
                $character->save();
                $character->name = htmlspecialchars(stripslashes($fighter['name']));
                $character->gender = stripslashes($fighter['sex']);
                $character->height = stripslashes($fighter['height']);
                $character->bio = stripslashes($fighter['bio']);
                $character->created_at = $fighter['born'];
                $character->intro_id_legacy = $fighter['intro_id_legacy'];
                $characterType = CharacterType::where('legacy_id', $fighter['type'])->first();
                $character->type()->associate($characterType);
                $characterStatus = CharacterStatus::where('legacy_id', $fighter['status'])->first();
                $character->status()->associate($characterStatus);
                $character->save();

                // Get creator(s) and create relations (users should already exist in database)
                $members = DB::connection('everything')->select('
                        SELECT user_id FROM creators
                        WHERE creation_id = :character_id AND creation_type = "character"
                    ',
                    [':character_id' => $character->id]
                );
                foreach ($members as $member) {
                    if (!$member['user_id'] || $character->creators->contains($member['user_id'])) continue;
                    $character->creators()->attach($member['user_id']);
                    $character->save();
                }

                // We'll be copying character images manually since filenames
                // won't change, but we need to create ManagedFile objects and
                // link their id's here:
                $fighterImagesPath = app()->basePath('public/images/characters/') . $character->id . '/';
                // Icon
                $icon = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter['image']), $character);
                $character->icon_id = $icon ? $icon->id : null;
                // Design Sheet
                $designSheet = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter['normimage']), $character);
                $character->design_sheet_id = $designSheet ? $designSheet->id : null;
                // Supplementary art (previously `winimage` and `loseimage`)
                $win = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter['winimage']), $character);
                $lose = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter['loseimage']), $character);

                // Finally, save the Character
                $character->save();
            }
        });
    }

    /**
    * Helper function to convert existing path to UploadedFile object
    * @param     string $path
    * @param     bool $public default false
    * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
    * @author    Alexandre Thebaldi
    */
    public function pathToManagedFile($path, $character)
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

        $managedFile = ManagedFile::firstOrNew([
            'path' => 'characters/' . $character->id . '/',
            'filename' => $filename,
            'attacher_type' => 'App\\Character',
            'attacher_id' => $character->id,
        ]);
        $managedFile->mime = $uploadedFile->getClientMimeType();
        $managedFile->original_filename = $uploadedFile->getClientOriginalName();
        $managedFile->path = 'characters/' . $character->id . '/';
        $managedFile->filename = $filename;
        $managedFile->attacher_id = $character->id;
        $managedFile->attacher_type = 'App\\Character';
        $managedFile->save();

        return $managedFile;
    }
}
