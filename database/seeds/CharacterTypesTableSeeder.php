<?php

use Illuminate\Database\Seeder;
use App\Characters\CharacterType;

class CharacterTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $character_types = [
                'R' => 'Regular',
                'N' => 'Public',
                'SDT' => 'Speed Death Tournament Entrant',
                'A' => 'Armageddon Threat',
            ];

            foreach ($character_types as $key => $name) {
                $character_type = new CharacterType;
                $character_type->legacy_id = $key;
                $character_type->name = $name;
                $character_type->save();
            }
        });
    }
}
