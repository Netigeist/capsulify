<label>
    Название категории
    <input type="text" name="category_title" value="{{ old('category_title', $category->category_title ?? '') }}"
        maxlength="25" required>
</label>

@error('category_title')
    <p class="error">{{ $message }}</p>
@enderror

<div class="form-actions">
    <button type="submit" class="button">{{ $submitText }}</button>
    <a class="button secondary" href="{{ route('categories.index') }}">Отмена</a>
</div>
