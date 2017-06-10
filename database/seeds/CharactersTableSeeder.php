<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Characters\Character;
use App\Characters\CharacterStatus;
use App\Characters\CharacterType;
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
                /** @var App\Characters\Character $character */
                $character = Character::findOrNew($fighter->id);
                $character->id = $fighter->id;
                $character->save();
                $character->name = htmlspecialchars(stripslashes($fighter->name));
                $character->gender = stripslashes($fighter->sex);
                $character->height = stripslashes($fighter->height);
                $character->bio = stripslashes($fighter->bio);
                $character->created_at = $fighter->born === '0000-00-00 00:00:00' ? null : new Carbon($fighter->born);
                $character->intro_id_legacy = $fighter->intro_id_legacy;
                /** @var App\Characters\CharacterType $characterType */
                $characterType = CharacterType::where('legacy_id', $fighter->type)->first();
                $character->type()->associate($characterType);
                /** @var App\Characters\CharacterStatus $characterStatus */
                $characterStatus = CharacterStatus::where('legacy_id', $fighter->status)->first();
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
                    if (!$member->user_id) continue;
                    $character->creators()->syncWithoutDetaching($member->user_id);
                }
                $character->save();

                // We'll be copying character images manually since filenames
                // won't change, but we need to create ManagedFile objects and
                // link their id's here:
                $fighterImagesPath = app()->basePath('public/images/characters/') . $character->id . '/';
                // Icon
                $icon = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter->image), $character);
                $character->icon()->associate($icon);
                // Design Sheet
                /** @var App\ManagedFile $designSheet */
                $designSheet = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter->normimage), $character);
                $character->designSheet()->associate($designSheet);
                // Supplementary art (previously `winimage` and `loseimage`)
                /** @var App\ManagedFile $win */
                $win = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter->winimage), $character);
                /** @var App\ManagedFile $lose */
                $lose = $this->pathToManagedFile($fighterImagesPath . stripslashes($fighter->loseimage), $character);
                $character->supplementaryArt()->sync(filter(map([$win, $lose], function($art) {
                    return $art->id ?? null;
                })));

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

        /** @var App\ManagedFile $managedFile */
        $managedFile = ManagedFile::firstOrNew([
            'path' => 'characters/' . $character->id . '/',
            'filename' => $filename,
        ]);
        $managedFile->mime = $uploadedFile->getClientMimeType();
        $managedFile->original_filename = $uploadedFile->getClientOriginalName();
        $managedFile->path = 'characters/' . $character->id . '/';
        $managedFile->filename = $filename;
        $managedFile->save();

        return $managedFile;
    }
}
