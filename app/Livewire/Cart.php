<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];

    private $currencySymbol;

    public function mount()
    {
        $this->cartItems = CartModel::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->get();

        $this->currencySymbol = config('settings.currencySymbol');
    }
    public function render()
    {
        return view('livewire.cart', [
            'cartItems' => $this->cartItems,
            'currencySymbol' => $this->currencySymbol
        ]);
    }

    #[On('cartUpdated')]
    public function updateCart()
    {
        $this->cartItems = CartModel::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->get();

        $this->currencySymbol = config('settings.currency_symbol', 'XOF');
    }

    #[On('cartUpdatedFromItem')]
    public function cartUpdatedFromItem()
    {
        $this->cartItems = CartModel::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->get();

        $this->currencySymbol = config('settings.currency_symbol', 'XOF');
    }

    public function checkout()
    {
        $totalPrice = 0;
        $customerId =  session('customer_id');

        if (empty($customerId)) {
            return $this->dispatch('error', error: 'Please select customer!');
        }

        $items = $this->cartItems;

        if (! is_countable($items) || count($items) < 1) {
            return;
        }

        $order = Order::query()
            ->create([
                'customer_id' => $customerId,
                'total_price' => $totalPrice
            ]);

        foreach ($items as $item) {
            // $product = Product::query()->find($item->product_id);

            $order->items()->create([
                'name' => $item->name,
                'price' => $item->price,
                'tax' => $item->tax,
                'quantity' => $item->quantity,
                'product_id' => $item->product_id,
            ]);

            $totalPrice += $item->quantity * $item->price;

            // $product->quantity = $product->quantity - $item->quantity;
            // $product->save();
        }

        $order->total_price = $totalPrice;
        $order->save();

        $this->cartItems = CartModel::where('user_id', Auth::id())
            ->delete();

        $this->dispatch('checkout-completed');

        redirect(url('/admin/orders/' . $order->id . '/edit'));
    }
}
