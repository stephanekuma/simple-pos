<div class="relative w-full">
    <input type="text" wire:keydown.Backspace='clear' wire:keydown.Delete='clear' wire:model.live.debounce.250ms="query"
        class="bg-white block w-full text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Select Customer..." />


    @if ($selectedCustomer)
        <div class="absolute top-0 left-0 px-1 py-1 mx-1 my-1 text-sm text-gray-900 bg-gray-100 rounded-md">
            {{ $selectedCustomer->firstname . ' ' . $selectedCustomer->lastname }}
        </div>
    @endif

    @if ($showDropdown and $query)
        <ul class="absolute left-0 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-md z-10">
            @foreach ($customers as $customer)
                <li wire:click="selectCustomer({{ $customer->id }})"
                    class="px-4 py-2 cursor-pointer hover:bg-blue-100 dark:text-white">
                    {{ $customer->firstname . ' ' . $customer->lastname }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
