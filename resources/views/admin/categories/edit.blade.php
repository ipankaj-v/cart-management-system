@extends('layouts.admin')

@section('title', 'Edit Category')

@section('admin')
    <div class="panel">
        <h2>Edit Category</h2>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @method('PUT')
            @include('admin.categories._form', ['button' => 'Update'])
        </form>
    </div>
@endsection
