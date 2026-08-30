<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cart
    ) {
    }

    public function index(): View
    {
        return view('frontend.pages.cart.index', [
            'cartItems' => $this->cart->items(),
            'cartSubtotal' => $this->cart->subtotal(),
            'cartCurrency' => $this->cart->currency(),
            'containsPriceOnRequestItems' =>
                $this->cart->containsPriceOnRequestItems(),
        ]);
    }

    public function add(
        Request $request,
        Product $product
    ): RedirectResponse {
        abort_unless($product->is_published, 404);

        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100000',
            ],
            'options' => [
                'nullable',
                'array',
            ],
            'options.*' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $this->cart->add(
            $product,
            (int) $validated['quantity'],
            $validated['options'] ?? []
        );

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                $product->name . ' was added to your cart.'
            );
    }

    public function update(
        Request $request,
        string $key
    ): RedirectResponse {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100000',
            ],
        ]);

        $this->cart->update(
            $key,
            (int) $validated['quantity']
        );

        return back()->with(
            'success',
            'Cart quantity updated.'
        );
    }

    public function remove(string $key): RedirectResponse
    {
        $this->cart->remove($key);

        return back()->with(
            'success',
            'Product removed from your cart.'
        );
    }

    public function clear(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()
            ->route('products')
            ->with('success', 'Your cart has been cleared.');
    }
}
