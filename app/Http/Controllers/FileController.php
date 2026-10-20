<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', File::class);

        $direction = request('direction') === 'asc' ? 'asc' : 'desc';

        $files = auth()->user()
            ->files()
            ->orderBy('created_at', $direction)
            ->paginate(10)
            ->withQueryString();

        return view('files.index', [
            'files' => $files,
            'direction' => $direction,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', File::class);

        return view('files.create');
    }

    public function store(StoreFileRequest $request): RedirectResponse
    {
        $this->authorize('create', File::class);

        $uploaded = $request->file('file');
        $extension = strtolower($uploaded->getClientOriginalExtension());
        $storedName = (string) Str::uuid().'.'.$extension;
        $directory = 'users/'.$request->user()->id.'/files';

        $uploaded->storeAs($directory, $storedName, 'local');

        $request->user()->files()->create([
            'file_name' => $uploaded->getClientOriginalName(),
            'file_path' => $directory.'/'.$storedName,
        ]);

        return redirect()->route('files.index')->with('status', 'Файл загружен.');
    }

    public function download(string $file): StreamedResponse
    {
        $fileModel = auth()->user()->files()->findOrFail($file);

        $this->authorize('view', $fileModel);

        abort_unless(Storage::disk('local')->exists($fileModel->file_path), 404);

        return Storage::disk('local')->download($fileModel->file_path, $fileModel->file_name);
    }

    public function destroy(string $file): RedirectResponse
    {
        $fileModel = auth()->user()->files()->findOrFail($file);

        $this->authorize('delete', $fileModel);

        $path = $fileModel->file_path;

        $fileModel->delete();

        Storage::disk('local')->delete($path);

        return redirect()->route('files.index')->with('status', 'Файл удалён.');
    }
}
