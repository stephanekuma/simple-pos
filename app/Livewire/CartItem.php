<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class CartItem extends Component
{
    public $cartItem;

    public $currencySymbol;

    public $quantity;

    public function mount($cartItem)
    {
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
        $this->quantity = 0;
        $this->cartItem->delete();

        $this->dispatch('cartUpdatedFromItem');
    }

    public function updated()
    {
        if ($this->quantity > 0) {
            $product = Product::query()->find($this->cartItem->product_id);

            if ($product->quantity <  $this->quantity) {
                $this->quantity = $product->quantity;
            }

            $this->cartItem->quantity = $this->quantity;
            $this->cartItem->save();

            $this->dispatch('cartUpdatedFromItem');
        }
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}
