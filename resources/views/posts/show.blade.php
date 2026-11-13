@extends('layouts.app')

@section('title', $post->title . ' – Barangay Bulletin')

@section('content')

@php
    $ink = [
        'Announcement'  => 'text-[#2F6B4F]',
        'Health'        => 'text-[#A33A3A]',
        'Peace & Order' => 'text-[#2C4A7C]',
        'Ayuda'         => 'text-[#B07D0F]',
        'Lost & Found'  => 'text-[#6B3F72]',
    ];
    $edge = [
        'Announcement'  => 'border-l-[#2F6B4F]',
        'Health'        => 'border-l-[#A33A3A]',
        'Peace & Order' => 'border-l-[#2C4A7C]',
        'Ayuda'         => 'border-l-[#B07D0F]',
        'Lost & Found'  => 'border-l-[#6B3F72]',
    ];
@endphp

<a href="{{ route('posts.index') }}"
   class="inline-block border-b border-[#1F4D3A] pb-0.5 text-[14px] font-medium text-[#1F4D3A]">
    Bumalik sa lahat ng abiso
</a>

<article class="mt-6 rounded-[3px] border border-[#E2DCCB] border-l-[6px] bg-white px-6 py-8 sm:px-12 sm:py-12
                {{ $post->is_pinned ? 'border-l-[#C9A227]' : ($edge[$post->category] ?? 'border-l-[#CFC7B2]') }}">

    @if ($post->is_pinned)
        <p class="text-[13px] font-medium text-[#8A6E12]">Pinned</p>
    @endif

    <p class="mt-1 text-[13px] font-medium {{ $ink[$post->category] ?? 'text-[#4A463C]' }}">
        {{ $post->category }}
    </p>

    <h1 class="mt-3 max-w-[24ch] text-[30px] font-semibold leading-[1.12] sm:text-[42px]">
        {{ $post->title }}
    </h1>

    <p class="mt-3 text-[15px] text-[#5C5749]">
        ni
        <a href="{{ route('authors.show', $post->author) }}" class="font-medium text-[#1F4D3A] hover:underline">
            {{ $post->author->name }}
        </a>
        <span class="text-[#8A8474]">({{ $post->author->position }})</span>
    </p>

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach ($post->tags as $tag)
            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
               class="rounded-[3px] bg-[#F1EDE0] px-2.5 py-1 text-[12px] font-medium text-[#5C5749] hover:bg-[#E6E0CE]">
                {{ $tag->name }}
            </a>
        @endforeach
    </div>

    <div class="mt-5 flex flex-wrap gap-x-8 gap-y-2 border-y border-[#EFEAD9] py-4 text-[13px] text-[#7A7465]">
        <span>Published {{ $post->published_at->format('j F Y') }}</span>
        <span>{{ $post->views }} views</span>
        <span>{{ $post->comments->count() }} comments</span>
    </div>

    <div class="mt-7 max-w-[66ch] whitespace-pre-line text-[17px] leading-[1.75] text-[#3A362D]">
        {{ $post->body }}
    </div>

</article>

<section class="mt-10">

    <h2 class="text-[22px] font-semibold">Comments</h2>

        <div id="comment-form" class="mt-5">
        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}"
                  class="rounded-[3px] border border-[#E2DCCB] bg-white p-5">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 rounded-[3px] border border-[#A33A3A]/30 bg-[#FBEDED] px-4 py-3">
                        <p class="text-[14px] font-medium text-[#7D2A2A]">Your comment wasn't posted:</p>
                        <ul class="mt-1 list-disc pl-5 text-[13px] text-[#7D2A2A]">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="body" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">
                    Write a comment as {{ auth()->user()->name }}
                </label>

                <textarea id="body" name="body" rows="3"
                          class="w-full rounded-[3px] border bg-white px-3 py-2.5 text-[15px]
                                 focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20
                                 @error('body') border-[#A33A3A] @else border-[#CFC7B2] focus:border-[#1F4D3A] @enderror">{{ old('body') }}</textarea>

                @error('body')
                    <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="mt-3 rounded-[3px] bg-[#1F4D3A] px-5 py-2.5 text-[14px] font-medium text-[#FAF6EC]
                               hover:bg-[#163A2B] focus:outline-none focus:ring-2 focus:ring-[#C9A227]">
                    Post comment
                </button>
            </form>
        @else
            <div class="rounded-[3px] border border-dashed border-[#CFC7B2] bg-white px-5 py-5 text-[14px] text-[#5C5749]">
                <a href="{{ route('login') }}" class="font-medium text-[#1F4D3A] underline underline-offset-4">Sign in to comment</a>
                <span class="text-[#7A7465]"> on this post.</span>
            </div>
        @endauth
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($post->comments as $comment)
            <div class="rounded-[3px] border border-[#E2DCCB] bg-white px-5 py-4">
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                    <p class="text-[14px] font-medium text-[#27251E]">{{ $comment->user->name }}</p>
                    <p class="text-[12px] text-[#8A8474]">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <p class="mt-2 text-[15px] leading-[1.6] text-[#3A362D]">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-[14px] text-[#7A7465]">No comments yet. Be the first to comment.</p>
        @endforelse
    </div>

</section>

@endsection