<?php

namespace App\Livewire\Order;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class CartItem extends Component
{
    public $cartItem;

    public $currencySymbol;

    public $quantity;

    public $orderId;


    public function mount($cartItem, $orderId)
    {
        $this->orderId = $orderId;
        $this->cartItem = $cartItem;
        $this->quantity = $cartItem->quantity;
    }

    #[On('cartUpdated')]
    public function cartUpdated()
    {
        $this->quantity = $this->cartItem->quantity;
    }


    public function removeFromCart()
    {
        $product = Product::query()->find($this->cartItem->product_id);
        $product->quantity = $product->quantity + $this->quantity;
        $product->save();

        $this->quantity = 0;
        $this->cartItem->delete();
        $this->dispatch('cartUpdatedFromItem');
    }


    public function updated()
    {
        if ($this->quantity > 0) {
            $product = Product::query()->find($this->cartItem->product_id);
            $product->quantity = $product->quantity + $this->cartItem->quantity;

            if ($product->quantity <  $this->quantity) {
                $this->quantity = $product->quantity;
            }

            $product->save();

            $this->cartItem->quantity = $this->quantity;
            $this->cartItem->save();

            $product->quantity = $product->quantity - $this->quantity;
            $product->save();
        }
        if (is_numeric($this->quantity) && $this->quantity <= 0) {
            $this->quantity = 1;
        }
        $this->dispatch('cartUpdatedFromItem');
    }

    public function render()
    {
        return view('livewire.order.cart-item');
    }
}
