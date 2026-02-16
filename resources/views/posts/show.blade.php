@extends('layouts.blog')

@section('title', $post->title)

@section('content')
    <article class="bg-white rounded border p-6">
        <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>

        <p class="text-sm text-gray-600 mb-4">
            Автор: {{ $post->user->name }} · {{ optional($post->published_at)->format('d.m.Y H:i') }}
        </p>

        @if ($post->image_path)
            <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" class="mb-4 rounded">
        @endif

        @if ($post->excerpt)
            <p class="text-lg mb-4">{{ $post->excerpt }}</p>
        @endif

        <div class="prose max-w-none whitespace-pre-line">{{ $post->body }}</div>

        @can('update', $post)
            <div class="mt-6 flex gap-2">
                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 rounded border">Редактировать</a>

                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 rounded bg-red-600 text-white"
                            onclick="return confirm('Удалить пост?')">
                        Удалить
                    </button>
                </form>
            </div>
        @endcan
    </article>
@endsection
