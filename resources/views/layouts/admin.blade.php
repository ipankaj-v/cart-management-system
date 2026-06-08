@extends('layouts.app')

@section('content')
    <div class="row" style="justify-content: space-between; margin-bottom: 20px;">
        <h1 style="margin: 0;">Admin</h1>
        <nav class="row">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.categories.index') }}">Categories</a>
            <a href="{{ route('admin.products.index') }}">Products</a>
            <a href="{{ route('admin.orders.index') }}">Orders</a>
        </nav>
    </div>
    @yield('admin')
@endsection
