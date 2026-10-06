<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cart
    ) {
    }

    public function index(): View|RedirectResponse
    {
        if ($this->cart->items()->isEmpty()) {
            return redirect()
                ->route('products')
                ->with('error', 'Your cart is empty.');
        }

        return view('frontend.pages.checkout.index', [
            'cartItems' => $this->cart->items(),
            'cartSubtotal' => $this->cart->subtotal(),
            'cartCurrency' => $this->cart->currency(),
            'containsPriceOnRequestItems' =>
                $this->cart->containsPriceOnRequestItems(),
        ]);
    }

    public function whatsapp(
        Request $request
    ): RedirectResponse {
        if ($this->cart->items()->isEmpty()) {
            return redirect()
                ->route('products')
                ->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:150',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:40',
            ],
            'customer_email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'delivery_address' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $items = $this->cart->items();
        $subtotal = $this->cart->subtotal();
        $currency = $this->cart->currency();
        $deliveryFee = 0;
        $total = $subtotal;
        $containsPriceOnRequestItems =
            $this->cart->containsPriceOnRequestItems();

        $order = DB::transaction(function () use (
            $validated,
            $items,
            $subtotal,
            $deliveryFee,
            $total,
            $currency,
            $containsPriceOnRequestItems
        ) {
            $notes = $validated['notes'] ?? null;

            if ($containsPriceOnRequestItems) {
                $priceNote = 'One or more products require final price confirmation.';

                $notes = $notes
                    ? $notes . PHP_EOL . $priceNote
                    : $priceNote;
            }

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' =>
                    $validated['customer_email'] ?? null,
                'customer_phone' =>
                    $validated['customer_phone'],
                'delivery_address' =>
                    $validated['delivery_address'] ?? null,
                'notes' => $notes,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'currency' => $currency,
                'order_method' => 'whatsapp',
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $selectedOptions =
                    $item['selected_options'] ?? [];

                if ($item['price_on_request'] ?? false) {
                    $selectedOptions['_price_status'] =
                        'Price on request';
                }

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_slug' => $item['slug'],
                    'sku' => $item['sku'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'] ?? 0,
                    'subtotal' => $item['subtotal'] ?? 0,
                    'selected_options' => $selectedOptions,
                ]);
            }

            $message = $this->buildWhatsAppMessage(
                $order,
                $items
            );

            $order->update([
                'whatsapp_message' => $message,
            ]);

            return $order;
        });

        $whatsAppNumber = preg_replace(
            '/\D+/',
            '',
            setting(
                'whatsapp_number',
                setting('company_phone', '+250000000000')
            )
        );

        if (! $whatsAppNumber) {
            return back()->withErrors([
                'whatsapp' => 'The company WhatsApp number has not been configured.',
            ]);
        }

        $this->cart->clear();

        return redirect()->away(
            'https://wa.me/' .
            $whatsAppNumber .
            '?text=' .
            rawurlencode($order->whatsapp_message)
        );
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'VTL-' .
                now()->format('Ymd') .
                '-' .
                Str::upper(Str::random(6));
        } while (
            Order::query()
                ->where('order_number', $number)
                ->exists()
        );

        return $number;
    }

    private function buildWhatsAppMessage(
        Order $order,
        $items
    ): string {
        $lines = [
            'Hello ' . setting('company_name', 'VTLABS') . ',',
            '',
            'I would like to order or request pricing for the following products:',
            '',
            'Order reference: ' . $order->order_number,
            '',
        ];

        foreach ($items as $index => $item) {
            $lines[] = ($index + 1) . '. ' . $item['name'];
            $lines[] = 'Quantity: ' . $item['quantity'];

            if (! empty($item['sku'])) {
                $lines[] = 'SKU: ' . $item['sku'];
            }

            foreach (
                $item['selected_options'] ?? []
                as $option => $value
            ) {
                $lines[] = Str::headline($option) .
                    ': ' .
                    $value;
            }

            if ($item['price_on_request'] ?? false) {
                $lines[] = 'Price: On request';
            } else {
                $lines[] = 'Unit price: ' .
                    $item['currency'] .
                    ' ' .
                    number_format(
                        (float) $item['unit_price'],
                        2
                    );

                $lines[] = 'Subtotal: ' .
                    $item['currency'] .
                    ' ' .
                    number_format(
                        (float) $item['subtotal'],
                        2
                    );
            }

            $lines[] = '';
        }

        if ((float) $order->subtotal > 0) {
            $lines[] = 'Priced-product subtotal: ' .
                $order->currency .
                ' ' .
                number_format(
                    (float) $order->subtotal,
                    2
                );

            $lines[] = '';
        }

        if (
            collect($items)->contains(
                fn ($item) =>
                    (bool) ($item['price_on_request'] ?? false)
            )
        ) {
            $lines[] = 'Please provide final pricing for the products marked "On request".';
            $lines[] = '';
        }

        $lines[] = 'Customer: ' . $order->customer_name;
        $lines[] = 'Phone: ' . $order->customer_phone;

        if ($order->customer_email) {
            $lines[] = 'Email: ' . $order->customer_email;
        }

        if ($order->delivery_address) {
            $lines[] = 'Delivery location: ' .
                $order->delivery_address;
        }

        if ($order->notes) {
            $lines[] = 'Additional note: ' .
                $order->notes;
        }

        $lines[] = '';
        $lines[] = 'Please confirm pricing, availability, delivery, and payment details.';

        return implode(PHP_EOL, $lines);
    }
}
