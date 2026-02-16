@extends('layouts.blog')

@section('title', 'Редактирование: '.$post->title)

@section('content')
    <h1 class="text-2xl font-bold mb-4">Редактирование поста</h1>
    @include('posts._form', ['post' => $post])
@endsection
