@extends('layouts.app')

@section('title', $author->name . ' – Barangay Bulletin')

@section('content')

<a href="{{ route('posts.index') }}"
   class="inline-block border-b border-[#1F4D3A] pb-0.5 text-[14px] font-medium text-[#1F4D3A]">
    Bumalik sa lahat ng abiso
</a>

<div class="mt-6 rounded-[3px] border border-[#E2DCCB] bg-white px-6 py-8 sm:px-10">
    <p class="text-[13px] font-medium text-[#5C5749]">{{ $author->position }}</p>
    <h1 class="mt-1 text-[30px] font-semibold leading-tight sm:text-[38px]">{{ $author->name }}</h1>

    <div class="mt-5 flex flex-wrap gap-x-10 gap-y-3 border-t border-[#EFEAD9] pt-5">
        <div>
            <p class="font-notice text-[28px] font-semibold leading-none text-[#1F4D3A]">{{ $posts->count() }}</p>
            <p class="mt-1 text-[13px] text-[#7A7465]">published posts</p>
        </div>
        <div>
            <p class="font-notice text-[28px] font-semibold leading-none text-[#1F4D3A]">{{ $author->comments_count }}</p>
            <p class="mt-1 text-[13px] text-[#7A7465]">{{ $author->comments_count }} comments received</p>
        </div>
    </div>
</div>

<h2 class="mt-10 text-[22px] font-semibold">Posts by {{ $author->name }}</h2>

<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
    @forelse ($posts as $post)
        <article class="flex flex-col rounded-[3px] border border-[#E2DCCB] bg-white px-5 py-6">
            <p class="text-[12px] font-medium text-[#5C5749]">{{ $post->category }}</p>

            <h3 class="mt-2 text-[18px] font-semibold leading-[1.3]">
                <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                    {{ $post->title }}
                </a>
            </h3>

            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                       class="rounded-[3px] bg-[#F1EDE0] px-2 py-0.5 text-[11px] font-medium text-[#5C5749] hover:bg-[#E6E0CE]">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>

            <div class="mt-auto flex flex-wrap gap-x-5 gap-y-1 pt-5 text-[12px] text-[#8A8474]">
                <span>{{ $post->published_at->format('j M Y') }}</span>
                <span>{{ $post->comments_count }} comments</span>
            </div>
        </article>
    @empty
        <p class="col-span-full text-[14px] text-[#7A7465]">This official hasn't published any posts yet.</p>
    @endforelse
</div>

@endsection