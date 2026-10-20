<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        $direction = request('direction') === 'asc' ? 'asc' : 'desc';

        $categories = auth()->user()
            ->categories()
            ->orderBy('created_at', $direction)
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', [
            'categories' => $categories,
            'direction' => $direction,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->authorize('create', Category::class);

        auth()->user()->categories()->create($request->validated());

        return redirect()->route('categories.index')->with('status', 'Категория создана.');
    }

    public function edit(string $category): View
    {
        $categoryModel = auth()->user()->categories()->findOrFail($category);

        $this->authorize('update', $categoryModel);

        return view('categories.edit', [
            'category' => $categoryModel,
        ]);
    }

    public function update(UpdateCategoryRequest $request, string $category): RedirectResponse
    {
        $categoryModel = auth()->user()->categories()->findOrFail($category);

        $this->authorize('update', $categoryModel);

        $categoryModel->update($request->validated());

        return redirect()->route('categories.index')->with('status', 'Категория обновлена.');
    }

    public function destroy(string $category): RedirectResponse
    {
        $categoryModel = auth()->user()->categories()->findOrFail($category);

        $this->authorize('delete', $categoryModel);

        $categoryModel->delete();

        return redirect()->route('categories.index')->with('status', 'Категория удалена.');
    }
}
