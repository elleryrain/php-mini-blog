@extends('layouts.blog')

@section('title', 'Новый пост')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Новый пост</h1>
    @include('posts._form')
@endsection
