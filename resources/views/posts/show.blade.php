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

    {{-- Comment form goes here in Step 20 --}}

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