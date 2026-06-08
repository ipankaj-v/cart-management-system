@extends('layouts.admin')

@section('title', 'Order '.$order->order_number)

@section('admin')
    <div class="panel">
        <h2>{{ $order->order_number }}</h2>
        <p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Ship to:</strong> {{ $order->shipping_name }}, {{ $order->shipping_phone }}<br>{{ $order->shipping_address }}</p>
        <form class="row" method="POST" action="{{ route('admin.orders.update', $order) }}">
            @csrf @method('PUT')
            <div>
                <label>Status</label>
                <select name="status">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Payment</label>
                <select name="payment_status">
                    @foreach($paymentStatuses as $status)
                        <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn" type="submit">Update</button>
        </form>
        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Delete this order?')" style="margin-top: 12px;">
            @csrf @method('DELETE')
            <button class="btn danger" type="submit">Delete Order</button>
        </form>
    </div>
    <div class="panel" style="margin-top: 20px;">
        <h3>Items</h3>
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
