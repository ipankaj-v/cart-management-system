@extends('layouts.admin')

@section('title', 'Categories')

@section('admin')
    <div class="row" style="justify-content: space-between; margin-bottom: 14px;">
        <h2>Categories</h2>
        <a class="btn" href="{{ route('admin.categories.create') }}">Add Category</a>
    </div>
    <table>
        <tr><th>Name</th><th>Status</th><th>Products</th><th></th></tr>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                <td class="row">
                    <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No categories found.</td></tr>
        @endforelse
    </table>
    {{ $categories->links() }}
@endsection
