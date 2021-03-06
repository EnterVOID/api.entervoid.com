<?php

use App\Characters\Character;
use App\Comics\Comic;
use App\Comics\Page;
use App\Comics\Thumbnail;
use App\ManagedFile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ComicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '256M');
        DB::transaction(function () {
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
			$entries = DB::connection('everything')->select('
                SELECT
                    CONCAT(n.eventID, "-", n.side) AS legacy_id,
                    n.side,
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
                /** @var App\Comics\Comic $comic */
                $comic = Comic::firstOrNew(['legacy_id' => $entry->legacy_id]);
                $comic->legacy_id = $entry->legacy_id;
                if ($entry->end && $entry->end !== '0000-00-00') {
                    $end = new Carbon($entry->end);
                    if (in_array($entry->status, ['N', 'V'])) {
                        $end = $end->subWeek();
                        $comic->published_at = $comic->completed_at = $end;
                    }
                    $comic->created_at = $end->subWeeks($entry->length);
                }
                $comic->match()->associate($entry->eventID);
                $comic->save();
                if ($entry->forum && !$comic->users->contains($entry->forum)) {
                    $comic->users()->attach($entry->forum);
                }
                if ($entry->fighterID && !$comic->characters->contains($entry->fighterID)) {
                    $comic->characters()->attach($entry->fighterID);
                }

                // Finally, save the Comic
                $comic->save();

                if ($entry->title === 'Intro Story') {
                    /** @var App\Characters\Character $character */
                    $character = Character::findOrNew($entry->fighterID);
                    $character->intro()->associate($comic);
                    $character->save();
                    unset($character);
                }

                // Save comic pages
                // Unlike character art, comic pages need to be relocated so that they're stored by Comic::$id
                // instead of the old mechanism of [eventID]-[side]
                $pages = DB::connection('everything')->select('
                    SELECT imageID AS id, fileName AS filename, PageNum AS page_number
                    FROM image WHERE eventID = :eventID AND side = :side
                ', [':eventID' => $entry->eventID, ':side' => $entry->side]);
                $oldPath = app()->basePath('storage/public/allComics/') . $comic->legacy_id . '/';
                try {
                    $newPath = app()->basePath('storage/public/comics/') . $comic->match_id . '/' . $comic->id . '/';
                } catch (ErrorException $e) {
                    dd($comic);
                }
                foreach ($pages as $page) {
                    /** @var App\Comics\Page $comicPage */
                    $comicPage = Page::firstOrNew([
                        'comic_id' => $comic->id,
                        'page_number' => $page->page_number,
                        'filename' => urldecode(stripslashes($page->filename)),
                        'created_at' => $comic->created_at,
                        'updated_at' => $comic->updated_at,
                    ]);
                    $comicPage->comic()->associate($comic);
                    /** @var App\ManagedFile $image */
                    $image = $this->pathToManagedFile($oldPath, $newPath, $comicPage);
                    if ($image) {
                        $comicPage->managedFile()->associate($image);
                    }
                    $comicPage->save();
                    /** @var App\Comics\Thumbnail $comicPageThumbnail */
                    $comicPageThumbnail = Thumbnail::firstOrNew([
                        'page_id' => $comicPage->id,
                        'created_at' => $comic->created_at,
                        'updated_at' => $comic->updated_at,
                    ]);
                    $comicPageThumbnail->page()->associate($comicPage);
                    /** @var App\ManagedFile $thumbnail */
                    $thumbnail = $this->thumbnailToManagedFile($oldPath, $newPath . 'thumbnails/', $comicPage);
                    if ($thumbnail) {
                        $comicPageThumbnail->managedFile()->associate($thumbnail);
						$comicPageThumbnail->save();
                    }
                    unset($page);
                    unset($comicPage);
                    unset($image);
                    unset($comicPageThumbnail);
                    unset($thumbnail);
                }
                unset($pages);
                unset($comic);
                unset($entry);
            }
        });
    }

    /**
     * Helper function to convert existing path to UploadedFile object
     * @param     string $path
     * @param     bool $public default false
     * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
     * @author    Alexandre Thebaldi
     */
    public function pathToManagedFile($oldPath, $newPath, $page)
    {
		/** @var App\ManagedFile $managedFile */
		$managedFile = ManagedFile::firstOrNew([
			'path' => 'comics/' . $page->comic->match_id . '/' . $page->comic_id,
			'filename' => $page->filename,
			'original_filename' => $page->filename,
			'mime' => '',
		]);
		try {
			$managedFile->mime = mime_content_type($newPath . '/' . $page->filename);
		} catch (Exception $e) {
			// Do nothing; we don't know the real mime type
		}
		$managedFile->save();
		return $managedFile;

        $filepath = null;
        $size = null;
        $move = false;
        try {
            $filepath = $newPath . $page->filename;
            $size = File::size($filepath);
        } catch (Exception $e) {
            try {
                $filepath = $oldPath . $page->filename;
                $size = File::size($filepath);
                $move = true;
            } catch (Exception $e) {
				Log::info('File missing at ' . $filepath . ' for match id ' . $page->comic->match->id);
				// Image doesn't exist; don't create managed file entry
                return null;
            }
        }
        $name = File::name($filepath);
        $extension = File::extension($filepath);
        $originalName = $name . '.' . $extension;
        $mimeType = File::mimeType($filepath);
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = new UploadedFile($filepath, $originalName, $mimeType, $size, null, true);
        if ($move) {
            $uploadedFile->move($newPath);
        }
        $filename = $uploadedFile->getFilename();

        $path = 'comics/' . $page->comic->match_id . '/' . $page->comic->id . '/';
        /** @var App\ManagedFile $managedFile */
        $managedFile = ManagedFile::firstOrNew([
            'path' => $path,
            'filename' => $filename,
        ]);
        $managedFile->mime = $uploadedFile->getClientMimeType();
        $managedFile->original_filename = $uploadedFile->getClientOriginalName();
        $managedFile->path = $path;
        $managedFile->filename = $filename;
        $managedFile->save();

        return $managedFile;
    }

    /**
     * Helper function to convert existing path to UploadedFile object
     * @param     string $path
     * @param     bool $public default false
     * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
     * @author    Alexandre Thebaldi
     */
    public function thumbnailToManagedFile($oldPath, $newPath, $page)
    {
        $path = null;
        $size = null;
        $move = false;
        try {
            $path = $newPath . $page->filename;
            $size = File::size($path);
        } catch (Exception $e) {
            try {
                $path = $newPath . 'thumb' . sprintf('%02d', $page->page_number) . '.jpg';
                $size = File::size($path);
            } catch (Exception $e) {
                try {
                    $path = $oldPath . 'thumbnail/' . $page->filename;
                    $size = File::size($path);
                    $move = true;
                } catch (Exception $e) {
                    try {
                        $path = $oldPath . 'thumb' . sprintf('%02d', $page->page_number) . '.jpg';
                        $size = File::size($path);
                        $move = true;
                    } catch (Exception $e) {
                    	// No thumbnail; that's okay, we'll just use the default! :D
                        return null;
                    }
                }
            }
        }
        $name = File::name($path);
        $extension = File::extension($path);
        $originalName = $name . '.' . $extension;
        $mimeType = File::mimeType($path);
        $uploadedFile = new UploadedFile($path, $originalName, $mimeType, $size, null, true);
        if ($move) {
            $uploadedFile->move($newPath);
        }
        $filename = $uploadedFile->getFilename();

        $path = 'comics/' . $page->comic->match_id . '/' . $page->comic->id . '/thumbnails/';
        /** @var App\ManagedFile $managedFile */
        $managedFile = ManagedFile::firstOrNew([
            'path' => $path,
            'filename' => $filename,
        ]);
        $managedFile->mime = $uploadedFile->getClientMimeType();
        $managedFile->original_filename = $uploadedFile->getClientOriginalName();
        $managedFile->path = $path;
        $managedFile->filename = $filename;
        $managedFile->save();

        return $managedFile;
    }
}
