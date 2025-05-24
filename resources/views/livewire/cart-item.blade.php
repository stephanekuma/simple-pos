<tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-900">
    <td
        class="px-2 py-1 border-r min-w-[200px] max-w-[400px] whitespace-normal break-words text-gray-900 dark:text-gray-100">
        {{ $cartItem->name }}
    </td>
    <td class="px-2 py-1 border-r text-center text-gray-900 dark:text-gray-100">
        {{ number_format($cartItem->price, 2) }}
    </td>
    <td class="px-2 py-1 border-r text-center text-gray-900 dark:text-gray-100">
        {{ $cartItem->tax }}
    </td>
    <td class="px-2 py-1 border-r text-center">
        <div class="flex items-center gap-1 w-32">
            <input type="number" min="1" wire:model.live.debounce.250ms="quantity"
                class="bg-white dark:bg-gray-700 text-center block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            <button wire:click="removeFromCart" wire:loading.attr="disabled"
                class="p-2 text-black bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                title="Delete">
                <svg wire:loading.remove wire:target='removeFromCart' xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span wire:loading wire:target='removeFromCart'
                    class="w-4 h-4 border-2 border-t-red-100 border-transparent rounded-full animate-spin"></span>
            </button>
        </div>
    </td>
    @php
        $itemTotal = $cartItem->price * $cartItem->quantity;
        $taxAmount = ($itemTotal * $cartItem->tax) / 100;
        $itemTotalWithTax = $itemTotal + $taxAmount;
    @endphp
    <td class="px-2 py-1 text-center text-gray-900 dark:text-gray-100">
        {{ number_format($itemTotalWithTax, 2, '.', '') }}
    </td>
</tr>
