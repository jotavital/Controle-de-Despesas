@extends('layouts.main')

@section('menuNav')
    <li class="nav-item">
        <a href="/" class="nav-link">Home</a>
    </li>
    <li class="nav-item">
        <a href="/users/login" class="nav-link">Login</a>
    </li>
    <li class="nav-item">
        <a href="/users/create" class="nav-link">Cadastro</a>
    </li>
@endsection