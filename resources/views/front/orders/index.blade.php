@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1>My Orders</h1>
    <div class="panel">
        <table>
            <tr><th>Order</th><th>Status</th><th>Payment</th><th>Total</th><th></th></tr>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>₹{{ number_format($order->total, 2) }}</td>
                    <td><a href="{{ route('orders.show', $order) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No orders yet.</td></tr>
            @endforelse
        </table>
        {{ $orders->links() }}
    </div>
@endsection
