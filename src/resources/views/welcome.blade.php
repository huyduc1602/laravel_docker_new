@extends('layouts.app', ['activePage' => 'login', 'titlePage' => __('Login')])

@section('content')
    <button><a href="{{ route('logout') }}">Logout</a></button>
@endsection
