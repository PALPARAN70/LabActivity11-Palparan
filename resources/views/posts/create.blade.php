@extends('layouts.app')

@section('title', 'New post – Barangay Bulletin')

@section('content')

<a href="{{ route('posts.index') }}"
   class="inline-block border-b border-[#1F4D3A] pb-0.5 text-[14px] font-medium text-[#1F4D3A]">
    Bumalik sa lahat ng abiso
</a>

<h1 class="mt-6 text-[30px] font-semibold leading-tight">New post</h1>
@if (auth()->user()->author)
    <p class="mt-1 text-[14px] text-[#7A7465]">
        Posting as {{ auth()->user()->author->name }}.
    </p>
@endif

<form method="POST" action="{{ route('posts.store') }}"
      class="mt-6 space-y-6 rounded-[3px] border border-[#E2DCCB] bg-white p-6 sm:p-8">
    @csrf

    @if ($errors->any())
        <div class="rounded-[3px] border border-[#A33A3A]/30 bg-[#FBEDED] px-4 py-3">
            <p class="text-[14px] font-medium text-[#7D2A2A]">Your post wasn't saved. Fix these and try again:</p>
            <ul class="mt-1 list-disc pl-5 text-[13px] text-[#7D2A2A]">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label for="title" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">Title</label>
        <input id="title" type="text" name="title" value="{{ old('title') }}"
               class="w-full rounded-[3px] border bg-white px-3 py-2.5 text-[15px]
                      focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20
                      @error('title') border-[#A33A3A] @else border-[#CFC7B2] focus:border-[#1F4D3A] @enderror">
        @error('title')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">Category</label>
        <select id="category" name="category"
                class="w-full rounded-[3px] border bg-white px-3 py-2.5 text-[15px] sm:w-auto
                       focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20
                       @error('category') border-[#A33A3A] @else border-[#CFC7B2] focus:border-[#1F4D3A] @enderror">
            <option value="">Choose a category</option>
            @foreach ($categories as $c)
                <option value="{{ $c }}" @selected(old('category') === $c)>{{ $c }}</option>
            @endforeach
        </select>
        @error('category')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="body" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">Body</label>
        <textarea id="body" name="body" rows="8"
                  class="w-full rounded-[3px] border bg-white px-3 py-2.5 text-[15px] leading-relaxed
                         focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20
                         @error('body') border-[#A33A3A] @else border-[#CFC7B2] focus:border-[#1F4D3A] @enderror">{{ old('body') }}</textarea>
        @error('body')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
    </div>

    <fieldset>
        <legend class="mb-2 text-[13px] font-medium text-[#5C5749]">Tags</legend>
        <div class="flex flex-wrap gap-2">
            @foreach ($tags as $tag)
                <label class="flex cursor-pointer items-center gap-2 rounded-[3px] border border-[#CFC7B2] px-3 py-2 text-[14px]
                              has-[:checked]:border-[#1F4D3A] has-[:checked]:bg-[#E8F1EB]">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                           @checked(in_array($tag->id, old('tags', [])))
                           class="accent-[#1F4D3A]">
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>
        @error('tags')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
        @error('tags.*')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
    </fieldset>

    <div>
        <label class="flex items-center gap-2 text-[14px]">
            <input type="checkbox" name="is_published" value="1"
                   @checked(old('is_published', true))
                   class="accent-[#1F4D3A]">
            Publish now
        </label>
        <p class="mt-1 pl-6 text-[13px] text-[#7A7465]">Unchecked saves it as a draft that residents can't see.</p>
        @error('is_published')
            <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
        @enderror
    </div>

    <div class="border-t border-[#EFEAD9] pt-5">
        <button type="submit"
                class="rounded-[3px] bg-[#1F4D3A] px-6 py-2.5 text-[15px] font-medium text-[#FAF6EC]
                       hover:bg-[#163A2B] focus:outline-none focus:ring-2 focus:ring-[#C9A227]">
            Save post
        </button>
    </div>
</form>

@endsection