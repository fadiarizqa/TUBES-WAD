@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Selamat datang, {{ Auth::user()->name }}!</h1>
    <p>Ini adalah halaman utama setelah login.</p>
@endsection


