<?php

use Illuminate\Database\Seeder;
use App\Characters\CharacterStatus;

class CharacterStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $character_statuses = [
                'N' => 'Awaiting Approval',
                'A' => 'Available',
                'I' => 'Inactive',
                'R' => 'Retired',
                'K' => 'Dead', // 'Killed'
                'KX' => 'Annihilated',
                'X' => 'Declined',
            ];

            foreach ($character_statuses as $key => $name) {
                $character_status = new CharacterStatus;
                $character_status->legacy_id = $key;
                $character_status->name = $name;
                $character_status->save();
            }
        });
    }
}
