@extends('layouts.app', ['activePage' => 'login', 'titlePage' => __('Login')])

@section('content')
    <button>Reset</button>
    <button><a href="{{ route('login') }}">BACK</a></button>
@endsection
