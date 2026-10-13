@extends('layout')

@section('contenido')
    <h1>New Task</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/tasks" method="post">
        {!! csrf_field() !!}

        <label for="description">Description</label><br>
        <input type="text" id="description" name="description" value="{{ old('description') }}"><br><br>

        <button type="submit">Send</button>
        <a href="/tasks">Cancel</a>
    </form>
@endsection