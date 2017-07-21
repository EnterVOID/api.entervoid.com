<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\User;

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
                    is_activated IN (1, 2, 11)
            ');

            foreach ($members as $member) {
                $genders = ['1' => 'M', '2' => 'F', '3' => 'O', '0' => 'U'];
                // Save basic attributes
                /** @var User $user */
                $user = User::findOrNew($member->id);
                $user->id = $member->id;
                $user->login = $member->login;
                $user->gender = $genders[$member->gender];
                $user->created_at = Carbon::createFromTimestamp($member->date_registered);
                $user->posts = $member->posts;
                $user->real_name = $member->real_name;
                $user->email_address = $member->email_address;
                $user->birthdate = $member->birthdate === '0001-01-01' ? null : new Carbon($member->birthdate);
                $user->website_title = $member->website_title;
                $user->website_url = $member->website_url;
                $user->location = $member->location;
                $user->avatar = $member->avatar;
                $user->times_warned = $member->times_warned;
                $user->extensions_available = $member->extensions_available;
                $user->passwd = $member->passwd;
                $user->password_salt = $member->password_salt;
                $user->secret_question = $member->secret_question;
                $user->secret_answer = $member->secret_answer;
                
                // @TODO: Find a way to import avatars

                // Finally, save the User
                $user->save();
            }
        });
    }
}
