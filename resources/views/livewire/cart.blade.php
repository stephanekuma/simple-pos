<div class="flex flex-col h-full w-full">

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif
    <div class="flex-1 overflow-x-auto md:overflow-x-none flex flex-col">
        <table
            class="w-full min-w-[600px] border border-gray-300 dark:border-gray-700 rounded-md overflow-hidden flex-1">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th
                        class="px-2 py-2 border border-gray-400 dark:border-gray-600 text-left w-3/5 text-gray-800 dark:text-gray-100">
                        Item</th>
                    <th
                        class="px-2 py-2 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Rate</th>
                    <th
                        class="px-2 py-2 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Tax(%)</th>
                    <th
                        class="px-2 py-2 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Quantity</th>
                    <th
                        class="px-2 py-2 border border-gray-400 dark:border-gray-600 text-center w-1/6 text-gray-800 dark:text-gray-100">
                        Total</th>
                </tr>
            </thead>
            <tbody>
                @if (!is_countable($cartItems) || count($cartItems) < 1)
                    <tr class="min-h-32">
                        <td class="p-4 text-gray-700 dark:text-gray-200">Add Items.</td>
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

                    <tr class="border-gray-400 dark:border-gray-600 border bg-gray-50 dark:bg-gray-800">
                        <td colspan="3"
                            class="px-4 py-2 border-r text-right font-semibold text-gray-800 dark:text-gray-100">
                            Subtotal</td>
                        <td colspan="2" class="px-4 py-2 text-center font-semibold text-gray-800 dark:text-gray-100">
                            {{ $currencySymbol }}{{ number_format($totalPrice, 2) }}</td>
                    </tr>

                    @foreach ($totalTax as $rate => $amount)
                        <tr class="border-gray-400 dark:border-gray-600 border bg-gray-50 dark:bg-gray-800">
                            <td colspan="3"
                                class="px-4 py-2 border-r text-right font-semibold text-gray-800 dark:text-gray-100">
                                VAT/GST @ {{ $rate }}%</td>
                            <td colspan="2"
                                class="px-4 py-2 text-center font-semibold text-gray-800 dark:text-gray-100">
                                {{ $currencySymbol }}{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-100 dark:bg-gray-900 border-gray-400 dark:border-gray-600 border">
                        <td colspan="3"
                            class="px-4 py-2 border-r text-right font-bold text-gray-900 dark:text-gray-100">Grand Total
                        </td>
                        <td colspan="2" class="px-4 py-2 text-center font-bold text-gray-900 dark:text-gray-100">
                            {{ $currencySymbol }}{{ number_format($grandTotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="pt-4 pb-2 text-left">
                            <button wire:click="checkout" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 border border-black dark:border-white
                                    bg-gray-900 hover:bg-gray-800 text-black
                                    dark:bg-white dark:hover:bg-gray-200 dark:text-white
                                    rounded-md shadow-2xl shadow-black dark:shadow-white px-6 py-2 font-semibold uppercase tracking-wide transition
                                    focus:outline-none focus:ring-2 focus:ring-green-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span wire:loading.remove wire:target='checkout'>Save</span>
                                <span wire:loading wire:target='checkout'
                                    class="w-4 h-4 border-2 border-t-gray-900 dark:border-t-white border-transparent rounded-md animate-spin"></span>
                            </button>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
