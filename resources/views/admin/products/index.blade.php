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
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $product)
                                @php $profit = $product->price - $product->cost_price; @endphp
                                <tr class="border-t border-[#F4B6C2]/50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if ($product->cover)
                                                <img src="{{ asset($product->cover) }}" alt="{{ $product->name }}"
                                                     class="h-10 w-10 rounded-lg object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-[#FDE8EC]"></div>
                                            @endif
                                            <span class="font-medium">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">@money($product->cost_price)</td>
                                    <td class="px-4 py-3 whitespace-nowrap">@money($product->price)</td>
                                    <td class="px-4 py-3 whitespace-nowrap {{ $profit < 0 ? 'text-red-600' : '' }}">@money($profit)</td>
                                    <td class="px-4 py-3">{{ $product->initial_sold }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('admin.products.stock', $product) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" title="Click to change"
                                                    class="rounded-full px-3 py-1 text-xs whitespace-nowrap {{ $product->in_stock ? 'bg-[#E4F5E9]' : 'bg-[#FDE8EC]' }}">
                                                {{ $product->in_stock ? 'In stock' : 'Out of stock' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                               class="cc-btn cc-btn-sm cc-btn-soft">Edit</a>

                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                  onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="cc-btn cc-btn-sm bg-white text-red-700 border-red-200 hover:bg-red-50">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center opacity-70">
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