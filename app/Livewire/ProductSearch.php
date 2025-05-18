<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductSearch extends Component
{
    public $query = '';
    public $products = '';

    public function mount()
    {
        $this->products = Product::query()
            ->where('name', 'like', '%' . $this->query . '%')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $currencySymbol = config('settings.currency_symbol', 'XOF');

        return view('livewire.product-search', compact('currencySymbol'));
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
        $this->products = Product::where('name', 'like', '%' . $this->query . '%')->limit(10)->get();
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product  = Product::find($productId);
        $userId  = Auth::id();

        $cartItem = Cart::firstOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId
            ],
            [
                'quantity' => 0,
                'name' => $product->name,
                'price' => $product->price,
                'tax' => $product->tax
            ]
        );

        // if ($product->quantity < ($cartItem->quantity + $quantity)) {
        //     if ($cartItem->quantity < 1) {
        //         $cartItem->delete();
        //     }
        //     return;
        // }

        $cartItem->update([
            'quantity' => $cartItem->quantity + $quantity
        ]);

        $this->dispatch('cartUpdated');
    }

    // public function removeFromCart($productId)
    // {
    //     $userId  = Auth::id();
    //     Cart::where('user_id', $userId)->where('product_id', $productId)->delete();
    //     $this->dispatch('cartUpdated');
    // }
}
