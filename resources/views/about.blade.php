@extends('layouts.main')

@section('container')
    <h2>{{ $title }}</h2>
    <h3>{{ $name }}</h3>
    <p>{{ $email }}</p>
    <img src="img/{{ $image }}" alt="Fharist" width="200">
@endsection
