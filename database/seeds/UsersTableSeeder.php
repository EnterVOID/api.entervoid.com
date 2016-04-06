<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;
use App\FileManaged;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $members = DB::connection('everything')->select('
                SELECT
                    id_member AS id,
                    member_name AS login,
                    date_registered,
                    posts,
                    real_name,
                    passwd,
                    email_address,
                    gender,
                    birthdate,
                    website_title,
                    website_url,
                    location,
                    avatar,
                    karma_bad AS times_warned,
                    karma_good AS extensions_available,
                    secret_question,
                    secret_answer,
                    password_salt
                FROM
                    smf_members
                WHERE
                    is_activated = 1
            ');

            foreach ($members as $member) {
                // Save basic attributes
                $user = User::findOrNew($member['id']);
                $user->id = $member['id'];
                $user->login = $member['login'];
                $user->gender = $member['gender'];
                $user->created_at = $member['date_registered'];
                $user->posts = $member['posts'];
                $user->real_name = $member['real_name'];
                $user->email_address = $member['email_address'];
                $user->birthdate = $member['birthdate'];
                $user->website_title = $member['website_title'];
                $user->website_url = $member['website_url'];
                $user->location = $member['location'];
                $user->avatar = $member['avatar'];
                $user->times_warned = $member['times_warned'];
                $user->extensions_available = $member['extensions_available'];
                $user->passwd = $member['passwd'];
                $user->password_salt = $member['password_salt'];
                $user->secret_question = $member['secret_question'];
                $user->secret_answer = $member['secret_answer'];

                // We'll be copying character images manually since filenames
                // won't change, but we need to create FileManaged objects and
                // link their id's here:
                $memberImagesPath = app()->basePath('public/images/character/') . $user->id . '/';
                // Icon
                $icon = self::pathToFileManaged($memberImagesPath . stripslashes($member['image']), $user);
                $user->icon_id = $icon ? $icon->id : null;
                // Design Sheet
                $designSheet = self::pathToFileManaged($memberImagesPath . stripslashes($member['normimage']), $user);
                $user->design_sheet_id = $designSheet ? $designSheet->id : null;
                // Supplementary art (previously `winimage` and `loseimage`)
                $win = self::pathToFileManaged($memberImagesPath . stripslashes($member['winimage']), $user);
                $lose = self::pathToFileManaged($memberImagesPath . stripslashes($member['loseimage']), $user);

                // Finally, save the User
                $user->save();
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
    public static function pathToFileManaged($path, $user)
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
            'attacher_id' => $user->id,
        ]);
        $fileManaged->mime = $uploadedFile->getClientMimeType();
        $fileManaged->original_filename = $uploadedFile->getClientOriginalName();
        $fileManaged->filename = $filename;
        $fileManaged->attacher_id = $user->id;
        $fileManaged->attacher_type = 'character';
        $fileManaged->save();

        return $fileManaged;
    }
}
