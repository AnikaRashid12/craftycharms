<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/crafty-charms-logo.jpg') }}" alt="Crafty Charms"
                 class="h-12 w-12 rounded-full border-2 border-[#F4B6C2]">
            <h2 class="cc-script text-3xl font-bold">Admin Dashboard</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="cc-card p-6">
                <p class="cc-script text-2xl">Welcome back, {{ auth()->user()->name }} ♡</p>
                <p class="mt-1 text-sm opacity-80">Handmade with love, made for you.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ([
                    ['Products', 'Upload and edit items'],
                    ['Orders', 'Update order status'],
                    ['Sales & Profit', 'Track revenue and profit'],
                ] as [$title, $text])
                    <div class="cc-card p-6">
                        <h3 class="font-semibold text-lg">{{ $title }}</h3>
                        <p class="mt-1 text-sm opacity-80">{{ $text }}</p>
                        <span class="inline-block mt-3 text-xs rounded-full px-3 py-1 bg-[#FDE8EC]">Coming soon</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>