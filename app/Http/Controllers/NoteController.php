<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Note::class);

        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';
        $category = $request->query('category');

        $query = $request->user()->notes()->with(['category', 'file']);

        if ($category === 'none') {
            $query->whereNull('category_id');
        } elseif (is_numeric($category)) {
            $query->where('category_id', (int) $category);
        }

        $notes = $query
            ->orderBy('created_at', $direction)
            ->paginate(10)
            ->withQueryString();

        return view('notes.index', [
            'notes' => $notes,
            'direction' => $direction,
            'category' => $category,
            'categories' => $request->user()->categories()->orderBy('category_title')->get(),
            'filterParams' => array_filter(['category' => $category ?: null]),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Note::class);

        return view('notes.create', [
            'categories' => $request->user()->categories()->orderBy('category_title')->get(),
            'files' => $request->user()->files()->orderBy('file_name')->get(),
        ]);
    }

    public function store(StoreNoteRequest $request): RedirectResponse
    {
        $this->authorize('create', Note::class);

        $request->user()->notes()->create($request->validated());

        return redirect()->route('notes.index')->with('status', 'Заметка создана.');
    }

    public function show(Request $request, string $note): View
    {
        $noteModel = $request->user()->notes()->with(['category', 'file'])->findOrFail($note);

        $this->authorize('view', $noteModel);

        return view('notes.show', [
            'note' => $noteModel,
        ]);
    }

    public function edit(Request $request, string $note): View
    {
        $noteModel = $request->user()->notes()->findOrFail($note);

        $this->authorize('update', $noteModel);

        return view('notes.edit', [
            'note' => $noteModel,
            'categories' => $request->user()->categories()->orderBy('category_title')->get(),
            'files' => $request->user()->files()->orderBy('file_name')->get(),
        ]);
    }

    public function update(UpdateNoteRequest $request, string $note): RedirectResponse
    {
        $noteModel = $request->user()->notes()->findOrFail($note);

        $this->authorize('update', $noteModel);

        $noteModel->update($request->validated());

        return redirect()->route('notes.index')->with('status', 'Заметка обновлена.');
    }

    public function destroy(Request $request, string $note): RedirectResponse
    {
        $noteModel = $request->user()->notes()->findOrFail($note);

        $this->authorize('delete', $noteModel);

        $noteModel->delete();

        return redirect()->route('notes.index')->with('status', 'Заметка удалена.');
    }
}
