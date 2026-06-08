@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h1>Cart</h1>
    <div class="panel">
        <table data-cart-table>
            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>
            @forelse($cart->items as $item)
                <tr data-cart-row="{{ $item->id }}">
                    <td>{{ $item->product->name }}</td>
                    <td>₹{{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form class="row" method="POST" action="{{ route('cart.update', $item) }}" data-ajax-cart>
                            @csrf @method('PUT')
                            <input style="max-width: 100px;" type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                            <button class="btn secondary" type="submit">Update</button>
                        </form>
                    </td>
                    <td data-line-total>₹{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}" data-ajax-cart>
                            @csrf @method('DELETE')
                            <button class="btn danger" type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr data-empty-cart><td colspan="5">Your cart is empty.</td></tr>
            @endforelse
            @if($cart->items->isNotEmpty())
                <tr data-cart-total-row><th colspan="3">Total</th><th colspan="2">₹<span data-cart-total>{{ number_format($cart->total(), 2) }}</span></th></tr>
            @endif
        </table>
        @if($cart->items->isNotEmpty())
            <div class="row" data-checkout-link style="justify-content: flex-end; margin-top: 16px;">
                <a class="btn" href="{{ route('checkout.show') }}">Checkout</a>
            </div>
        @endif
    </div>
@endsection
