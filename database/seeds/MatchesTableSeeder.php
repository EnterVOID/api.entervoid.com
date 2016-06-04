<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Match;

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
                    `status`,
                    `end`,
                    views,
                    `last`
                FROM
                    `event`
            ');

            foreach ($events as $event) {
                // Save basic attributes
                $match = Match::findOrNew($event['eventID']);
                $match->id = $event['eventID'];
                $match->title = stripslashes($event['title']);
                $match->length = $event['length'];
                $match->page_limit = $event['pages'];
                $end = new Carbon($event['end']);
                $match->due_date = $end;
                if (in_array($event['status'], ['V', 'N', 'DN'])) {
                    $match->due_date = $end->subWeek();
                }
                $match->created_at = $match->due_date->subWeeks($event['length']);
                $match->type()->associate(MatchType::where('legacy_id', '=', $event['type'])->get());
                $match->status()->associate(MatchStatus::where('legacy_id', '=', $event['status'])->get());

                // Finally, save the Character
                $match->save();
            }
        });
    }
}
