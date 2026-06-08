@extends('layouts.admin')

@section('title', 'Orders')

@section('admin')
    <h2>Orders</h2>
    <table>
        <tr><th>Order</th><th>Customer</th><th>Status</th><th>Payment</th><th>Total</th><th></th></tr>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
                <td>₹{{ number_format($order->total, 2) }}</td>
                <td><a href="{{ route('admin.orders.show', $order) }}">Manage</a></td>
            </tr>
        @empty
            <tr><td colspan="6">No orders found.</td></tr>
        @endforelse
    </table>
    {{ $orders->links() }}
@endsection
