@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin')
    <div class="grid">
        <div class="card"><h3>Categories</h3><p class="price">{{ $categoryCount }}</p></div>
        <div class="card"><h3>Products</h3><p class="price">{{ $productCount }}</p></div>
        <div class="card"><h3>Orders</h3><p class="price">{{ $orderCount }}</p></div>
        <div class="card"><h3>Customers</h3><p class="price">{{ $customerCount }}</p></div>
    </div>
    <div class="panel" style="margin-top: 20px;">
        <h2>Recent Orders</h2>
        <table>
            <tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th><th></th></tr>
            @forelse($recentOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>₹{{ number_format($order->total, 2) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No orders yet.</td></tr>
            @endforelse
        </table>
    </div>
@endsection
