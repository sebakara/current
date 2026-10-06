@php
    $editing = isset($product);

    $featuresText = old(
        'features_text',
        collect($product->features ?? [])->implode(PHP_EOL)
    );

    $specificationsText = old(
        'specifications_text',
        collect($product->specifications ?? [])
            ->map(
                fn ($value, $label) =>
                    $label . ': ' . (
                        is_array($value)
                            ? data_get($value, 'value', '')
                            : $value
                    )
            )
            ->implode(PHP_EOL)
    );

    $optionsText = old(
        'options_text',
        collect($product->options ?? [])
            ->map(function ($option) {
                $name = data_get($option, 'name');
                $values = collect(
                    data_get($option, 'values', [])
                )->implode(', ');

                return $name && $values
                    ? "{$name}: {$values}"
                    : null;
            })
            ->filter()
            ->implode(PHP_EOL)
    );
@endphp

@if ($errors->any())
    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
        <p class="font-black text-red-700 dark:text-red-300">
            Please correct the following errors:
        </p>

        <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-8 xl:grid-cols-[1fr_370px]">
    <div class="space-y-7">
        {{-- Basic information --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Product Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Product name *
                    </span>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name ?? '') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Category *
                    </span>

                    <select
                        name="product_category_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'product_category_id',
                                        $product->product_category_id ?? ''
                                    ) == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        SKU
                    </span>

                    <input
                        type="text"
                        name="sku"
                        value="{{ old('sku', $product->sku ?? '') }}"
                        placeholder="VTL-PROD-001"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $product->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Short description
                    </span>

                    <textarea
                        name="short_description"
                        rows="3"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('short_description', $product->short_description ?? '') }}</textarea>
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Full description
                    </span>

                    <textarea
                        name="description"
                        rows="10"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('description', $product->description ?? '') }}</textarea>
                </label>
            </div>
        </section>

        {{-- Structured information --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Features, Specifications & Options
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Features
                    </span>

                    <textarea
                        name="features_text"
                        rows="7"
                        placeholder="One feature per line&#10;Reliable construction&#10;Low power consumption&#10;Customisable configuration"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $featuresText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Enter one feature per line.
                    </span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Specifications
                    </span>

                    <textarea
                        name="specifications_text"
                        rows="8"
                        placeholder="Power supply: 12V DC&#10;Material: Aluminium&#10;Warranty: 12 months"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $specificationsText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Use one specification per line in “Label: Value” format.
                    </span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Customer-selectable options
                    </span>

                    <textarea
                        name="options_text"
                        rows="8"
                        placeholder="Connectivity: Standard, Wi-Fi, Bluetooth&#10;Enclosure: Basic, Industrial, Weatherproof&#10;Colour: Black, White, Custom"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $optionsText }}</textarea>

                    <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                        Use “Option name: Value 1, Value 2, Value 3”. These choices appear on the public product page and WhatsApp order.
                    </span>
                </label>
            </div>
        </section>

        {{-- Images --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Product Media
            </p>

            @if (
                $editing
                && $product->featured_image
                && Storage::disk('public')->exists($product->featured_image)
            )
                <div class="mt-6">
                    <p class="mb-3 text-sm font-black text-slate-700 dark:text-slate-300">
                        Current featured image
                    </p>

                    <img
                        src="{{ Storage::url($product->featured_image) }}"
                        alt="{{ $product->name }}"
                        class="h-72 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
                    >

                    <label class="mt-4 flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="remove_featured_image"
                            value="1"
                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                        >

                        <span class="text-sm font-bold text-red-700 dark:text-red-300">
                            Remove featured image
                        </span>
                    </label>
                </div>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing ? 'Replace featured image' : 'Featured image' }}
                </span>

                <input
                    type="file"
                    name="featured_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>

            @if ($editing && collect($product->gallery ?? [])->isNotEmpty())
                <div class="mt-8">
                    <p class="text-sm font-black text-slate-700 dark:text-slate-300">
                        Current gallery
                    </p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($product->gallery as $galleryImage)
                            @if (
                                $galleryImage
                                && Storage::disk('public')->exists($galleryImage)
                            )
                                <label class="overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                    <img
                                        src="{{ Storage::url($galleryImage) }}"
                                        alt="{{ $product->name }}"
                                        class="h-40 w-full object-cover"
                                    >

                                    <span class="flex items-center gap-3 p-3">
                                        <input
                                            type="checkbox"
                                            name="remove_gallery_images[]"
                                            value="{{ $galleryImage }}"
                                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                                        >

                                        <span class="text-xs font-bold text-red-700 dark:text-red-300">
                                            Remove image
                                        </span>
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <label class="mt-4 flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="remove_all_gallery_images"
                            value="1"
                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                        >

                        <span class="text-sm font-bold text-red-700 dark:text-red-300">
                            Remove all gallery images
                        </span>
                    </label>
                </div>
            @endif

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Add gallery images
                </span>

                <input
                    type="file"
                    name="gallery_images[]"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    You may select up to 20 images.
                </span>
            </label>

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Video URL
                </span>

                <input
                    type="url"
                    name="video_url"
                    value="{{ old('video_url', $product->video_url ?? '') }}"
                    placeholder="https://youtube.com/..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            @if (
                $editing
                && $product->datasheet
                && Storage::disk('public')->exists($product->datasheet)
            )
                <div class="mt-7 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <a
                        href="{{ Storage::url($product->datasheet) }}"
                        target="_blank"
                        class="text-sm font-black text-brand-primary dark:text-brand-primary-light"
                    >
                        View current datasheet →
                    </a>

                    <label class="mt-4 flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="remove_datasheet"
                            value="1"
                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                        >

                        <span class="text-sm font-bold text-red-700 dark:text-red-300">
                            Remove datasheet
                        </span>
                    </label>
                </div>
            @endif

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing ? 'Replace datasheet' : 'Datasheet' }}
                </span>

                <input
                    type="file"
                    name="datasheet"
                    accept=".pdf,.doc,.docx"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>
        </section>

        {{-- SEO --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Search Engine Optimisation
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Meta title
                    </span>

                    <input
                        type="text"
                        name="meta_title"
                        value="{{ old('meta_title', $product->meta_title ?? '') }}"
                        maxlength="255"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Meta description
                    </span>

                    <textarea
                        name="meta_description"
                        rows="4"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                </label>
            </div>
        </section>
    </div>

    <aside class="space-y-7">
        {{-- Pricing --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Pricing
            </p>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Currency
                    </span>

                    <select
                        name="currency"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        @foreach (['RWF', 'USD', 'EUR', 'GBP'] as $currency)
                            <option
                                value="{{ $currency }}"
                                @selected(
                                    old(
                                        'currency',
                                        $product->currency ?? 'RWF'
                                    ) === $currency
                                )
                            >
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Regular price
                    </span>

                    <input
                        type="number"
                        name="price"
                        value="{{ old('price', $product->price ?? '') }}"
                        step="0.01"
                        min="0"
                        placeholder="Leave empty for price on request"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Sale price
                    </span>

                    <input
                        type="number"
                        name="sale_price"
                        value="{{ old('sale_price', $product->sale_price ?? '') }}"
                        step="0.01"
                        min="0"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Display price publicly
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            When disabled, visitors see “Price on request”.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="show_price"
                        value="1"
                        @checked(old(
                            'show_price',
                            $product->show_price ?? false
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >
                </label>
            </div>
        </section>

        {{-- Ordering --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Ordering
            </p>

            <div class="mt-6 space-y-4">
                @foreach ([
                    'cart_enabled' => [
                        'Cart ordering',
                        'Allow visitors to add this product to the cart.',
                        true,
                    ],
                    'whatsapp_order_enabled' => [
                        'WhatsApp ordering',
                        'Allow this product in WhatsApp checkout.',
                        true,
                    ],
                    'manage_stock' => [
                        'Manage stock',
                        'Apply inventory availability controls.',
                        false,
                    ],
                    'allow_backorders' => [
                        'Allow backorders',
                        'Allow orders when stock reaches zero.',
                        true,
                    ],
                ] as $field => [$title, $description, $default])
                    <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                        <span>
                            <span class="block text-sm font-black text-slate-900 dark:text-white">
                                {{ $title }}
                            </span>

                            <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                                {{ $description }}
                            </span>
                        </span>

                        <input
                            type="checkbox"
                            name="{{ $field }}"
                            value="1"
                            @checked(old(
                                $field,
                                $product->{$field} ?? $default
                            ))
                            class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                        >
                    </label>
                @endforeach

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Minimum order quantity
                    </span>

                    <input
                        type="number"
                        name="minimum_order_quantity"
                        value="{{ old(
                            'minimum_order_quantity',
                            $product->minimum_order_quantity ?? 1
                        ) }}"
                        min="1"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Stock quantity
                    </span>

                    <input
                        type="number"
                        name="stock_quantity"
                        value="{{ old(
                            'stock_quantity',
                            $product->stock_quantity ?? 0
                        ) }}"
                        min="0"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        {{-- Publishing --}}
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <div class="mt-6 space-y-4">
                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Published
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Display this product publicly.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        @checked(old(
                            'is_published',
                            $product->is_published ?? true
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >
                </label>

                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Featured
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Prioritise this product on public pages.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        @checked(old(
                            'is_featured',
                            $product->is_featured ?? false
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Sort order
                    </span>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old(
                            'sort_order',
                            $product->sort_order ?? 0
                        ) }}"
                        min="0"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>

            <button
                type="submit"
                class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
            >
                {{ $editing ? 'Update Product' : 'Create Product' }}
            </button>

            <a
                href="{{ route('admin.products.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
