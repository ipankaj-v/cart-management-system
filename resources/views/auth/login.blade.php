@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="panel" style="max-width: 460px; margin: 0 auto;">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label class="row" style="font-weight: 400;">
                <input style="width: auto;" type="checkbox" name="remember" value="1"> Remember me
            </label>
            <button class="btn" type="submit">Login</button>
        </form>
    </div>
@endsection
