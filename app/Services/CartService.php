<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartService
{
    private const SESSION_KEY = 'vtlabs_cart';

    public function items(): Collection
    {
        return collect(session(self::SESSION_KEY, []));
    }

    public function add(
        Product $product,
        int $quantity = 1,
        array $selectedOptions = []
    ): void {
        if (! $product->isPurchasable()) {
            throw ValidationException::withMessages([
                'product' => 'This product is not currently available for cart ordering.',
            ]);
        }

        $minimumQuantity = max(
            1,
            (int) ($product->minimum_order_quantity ?: 1)
        );

        $quantity = max($quantity, $minimumQuantity);

        if (
            $product->manage_stock
            && ! $product->allow_backorders
            && $quantity > (int) $product->stock_quantity
        ) {
            throw ValidationException::withMessages([
                'quantity' => 'The requested quantity is greater than the available stock.',
            ]);
        }

        $cart = $this->items();

        $currency = $product->currency ?: 'RWF';

        $existingCurrency = $cart
            ->where('price_on_request', false)
            ->pluck('currency')
            ->filter()
            ->first();

        $unitPrice = $product->current_price;
        $priceOnRequest = $unitPrice === null;

        if (
            ! $priceOnRequest
            && $existingCurrency
            && $existingCurrency !== $currency
        ) {
            throw ValidationException::withMessages([
                'product' => 'Products using different currencies cannot be placed in the same cart.',
            ]);
        }

        $selectedOptions = collect($selectedOptions)
            ->mapWithKeys(function ($value, $key) {
                $cleanKey = trim((string) $key);
                $cleanValue = trim((string) $value);

                if ($cleanKey === '' || $cleanValue === '') {
                    return [];
                }

                return [$cleanKey => $cleanValue];
            })
            ->all();

        $cartKey = $this->makeCartKey(
            $product->id,
            $selectedOptions
        );

        $existingItem = $cart->get($cartKey);

        $newQuantity = $existingItem
            ? (int) $existingItem['quantity'] + $quantity
            : $quantity;

        if (
            $product->manage_stock
            && ! $product->allow_backorders
            && $newQuantity > (int) $product->stock_quantity
        ) {
            throw ValidationException::withMessages([
                'quantity' => 'The total cart quantity exceeds the available stock.',
            ]);
        }

        $numericUnitPrice = $priceOnRequest
            ? 0.0
            : (float) $unitPrice;

        $cart->put($cartKey, [
            'key' => $cartKey,
            'product_id' => $product->id,
            'name' => $product->name ?: 'Technical Product',
            'slug' => $product->slug,
            'sku' => $product->sku,
            'image' => $product->featured_image,
            'quantity' => $newQuantity,
            'minimum_quantity' => $minimumQuantity,
            'maximum_quantity' => $product->manage_stock
                && ! $product->allow_backorders
                    ? (int) $product->stock_quantity
                    : null,
            'unit_price' => $numericUnitPrice,
            'price_on_request' => $priceOnRequest,
            'currency' => $currency,
            'selected_options' => $selectedOptions,
            'subtotal' => $priceOnRequest
                ? 0.0
                : $numericUnitPrice * $newQuantity,
        ]);

        $this->store($cart);
    }

    public function update(string $key, int $quantity): void
    {
        $cart = $this->items();
        $item = $cart->get($key);

        if (! $item) {
            return;
        }

        $minimum = max(
            1,
            (int) ($item['minimum_quantity'] ?? 1)
        );

        $quantity = max($quantity, $minimum);

        $maximum = $item['maximum_quantity'] ?? null;

        if ($maximum !== null && $quantity > (int) $maximum) {
            throw ValidationException::withMessages([
                'quantity' => 'The requested quantity exceeds available stock.',
            ]);
        }

        $item['quantity'] = $quantity;

        $item['subtotal'] = ($item['price_on_request'] ?? false)
            ? 0.0
            : (float) ($item['unit_price'] ?? 0) * $quantity;

        $cart->put($key, $item);

        $this->store($cart);
    }

    public function remove(string $key): void
    {
        $cart = $this->items();
        $cart->forget($key);

        $this->store($cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function subtotal(): float
    {
        return (float) $this->items()
            ->where('price_on_request', false)
            ->sum('subtotal');
    }

    public function containsPriceOnRequestItems(): bool
    {
        return $this->items()->contains(
            fn ($item) => (bool) ($item['price_on_request'] ?? false)
        );
    }

    public function currency(): string
    {
        return $this->items()
            ->where('price_on_request', false)
            ->pluck('currency')
            ->filter()
            ->first()
            ?: $this->items()
                ->pluck('currency')
                ->filter()
                ->first()
            ?: 'RWF';
    }

    private function makeCartKey(
        int $productId,
        array $selectedOptions
    ): string {
        ksort($selectedOptions);

        return $productId . ':' . md5(
            json_encode(
                $selectedOptions,
                JSON_UNESCAPED_UNICODE
            )
        );
    }

    private function store(Collection $cart): void
    {
        session([
            self::SESSION_KEY => $cart->all(),
        ]);
    }
}
