<div class="">

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif
    <div class="overflow-x-auto md:overflow-x-none">
        <table class="min-w-[600px] min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-2 py-2 border border-gray-400 text-left w-3/5 dark:text-gray-800">Item</th>
                    <th class="px-2 py-2 border border-gray-400 text-center w-1/6 dark:text-gray-800">Rate</th>
                    <th class="px-2 py-2 border border-gray-400 text-center w-1/6 dark:text-gray-800">Tax(%)</th>
                    <th class="px-2 py-2 border border-gray-400 text-center w-1/6 dark:text-gray-800">Quantity</th>
                    <th class="px-2 py-2 border border-gray-400 text-center w-1/6 dark:text-gray-800">Total</th>
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
                            $taxAmount = ($itemTotal * $tax) / 100;
                            $itemTotalWithTax = $itemTotal + $taxAmount;
                            $totalPrice += $itemTotal;
                            $totalTax[$tax] = ($totalTax[$tax] ?? 0) + $taxAmount;
                            $grandTotal += $itemTotalWithTax;
                        @endphp

                        <livewire:cart-item :cartItem="$item" :currencySymbol="$currencySymbol" :key="$item->id" />
                    @endforeach

                    <tr class="border-gray-400 border">
                        <td colspan="3" class="px-4 py-2 border-r text-right font-semibold">Subtotal</td>
                        <td colspan="2" class="px-4 py-2 text-center font-semibold">
                            {{ $currencySymbol }}{{ number_format($totalPrice, 2) }}</td>
                    </tr>

                    @foreach ($totalTax as $rate => $amount)
                        <tr class="border-gray-400 border">
                            <td colspan="3" class="px-4 py-2 border-r text-right font-semibold">VAT/GST @
                                {{ $rate }}%</td>
                            <td colspan="2" class="px-4 py-2 text-center font-semibold">
                                {{ $currencySymbol }}{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-100 border-gray-400 border">
                        <td colspan="3" class="px-4 py-2 border-r text-right font-bold">Grand Total</td>
                        <td colspan="2" class="px-4 py-2 text-center font-bold">
                            {{ $currencySymbol }}{{ number_format($grandTotal, 2) }}</td>
                    </tr>

                @endif
            </tbody>
        </table>
    </div>
    <button wire:click="checkout" wire:loading.attr="disabled" class="bg-green-500 rounded  text-white px-4 py-2 mt-3">
        <span wire:loading.remove wire:target='checkout'>Save</span>
        <span wire:loading wire:target='checkout'
            class="w-4 h-4 border-2 border-t-red-100 border-transparent rounded-full animate-spin"></span>
    </button>
</div>
