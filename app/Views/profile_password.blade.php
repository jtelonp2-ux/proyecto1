@extends('layout')

@section('contenido')
    <h1>Edit password</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="/profile/password" method="post">
        {!! csrf_field() !!}

        <label for="current_password">Current password</label><br>
        <input type="password" id="current_password" name="current_password"><br>

        <label for="new_password">New password</label><br>
        <input type="password" id="new_password" name="new_password"><br>

        <label for="new_password_confirm">Repeat new password</label><br>
        <input type="password" id="new_password_confirm" name="new_password_confirm"><br><br>

        <button type="submit">Save</button>
        <a href="/profile">Cancel</a>
    </form>
@endsection