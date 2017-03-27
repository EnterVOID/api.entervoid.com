<?php

use Illuminate\Database\Seeder;
use App\Comics\MatchStatus;

class MatchStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $match_statuses = [
                'C' => 'Challenged',
                'D' => 'Drawing',
                'V' => 'Voting',
                'N' => 'Complete',
                'DN' => 'Dual No show',
                'X' => 'Cancelled',
                'CA' => 'Cancelled by Admin',
                'CU' => 'Cancelled by Users',
            ];

            foreach ($match_statuses as $key => $name) {
                $match_status = new MatchStatus;
                $match_status->legacy_id = $key;
                $match_status->name = $name;
                $match_status->save();
            }
        });
    }
}
