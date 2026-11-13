<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($tagQuery) use ($request) {
                    $tagQuery->where('name', $request->input('tag'));
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(8)
            ->withQueryString();

        $categories = Post::query()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($id)
    {
        $post = Post::where('is_published', true)->findOrFail($id);

        $post->views = $post->views + 1;
        $post->save();

        $post->load([
            'author',
            'tags',
            'comments' => function ($query) {
                $query->latest()->latest('id');
            },
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = ['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Lost & Found'];
        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->safe()->except('tags');
        $data['published_at'] = $data['is_published'] ? now() : null;

        $post = $request->user()->author->posts()->create($data);
        $post->tags()->sync($request->validated('tags'));

        if ($post->is_published) {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('status', 'Post published.');
        }

        return redirect()
            ->route('posts.index')
            ->with('status', 'Draft saved. It will not appear on the bulletin until it is published.');
    }
}