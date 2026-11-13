<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin – Purok Palparan')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@500;600;700&family=Inter:wght@400;500;600&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FAF6EC] text-[#27251E]">

    <header class="bg-[#1F4D3A]">
        <div class="mx-auto flex max-w-4xl flex-col gap-4 px-5 pt-8 pb-7 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-[13px] text-[#9BBCA8]">Barangay Matina Crossing, Davao City</p>
                <p class="font-notice mt-1 text-[28px] font-semibold leading-tight text-[#FAF6EC] sm:text-[36px]">
                    <a href="{{ route('posts.index') }}">Barangay Bulletin</a>
                </p>
                <p class="mt-1 text-[15px] text-[#C7DBCF]">Purok Palparan</p>
            </div>

            <nav class="flex flex-wrap items-center gap-x-5 gap-y-2 text-[14px]">
                @auth
                    <span class="text-[#C7DBCF]">{{ auth()->user()->name }}</span>

                    @if (auth()->user()->author)
                        <a href="{{ route('posts.create') }}"
                           class="rounded-[3px] bg-[#C9A227] px-4 py-2 font-medium text-[#27251E] hover:bg-[#D9B23A]">
                            New post
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[#FAF6EC] underline-offset-4 hover:underline">
                            Sign out
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="rounded-[3px] border border-[#9BBCA8] px-4 py-2 text-[#FAF6EC] hover:bg-[#2A5E48]">
                        Sign in
                    </a>
                @endguest
            </nav>

        </div>
        <div class="h-[3px] bg-[#C9A227]"></div>
    </header>

    <main class="mx-auto max-w-4xl px-5 py-10">

        @if (session('status'))
            <div class="mb-8 rounded-[3px] border border-[#2F6B4F]/30 bg-[#E8F1EB] px-4 py-3 text-[14px] text-[#1F4D3A]">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mx-auto max-w-4xl px-5 pb-12">
        <div class="border-t border-[#E2DCCB] pt-5 text-[13px] leading-relaxed text-[#7A7465]">
            Mga abiso mula sa Barangay Matina Crossing Hall.
        </div>
    </footer>

</body>
</html>