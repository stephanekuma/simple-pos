<div class="flex flex-col h-full w-full">

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    <div class="flex-1 overflow-x-auto md:overflow-x-visible">
        <table class="min-w-[600px] w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th
                        class="px-2 py-1 border border-gray-400 dark:border-gray-600 text-left w-3/5 text-gray-800 dark:text-gray-100">
                        Item</th>
                    <th
                        class="px-2 py-1 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Rate</th>
                    <th
                        class="px-2 py-1 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Tax(%)</th>
                    <th
                        class="px-2 py-1 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Quantity</th>
                    <th
                        class="px-2 py-1 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Total</th>
                </tr>
            </thead>
            <tbody>
                @if (!is_countable($cartItems) || count($cartItems) < 1)
                    <tr class="min-h-32">
                        <td class="p-4 text-gray-700 dark:text-gray-200" colspan="5">Add Items.</td>
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
                            :key="$item->id" :class="$loop->last ? 'rounded-b-lg' : ''" />
                    @endforeach

                    <tr class="border-gray-400 dark:border-gray-600 border bg-gray-50 dark:bg-gray-800">
                        <td colspan="3"
                            class="px-4 py-2 border-r text-right font-semibold text-gray-800 dark:text-gray-100">
                            Subtotal</td>
                        <td colspan="2" class="px-4 py-2 text-center font-semibold text-gray-800 dark:text-gray-100">
                            {{ number_format($totalPrice, 2) }} {{ $currencySymbol }}
                        </td>
                    </tr>

                    @foreach ($totalTax as $rate => $amount)
                        <tr class="border-gray-400 dark:border-gray-600 border bg-gray-50 dark:bg-gray-800">
                            <td colspan="3"
                                class="px-4 py-2 border-r text-right font-semibold text-gray-800 dark:text-gray-100">
                                VAT/GST @ {{ $rate }}%
                            </td>
                            <td colspan="2"
                                class="px-4 py-2 text-center font-semibold text-gray-800 dark:text-gray-100">
                                {{ number_format($amount, 2) }} {{ $currencySymbol }}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-100 dark:bg-gray-900 border-gray-400 dark:border-gray-600 border">
                        <td colspan="3"
                            class="px-4 py-2 border-r text-right font-bold text-gray-900 dark:text-gray-100">Grand Total
                        </td>
                        <td colspan="2" class="px-4 py-2 text-center font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($grandTotal, 2) }} {{ $currencySymbol }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="flex flex-row justify-between mt-4 w-full">
        <button onclick="window.history.back()"
            class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-full shadow px-6 py-2 font-semibold uppercase tracking-wide transition focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Retour
        </button>

        <button wire:click="checkout"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 dark:from-green-700 dark:to-emerald-800 dark:hover:from-green-800 dark:hover:to-emerald-900 rounded-full shadow-lg text-black px-6 py-2 font-semibold uppercase tracking-wide transition focus:outline-none focus:ring-2 focus:ring-green-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" fill="none" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" />
            </svg>
            Save
        </button>
    </div>
</div>
