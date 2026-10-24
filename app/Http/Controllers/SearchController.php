<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(SearchRequest $request): View
    {
        $term = trim((string) $request->query('q'));
        $perPage = 10;
        $page = max(1, (int) $request->query('page', 1));

        if ($term === '') {
            $results = new LengthAwarePaginator(
                new Collection,
                0,
                $perPage,
                $page,
                [
                    'path' => route('search'),
                    'query' => [],
                ]
            );

            return view('search.index', [
                'results' => $results,
                'q' => $term,
            ]);
        }

        $like = '%'.addcslashes($term, '\%_').'%';

        $noteQuery = $request->user()->notes()
            ->whereRaw("notes.title like ? escape '\\'", [$like]);

        $fileQuery = $request->user()->files()
            ->whereRaw("files.file_name like ? escape '\\'", [$like]);

        $noteTotal = (clone $noteQuery)->count();
        $fileTotal = (clone $fileQuery)->count();
        $total = $noteTotal + $fileTotal;
        $offset = ($page - 1) * $perPage;
        $items = new Collection;
        $remaining = $perPage;

        if ($offset < $noteTotal) {
            $noteSkip = $offset;
            $noteTake = min($remaining, $noteTotal - $noteSkip);

            $notes = $noteQuery
                ->orderBy('notes.created_at', 'desc')
                ->skip($noteSkip)
                ->take($noteTake)
                ->get();

            foreach ($notes as $note) {
                $items->push([
                    'type' => 'note',
                    'id' => $note->id,
                    'title' => $note->title,
                    'created_at' => $note->created_at,
                ]);
            }

            $remaining -= $notes->count();
        }

        if ($remaining > 0) {
            $fileSkip = max(0, $offset - $noteTotal);
            $fileTake = min($remaining, $fileTotal - $fileSkip);

            if ($fileTake > 0) {
                $files = $fileQuery
                    ->orderBy('files.created_at', 'desc')
                    ->skip($fileSkip)
                    ->take($fileTake)
                    ->get();

                foreach ($files as $file) {
                    $items->push([
                        'type' => 'file',
                        'id' => $file->id,
                        'title' => $file->file_name,
                        'created_at' => $file->created_at,
                    ]);
                }
            }
        }

        $results = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => route('search'),
                'query' => ['q' => $term],
            ]
        );

        return view('search.index', [
            'results' => $results,
            'q' => $term,
        ]);
    }
}
