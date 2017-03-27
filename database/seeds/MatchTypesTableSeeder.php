<?php

use Illuminate\Database\Seeder;
use App\Comics\MatchType;

class MatchTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $match_types = [
                'X' => 'Regular',
                'R' => 'Sparring',
                'P' => 'Trophy',
                'S' => 'Scar',
                'DS' => 'Double Scar',
                'D' => 'Death',
                'KX' => 'Annihilation',
                // Artist-only
                'M' => 'Artist',
                'N' => 'Artist Sparring',
                // Single comic
                'B' => 'Beyond',
                'O' => 'One-Shot',
                // Special events
                'BR' => 'Battle Royale',
                'T' => 'Tournament',
                'SDT' => 'Speed Death Tournament',
                'SRT' => 'Speed Resurrection Tournament',
                'A' => 'Armageddon',
            ];

            foreach ($match_types as $key => $name) {
                $match_type = new MatchType;
                $match_type->legacy_id = $key;
                $match_type->name = $name;
                $match_type->save();
            }
        });
    }
}
