<label>
    Название
    <input type="text" name="title" value="{{ old('title', $note?->title ?? '') }}" maxlength="255" required>
</label>
@error('title')
    <p class="error">{{ $message }}</p>
@enderror

<label>
    Текст
    <textarea name="content" rows="8" required>{{ old('content', $note?->content ?? '') }}</textarea>
</label>
@error('content')
    <p class="error">{{ $message }}</p>
@enderror

<label>
    Категория
    <select name="category_id">
        <option value="">Без категории</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('category_id', $note?->category_id) == $cat->id)>{{ $cat->category_title }}</option>
        @endforeach
    </select>
</label>
@error('category_id')
    <p class="error">{{ $message }}</p>
@enderror

<label>
    Файл
    <select name="file_id">
        <option value="">Без файла</option>
        @foreach ($files as $file)
            <option value="{{ $file->id }}" @selected(old('file_id', $note?->file_id) == $file->id)>{{ $file->file_name }}</option>
        @endforeach
    </select>
</label>
@error('file_id')
    <p class="error">{{ $message }}</p>
@enderror

<label>
    Срок (необязательно)
    <input type="date" name="due_date" value="{{ old('due_date', $note?->due_date?->format('Y-m-d') ?? '') }}">
</label>
@error('due_date')
    <p class="error">{{ $message }}</p>
@enderror

<div class="checkbox-field">
    <input type="checkbox" id="is_completed" name="is_completed" value="1" @checked(old('is_completed', $note?->is_completed ?? false))>
    <label for="is_completed">Выполнено</label>
</div>
@error('is_completed')
    <p class="error">{{ $message }}</p>
@enderror

<div class="form-actions">
    <button type="submit" class="button">{{ $submitText }}</button>
    <a class="button secondary" href="{{ route('notes.index') }}">Отмена</a>
</div>
