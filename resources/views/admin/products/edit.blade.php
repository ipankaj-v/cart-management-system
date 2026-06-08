@extends('layouts.admin')

@section('title', 'Edit Product')

@section('admin')
    <div class="panel">
        <h2>Edit Product</h2>
        <form method="POST" action="{{ route('admin.products.update', $product) }}">
            @method('PUT')
            @include('admin.products._form', ['button' => 'Update'])
        </form>
    </div>
@endsection
