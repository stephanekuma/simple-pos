<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];

    private $currencySymbol;

    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;

        $this->cartItems = OrderItem::query()->where('order_id', $orderId)
            ->orderBy('id', 'DESC')
            ->get();

        $this->currencySymbol = config('settings.currency_symbol', 'XOF');
    }

    public function render()
    {
        return view('livewire.order.cart', [
            'cartItems' => $this->cartItems,
            'currencySymbol' => $this->currencySymbol
        ]);
    }

    #[On('cartUpdated')]
    public function updateCart()
    {
        $this->cartItems = OrderItem::query()
            ->where('order_id', $this->orderId)
            ->orderBy('id', 'DESC')
            ->get();

        $order = Order::query()
            ->find($this->orderId);

        $total_price = 0;

        foreach ($this->cartItems as $item) {
            $total_price += $item->quantity * $item->price;
        }

        $order->total_price = $total_price;
        $order->save();
    }


    #[On('cartUpdatedFromItem')]
    public function cartUpdatedFromItem()
    {
        $this->cartItems = OrderItem::query()
            ->where('order_id', $this->orderId)
            ->orderBy('id', 'DESC')
            ->get();

        $order = Order::query()->find($this->orderId);

        $total_price = 0;

        foreach ($this->cartItems as $item) {
            $total_price += $item->quantity * $item->price;
        }

        $order->total_price = $total_price;
        $order->save();
    }

    public function checkout()
    {
        return $this->redirect(url('admin/orders'));
    }
}
