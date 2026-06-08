@extends('layouts.admin')

@section('title', 'Add Product')

@section('admin')
    <div class="panel">
        <h2>Add Product</h2>
        <form method="POST" action="{{ route('admin.products.store') }}">
            @include('admin.products._form', ['button' => 'Create'])
        </form>
    </div>
@endsection
