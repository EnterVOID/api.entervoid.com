<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Comics\Match;
use App\Comics\MatchStatus;
use App\Comics\MatchType;

class MatchesTableSeeder extends Seeder
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
				WHERE
                    type <> "" AND `status` <> ""
            ');

            foreach ($events as $event) {
                // Save basic attributes
                /** @var Match $match */
                $match = Match::findOrNew($event->eventID);
                $match->id = $event->eventID;
                $match->title = stripslashes($event->title);
                $match->length = $event->length ?: 0;
                $match->page_limit = $event->pages;
                try {
                    $end = new Carbon($event->end);
                    $match->due_date = $end;
                    if (in_array($event->status, ['V', 'N', 'DN'])) {
                        $match->due_date = $end->subWeek();
                    }
                    $match->created_at = $match->due_date->subWeeks($event->length);
                }
                catch (InvalidArgumentException $e) {
                    $match->due_date = $match->created_at = null;
                }
                $type = MatchType::where('legacy_id', '=', $event->type)->first();
                $match->type()->associate($type->id);
                $status = MatchStatus::where('legacy_id', '=', $event->status)->first();
                $match->status()->associate($status->id);

                // Finally, save the Character
                $match->save();
            }
        });
    }
}
