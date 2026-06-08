@extends('layouts.admin')

@section('title', 'Add Category')

@section('admin')
    <div class="panel">
        <h2>Add Category</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @include('admin.categories._form', ['button' => 'Create'])
        </form>
    </div>
@endsection
