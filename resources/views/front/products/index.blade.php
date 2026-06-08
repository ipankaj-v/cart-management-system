@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="row" style="justify-content: space-between; margin-bottom: 18px;">
        <h1 style="margin: 0;">Products</h1>
        <form method="GET" action="{{ route('products.index') }}">
            <select name="category" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected($activeCategory === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="grid">
        @forelse($products as $product)
            <article class="card">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 6px;">
                @endif
                <p class="muted">{{ $product->category->name }}</p>
                <h2 style="font-size: 20px;">{{ $product->name }}</h2>
                <p class="price">₹{{ number_format($product->price, 2) }}</p>
                <p class="muted">{{ $product->stock }} in stock</p>
                <div class="row">
                    <a class="btn secondary" href="{{ route('products.show', $product) }}">View</a>
                    @auth
                        @unless(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('cart.store', $product) }}" data-ajax-cart>
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn" type="submit" @disabled($product->stock < 1)>Add</button>
                            </form>
                        @endunless
                    @endauth
                </div>
            </article>
        @empty
            <p>No products available.</p>
        @endforelse
    </div>
    {{ $products->links() }}
@endsection
