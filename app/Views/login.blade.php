@extends('layout')

@section('contenido')
    <h1>Login</h1>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="/login" method="post">
        {!! csrf_field() !!}

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br>

        <label>
            <input type="checkbox" name="remember" value="1"> Remember me
        </label><br><br>

        <button type="submit">Log in</button>
        <a href="#">Forgot password?</a>
    </form>
@endsection