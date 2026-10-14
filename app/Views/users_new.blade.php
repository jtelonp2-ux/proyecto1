@extends('layout')

@section('contenido')
    <h1>New User</h1>

    <a href="/users">&lt;&lt; back to index</a>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/users" method="post">
        {!! csrf_field() !!}

        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}"><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="password_confirm">Repeat password</label><br>
        <input type="password" id="password_confirm" name="password_confirm"><br><br>

        <button type="submit">Save</button>
        <a href="/users">Cancel</a>
    </form>
@endsection