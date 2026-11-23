<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="cc-script text-3xl font-bold">Products</h2>
            <a href="{{ route('admin.products.create') }}" class="cc-btn cc-btn-sm cc-btn-solid">+ Add product</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="rounded-xl bg-[#FDE8EC] border border-[#F4B6C2] px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @foreach ([['Handmade', $handcrafts], ['Imported', $imported]] as [$title, $items])
                <div class="cc-card overflow-x-auto">
                    <h3 class="cc-script text-3xl font-bold px-4 pt-4">{{ $title }}</h3>

                    <table class="min-w-full text-sm mt-3">
                        <thead>
                            <tr class="bg-[#FDE8EC] text-left">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Cost</th>
                                <th class="px-4 py-3">Selling at</th>
                                <th class="px-4 py-3">Profit (per piece)</th>
                                <th class="px-4 py-3">Sold pieces</th>
                                <th class="px-4 py-3">Availability</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $product)
                                @php $profit = $product->price - $product->cost_price; @endphp
                                <tr class="border-t border-[#F4B6C2]/50">
                                    <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">@money($product->cost_price)</td>
                                    <td class="px-4 py-3 whitespace-nowrap">@money($product->price)</td>
                                    <td class="px-4 py-3 whitespace-nowrap {{ $profit < 0 ? 'text-red-600' : '' }}">@money($profit)</td>
                                    <td class="px-4 py-3">{{ $product->initial_sold }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-3 py-1 text-xs whitespace-nowrap {{ $product->in_stock ? 'bg-[#E4F5E9]' : 'bg-[#FDE8EC]' }}">
                                            {{ $product->in_stock ? 'In stock' : 'Out of stock' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center opacity-70">
                                        No {{ strtolower($title) }} products yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>