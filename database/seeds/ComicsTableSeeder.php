<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Character;
use App\Comic;

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
            $entries = DB::connection('everything')->select('
                SELECT
                    CONCAT(n.eventID, "-", n.side) AS legacy_id,
                    n.eventID,
                    n.fighterID,
                    n.forum,
                    e.title,
                    e.length,
                    e.status,
                    e.end
                FROM
                    entry n
                LEFT JOIN `event` e ON e.eventID = n.eventID
            ');

            foreach ($entries as $entry) {
                // Save basic attributes
                $comic = Comic::firstOrNew(['legacy_id' => $entry['legacy_id']]);
                $comic->legacy_id = $entry['legacy_id'];
                $end = new Carbon($entry['end']);
                if (in_array($entry['status'], ['N', 'V'])) {
                    $end = $end->subWeek();
                    $comic->published_at = $comic->completed_at = $end;
                }
                $comic->created_at = $end->subWeeks($entry['length']);
                $comic->match()->associate($entry['eventID']);
                $comic->creators()->attach($entry['forum']);
                $comic->characters()->attach($entry['fighterID']);

                // Finally, save the Character
                $comic->save();

                if ($entry['title'] === 'Intro Story') {
                    $character = Character::findOrNew($entry['fighterID']);
                    $character->intro()->associate($comic);
                    $character->save();
                }
            }
        });
    }
}
