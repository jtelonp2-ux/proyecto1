@extends('layout')

@section('contenido')
    <h1>Edit profile</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/profile/edit" method="post">
        {!! csrf_field() !!}

        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $usuario['name']) }}"><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $usuario['email']) }}"><br><br>

        <button type="submit">Save</button>
        <a href="/profile">Cancel</a>
    </form>
@endsection