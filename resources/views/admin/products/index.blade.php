@extends('layouts.admin')

@section('title', 'Products')

@section('admin')
    <div class="row" style="justify-content: space-between; margin-bottom: 14px;">
        <h2>Products</h2>
        <a class="btn" href="{{ route('admin.products.create') }}">Add Product</a>
    </div>
    <table>
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="row">
                    <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No products found.</td></tr>
        @endforelse
    </table>
    {{ $products->links() }}
@endsection
