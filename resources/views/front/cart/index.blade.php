@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h1>Cart</h1>
    <div class="panel">
        <table>
            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>
            @forelse($cart->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>₹{{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form class="row" method="POST" action="{{ route('cart.update', $item) }}">
                            @csrf @method('PUT')
                            <input style="max-width: 100px;" type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                            <button class="btn secondary" type="submit">Update</button>
                        </form>
                    </td>
                    <td>₹{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}">
                            @csrf @method('DELETE')
                            <button class="btn danger" type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Your cart is empty.</td></tr>
            @endforelse
            @if($cart->items->isNotEmpty())
                <tr><th colspan="3">Total</th><th colspan="2">₹{{ number_format($cart->total(), 2) }}</th></tr>
            @endif
        </table>
        @if($cart->items->isNotEmpty())
            <div class="row" style="justify-content: flex-end; margin-top: 16px;">
                <a class="btn" href="{{ route('checkout.show') }}">Checkout</a>
            </div>
        @endif
    </div>
@endsection
