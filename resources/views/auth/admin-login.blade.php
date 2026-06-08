@extends('layouts.auth-admin')

@section('title', 'Admin Login')

@section('content')
    <div class="panel">
        <h1 class="brand">Admin Login</h1>
        <p class="muted">Sign in to manage categories, products, and orders.</p>

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label>Password</label>
            <input type="password" name="password" required>
            <label class="row" style="font-weight: 400;">
                <input style="width: auto;" type="checkbox" name="remember" value="1"> Remember me
            </label>
            <button class="btn" type="submit">Login</button>
        </form>
    </div>
@endsection
