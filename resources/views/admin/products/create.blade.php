<x-app-layout>
    <x-slot name="header">
        <h2 class="cc-script text-3xl font-bold">Add product</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="cc-card p-6">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category" value="Section" />
                        <select id="category" name="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E88CA0] focus:ring-[#E88CA0]">
                            <option value="">Choose a section</option>
                            @foreach (\App\Models\Product::CATEGORIES as $key => $label)
                                <option value="{{ $key }}" @selected(old('category') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#E88CA0] focus:ring-[#E88CA0]">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-3">
                        <div>
                            <x-input-label for="price" value="Selling price" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cost_price" value="Cost price (admin only)" />
                            <x-text-input id="cost_price" name="cost_price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('cost_price')" required />
                            <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="initial_sold" value="Sold so far (admin only)" />
                            <x-text-input id="initial_sold" name="initial_sold" type="number" min="0" class="mt-1 block w-full" :value="old('initial_sold', 0)" />
                            <x-input-error :messages="$errors->get('initial_sold')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="images" value="Photos (JPG, PNG or WEBP, up to 8 photos, 4 MB each. The first is the cover.)" />
                        <input id="images" name="images[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm">
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        <x-input-error :messages="collect($errors->get('images.*'))->flatten()->all()" class="mt-2" />
                        <p class="mt-1 text-xs opacity-70">Hold Ctrl (or Shift) while clicking to choose several photos at once.</p>
                    </div>

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="in_stock" value="1" checked
                               class="rounded border-gray-300 text-[#E88CA0] focus:ring-[#E88CA0]">
                        <span class="text-sm">In stock</span>
                    </label>

                    <div class="flex items-center gap-3 pt-2">
                        <x-primary-button>Save product</x-primary-button>
                        <a href="{{ route('admin.products.index') }}" class="text-sm underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>