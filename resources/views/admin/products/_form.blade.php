@csrf
<label>Category</label>
<select name="category_id" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
    @endforeach
</select>
<label>Name</label>
<input name="name" value="{{ old('name', $product->name ?? '') }}" required>
<label>Description</label>
<textarea name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
<label>Price</label>
<input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required>
<label>Stock</label>
<input type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
<label>Image URL</label>
<input name="image" value="{{ old('image', $product->image ?? '') }}">
<label class="row" style="font-weight: 400;">
    <input style="width: auto;" type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Active
</label>
<button class="btn" type="submit">{{ $button }}</button>
<a class="btn secondary" href="{{ route('admin.products.index') }}">Cancel</a>
