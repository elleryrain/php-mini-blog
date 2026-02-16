@extends('layouts.blog')

@section('title', $search ? "Поиск: {$search}" : 'Все посты')

@section('content')
<form method="GET" action="{{ route('posts.index') }}" class="card p-4 mb-6 flex gap-2">
    <input type="text" name="q" value="{{ $search }}" placeholder="Поиск по блогу..." class="field">
    <button class="btn-primary">Найти</button>
</form>

<div class="grid gap-5 md:grid-cols-2">
    @forelse($posts as $post)
        <article class="card p-5 hover:shadow-md transition">
            @if ($post->image_path)
                <a href="{{ route('posts.show', $post) }}">
                    <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" class="rounded-xl mb-4 w-full h-52 object-cover">
                </a>
            @endif

            <h2 class="text-2xl font-bold leading-tight mb-2">
                <a href="{{ route('posts.show', $post) }}" class="hover:text-orange-700 transition">{{ $post->title }}</a>
            </h2>

            <p class="text-sm text-gray-500 mb-3">
                {{ $post->user->name }} · {{ optional($post->published_at)->format('d.m.Y H:i') }}
            </p>

            <p class="text-gray-700">{{ $post->excerpt ?: \Illuminate\Support\Str::limit($post->body, 180) }}</p>
        </article>
    @empty
        <div class="card p-6">Постов пока нет.</div>
    @endforelse
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
