@extends('layouts.app')

@section('title', $order->order_number)

@section('content')
    <div class="panel">
        <h1>{{ $order->order_number }}</h1>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Payment:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Shipping:</strong> {{ $order->shipping_name }}, {{ $order->shipping_phone }}<br>{{ $order->shipping_address }}</p>
    </div>
    <div class="panel" style="margin-top: 20px;">
        <table>
            <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            <tr><th colspan="3">Grand Total</th><th>₹{{ number_format($order->total, 2) }}</th></tr>
        </table>
    </div>
@endsection
