<x-app-layout>
    <x-slot name="header">
        <h2 class="cc-script text-3xl font-bold">Edit product</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-xl bg-[#FDE8EC] border border-[#F4B6C2] px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="cc-card p-6">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category" value="Section" />
                        <select id="category" name="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E88CA0] focus:ring-[#E88CA0]">
                            @foreach (\App\Models\Product::CATEGORIES as $key => $label)
                                <option value="{{ $key }}" @selected(old('category', $product->category) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E88CA0] focus:ring-[#E88CA0]">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-3">
                        <div>
                            <x-input-label for="price" value="Selling price" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cost_price" value="Cost price (admin only)" />
                            <x-text-input id="cost_price" name="cost_price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('cost_price', $product->cost_price)" required />
                            <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="initial_sold" value="Sold so far (admin only)" />
                            <x-text-input id="initial_sold" name="initial_sold" type="number" min="0" class="mt-1 block w-full" :value="old('initial_sold', $product->initial_sold)" />
                            <x-input-error :messages="$errors->get('initial_sold')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="images" value="Add more photos (up to 8 in total, 4 MB each)" />
                        <input id="images" name="images[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm">
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        <x-input-error :messages="collect($errors->get('images.*'))->flatten()->all()" class="mt-2" />
                    </div>

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="in_stock" value="1" @checked($errors->any() ? old('in_stock') : $product->in_stock)
                               class="rounded border-gray-300 text-[#E88CA0] focus:ring-[#E88CA0]">
                        <span class="text-sm">In stock</span>
                    </label>

                    <div class="flex items-center gap-3 pt-2">
                        <x-primary-button>Save changes</x-primary-button>
                        <a href="{{ route('admin.products.index') }}" class="text-sm underline">Cancel</a>
                    </div>
                </form>
            </div>

            <!-- Current photos (separate forms, so they sit outside the form above) -->
            <div class="cc-card p-6">
                <h3 class="cc-script text-2xl font-bold">Current photos</h3>

                @if ($product->images->isEmpty())
                    <p class="mt-2 text-sm opacity-70">No photos yet. Add some with the form above.</p>
                @else
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach ($product->images as $image)
                            <div class="rounded-xl border border-[#F4B6C2] p-2 text-center">
                                <img src="{{ asset($image->path) }}" alt="{{ $product->name }}"
                                     class="h-32 w-full rounded-lg object-cover">

                                <div class="mt-2 flex flex-col gap-1">
                                    @if ($loop->first)
                                        <span class="rounded-full bg-[#FDE8EC] px-3 py-1 text-xs">Cover photo</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.products.images.cover', $image) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full cc-btn cc-btn-sm cc-btn-soft">Make cover</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.products.images.destroy', $image) }}"
                                          onsubmit="return confirm('Remove this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full cc-btn cc-btn-sm bg-white text-red-700 border-red-200 hover:bg-red-50">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>