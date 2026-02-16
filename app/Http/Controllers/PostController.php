<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private PostImageService $imageService)
    {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $posts = Post::query()
            ->with('user')
            ->published()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts', 'search'));
    }

    public function create(): View
    {
        $this->authorize('create', Post::class);

        return view('posts.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug'] = $this->makeUniqueSlug($data['title']);
        $data['published_at'] = now();

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageService->uploadAndCrop($request->file('image'));
        }

        $post = Post::create($data);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Пост создан.');
    }

    public function show(Post $post): View
    {
        $post->load('user');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        if ($data['title'] !== $post->title) {
            $data['slug'] = $this->makeUniqueSlug($data['title'], $post->id);
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageService->uploadAndCrop($request->file('image'), $post->image_path);
        }

        $post->update($data);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Пост обновлен.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $this->imageService->delete($post->image_path);
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('status', 'Пост удален.');
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;

        while (
            Post::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
