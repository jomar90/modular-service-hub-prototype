<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Service Hub') — Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#1e3a5f', light: '#2d5282', muted: '#4a7ab5' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-56 min-h-screen bg-brand text-white flex flex-col flex-shrink-0">
        <div class="px-6 py-5 border-b border-brand-light">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold tracking-wide hover:text-blue-200">
                ⬡ Service Hub
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <p class="text-xs uppercase tracking-widest text-blue-300 px-2 mb-3">Services</p>

            <a href="{{ route('customers.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded-md text-sm transition
                      {{ request()->is('customers*') ? 'bg-brand-light font-semibold' : 'hover:bg-brand-light' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Customers
            </a>

            <a href="{{ route('invoices.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded-md text-sm transition
                      {{ request()->is('invoices*') ? 'bg-brand-light font-semibold' : 'hover:bg-brand-light' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Invoices
            </a>
        </nav>

        <div class="px-6 py-4 border-t border-brand-light text-xs text-blue-300">
            Modular Service Hub
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <h1 class="text-gray-800 font-semibold text-lg">@yield('title', 'Dashboard')</h1>
        </header>

        <main class="flex-1 px-8 py-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
