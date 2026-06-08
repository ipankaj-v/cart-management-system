@csrf
<label>Name</label>
<input name="name" value="{{ old('name', $category->name ?? '') }}" required>
<label>Description</label>
<textarea name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
<label class="row" style="font-weight: 400;">
    <input style="width: auto;" type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Active
</label>
<button class="btn" type="submit">{{ $button }}</button>
<a class="btn secondary" href="{{ route('admin.categories.index') }}">Cancel</a>
