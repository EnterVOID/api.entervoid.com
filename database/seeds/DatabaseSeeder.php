<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersTableSeeder');

        $this->call('CharacterStatusesTableSeeder');
        $this->call('CharacterTypesTableSeeder');
        $this->call('CharactersTableSeeder');

        $this->call('MatchStatusesTableSeeder');
        $this->call('MatchTypesTableSeeder');
        $this->call('MatchesTableSeeder');

        $this->call('ComicsTableSeeder');
    }
}
