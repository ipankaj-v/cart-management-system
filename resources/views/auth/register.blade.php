@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="panel" style="max-width: 460px; margin: 0 auto;">
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
            <button class="btn" type="submit">Create account</button>
        </form>
    </div>
@endsection
