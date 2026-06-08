@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1>Checkout</h1>
    <div class="grid" style="grid-template-columns: minmax(0, 1fr) minmax(280px, 380px); align-items: start;">
        <form class="panel" method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <label>Name</label>
            <input name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required>
            <label>Phone</label>
            <input name="shipping_phone" value="{{ old('shipping_phone') }}" required>
            <label>Address</label>
            <textarea name="shipping_address" rows="5" required>{{ old('shipping_address') }}</textarea>
            <label>Payment Method</label>
            <select name="payment_method">
                <option value="cash_on_delivery">Cash on delivery</option>
            </select>
            <button class="btn" type="submit">Place Order</button>
        </form>
        <div class="panel">
            <h2>Summary</h2>
            @foreach($cart->items as $item)
                <div class="row" style="justify-content: space-between; border-bottom: 1px solid #d9e0e2; padding: 10px 0;">
                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                    <strong>₹{{ number_format($item->quantity * $item->product->price, 2) }}</strong>
                </div>
            @endforeach
            <p class="price">Total: ₹{{ number_format($cart->total(), 2) }}</p>
        </div>
    </div>
@endsection
