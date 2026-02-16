@php
    $isEdit = isset($post);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('posts.update', $post) : route('posts.store') }}"
    enctype="multipart/form-data"
    class="bg-white rounded border p-6 space-y-4"
>
    @csrf
    @if($isEdit)
        @method('PATCH')
    @endif

    <div>
        <label class="block mb-1 font-medium">Заголовок</label>
        <input
            type="text"
            name="title"
            value="{{ old('title', $post->title ?? '') }}"
            class="w-full rounded border px-3 py-2"
            required
        >
    </div>

    <div>
        <label class="block mb-1 font-medium">Краткое описание</label>
        <textarea
            name="excerpt"
            rows="3"
            class="w-full rounded border px-3 py-2"
        >{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    </div>

    <div>
        <label class="block mb-1 font-medium">Текст поста</label>
        <textarea
            name="body"
            rows="10"
            class="w-full rounded border px-3 py-2"
            required
        >{{ old('body', $post->body ?? '') }}</textarea>
    </div>

    <div>
        <label class="block mb-1 font-medium">Изображение</label>
        <input type="file" name="image" accept="image/*" class="block">
        <p class="text-sm text-gray-600 mt-1">JPG/PNG/WebP, до 5MB. Кадрируется в 1200x630.</p>
    </div>

    @if($isEdit && $post->image_path)
        <img src="{{ asset('storage/'.$post->image_path) }}" alt="" class="w-64 rounded border">
    @endif

    <button class="px-4 py-2 rounded bg-black text-white">
        {{ $isEdit ? 'Сохранить' : 'Создать' }}
    </button>
</form>
