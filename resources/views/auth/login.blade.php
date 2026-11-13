@extends('layouts.app')

@section('title', 'Sign in – Barangay Bulletin')

@section('content')

<div class="mx-auto max-w-sm">

    <h1 class="text-[28px] font-semibold leading-tight">Sign in</h1>
    <p class="mt-1 text-[14px] text-[#7A7465]">
        Residents sign in to comment. Barangay officials sign in to post.
    </p>

    <form method="POST" action="{{ route('login') }}"
          class="mt-6 space-y-5 rounded-[3px] border border-[#E2DCCB] bg-white p-6">
        @csrf

        <div>
            <label for="email" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus
                   class="w-full rounded-[3px] border border-[#CFC7B2] bg-white px-3 py-2.5 text-[15px]
                          focus:border-[#1F4D3A] focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20">
            @error('email')
                <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-[13px] font-medium text-[#5C5749]">Password</label>
            <input id="password" type="password" name="password"
                   class="w-full rounded-[3px] border border-[#CFC7B2] bg-white px-3 py-2.5 text-[15px]
                          focus:border-[#1F4D3A] focus:outline-none focus:ring-2 focus:ring-[#1F4D3A]/20">
            @error('password')
                <p class="mt-1.5 text-[13px] text-[#A33A3A]">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full rounded-[3px] bg-[#1F4D3A] py-2.5 text-[15px] font-medium text-[#FAF6EC]
                       hover:bg-[#163A2B] focus:outline-none focus:ring-2 focus:ring-[#C9A227]">
            Sign in
        </button>
    </form>

</div>

@endsection