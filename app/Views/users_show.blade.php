@extends('layout')

@section('contenido')
    <h1>User</h1>

    <a href="/users">&lt;&lt; back to index</a>

    <p><strong>name</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>email</strong><br>{{ $usuario['email'] }}</p>
    <p><strong>active</strong><br>{{ $usuario['active'] ? 'yes' : 'no' }}</p>
    <p><strong>Administrator</strong><br>{{ $usuario['administrator'] ? 'Yes' : 'No' }}</p>
    <p><strong>Created at</strong><br>{{ $usuario['created_at'] }}</p>
    <p><strong>Updated at</strong><br>{{ $usuario['updated_at'] }}</p>

    <a href="/users/{{ $usuario['id'] }}/edit">Edit</a>

    <form action="/users/{{ $usuario['id'] }}/delete" method="post"
          onsubmit="return confirm('Are you sure?');">
        {!! csrf_field() !!}
        <button type="submit">Delete</button>
    </form>
@endsection