<?php

namespace App\Livewire\Order;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductSearch extends Component
{
    public $query = '';

    public $orderId;
    public $products;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->products = Product::query()
            ->where('name', 'like', '%' . $this->query . '%')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $currencySymbol = Setting::query()
            ->select('value')
            ->where('key', 'currency_symbol')
            ->first();

        $currencySymbol = $currencySymbol ? $currencySymbol->value : '';

        return view('livewire.order.product-search', compact('currencySymbol'));
    }

    #[On('checkout-completed')]
    public function checkoutCompleted()
    {
        $this->query = '';
    }

    #[On('cartUpdated')]
    public function updateCart() {}

    public function updated()
    {
        $this->products = Product::query()
            ->where('name', 'like', '%' . $this->query . '%')
            ->limit(10)
            ->get();
    }

    public function addToCart($product_id, $quantity = 1)
    {

        $product = Product::query()
            ->find($product_id);

        $cartItem = OrderItem::query()
            ->firstOrCreate(
                [
                    'order_id' => $this->orderId,
                    'product_id' => $product_id
                ],
                [
                    'name' => $product->name,
                    'quantity' => 0,
                    'price' => $product->price,
                    'tax' => $product->tax
                ]
            );

        // if (($product->quantity - $quantity) < 0) {
        //     if ($cartItem->quantity < 1) {
        //         $cartItem->delete();
        //     }
        //     return;
        // }

        $cartItem->update([
            'quantity' => $cartItem->quantity + $quantity
        ]);

        // $product->quantity = $product->quantity - $quantity;
        // $product->save();

        $this->dispatch('cartUpdated');
    }
}
