<div class="">

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif
    <div class="overflow-x-auto md:overflow-x-none">
        <table class="min-w-[600px] min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-2 py-1 border border-gray-400 text-left w-3/5 dark:text-gray-800">Item</th>
                    <th class="px-2 py-1 border border-gray-400 text-center w-1/6 dark:text-gray-800">Rate</th>
                    <th class="px-2 py-1 border border-gray-400 text-center w-1/6 dark:text-gray-800">Tax(%)</th>
                    <th class="px-2 py-1 border border-gray-400 text-center w-1/6 dark:text-gray-800">Quantity</th>
                    <th class="px-2 py-1 border border-gray-400 text-center w-1/6 dark:text-gray-800">Total</th>
                </tr>
            </thead>
            <tbody>
                @if (!is_countable($cartItems) || count($cartItems) < 1)
                    <tr class="min-h-32">
                        <td class="p-4">Add Items.</td>
                    </tr>
                @else
                    @php
                        $totalPrice = 0;
                        $totalTax = [];
                        $grandTotal = 0;
                    @endphp

                    @foreach ($cartItems as $item)
                        @php
                            $tax = $item->tax;
                            $itemTotal = $item->price * $item->quantity;
                            $gstAmount = ($itemTotal * $tax) / 100;
                            $itemTotalWithGst = $itemTotal + $gstAmount;
                            $totalPrice += $itemTotal;
                            $totalTax[$tax] = ($totalTax[$tax] ?? 0) + $gstAmount;
                            $grandTotal += $itemTotalWithGst;
                            $item->itemTotalWithGst = $itemTotalWithGst;
                        @endphp

                        <livewire:order.cart-item :cartItem="$item" :currencySymbol="$currencySymbol" :order-id="$orderId"
                            :key="$item->id" />
                    @endforeach

                    <tr class="border-gray-400 border">
                        <td colspan="3" class="px-4 py-2 border-r text-right font-semibold">Subtotal</td>
                        <td colspan="2" class="px-4 py-2 text-center font-semibold">
                            {{ number_format($totalPrice, 2) }} {{ $currencySymbol }}
                        </td>
                    </tr>

                    @foreach ($totalTax as $rate => $amount)
                        <tr class="border-gray-400 border">
                            <td colspan="3" class="px-4 py-2 border-r text-right font-semibold">VAT/GST @
                                {{ $rate }}%</td>
                            <td colspan="2" class="px-4 py-2 text-center font-semibold">
                                {{ number_format($amount, 2) }} {{ $currencySymbol }}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-100 border-gray-400 border">
                        <td colspan="3" class="px-4 py-2 border-r text-right font-bold">Grand Total</td>
                        <td colspan="2" class="px-4 py-2 text-center font-bold">
                            {{ number_format($grandTotal, 2) }} {{ $currencySymbol }}
                        </td>
                    </tr>

                @endif
            </tbody>
        </table>
    </div>

    <button wire:click="checkout" class="bg-green-500 rounded  text-white px-4 py-2 mt-3">
        <svg class="size-6 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </button>

</div>
