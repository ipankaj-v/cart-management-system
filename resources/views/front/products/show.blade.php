@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="panel">
        <div class="row" style="align-items: flex-start;">
            @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: min(360px, 100%); border-radius: 8px;">
            @endif
            <div style="flex: 1; min-width: 260px;">
                <p class="muted">{{ $product->category->name }}</p>
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <p class="price">₹{{ number_format($product->price, 2) }}</p>
                <p class="muted">{{ $product->stock }} in stock</p>
                @auth
                    @unless(auth()->user()->isAdmin())
                        <form class="row" method="POST" action="{{ route('cart.store', $product) }}">
                            @csrf
                            <input style="max-width: 110px;" type="number" name="quantity" value="1" min="1" max="{{ max($product->stock, 1) }}">
                            <button class="btn" type="submit" @disabled($product->stock < 1)>Add to Cart</button>
                        </form>
                    @endunless
                @else
                    <a class="btn" href="{{ route('login') }}">Login to buy</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
