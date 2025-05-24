<div class="mx-auto">
    <div class="relative mb-4">
        <input wire:model.live.debounce.250ms="query" type="search" id="default-search"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search product..." />
    </div>
    <div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3">
            @foreach ($products as $product)
                <div wire:click="addToCart({{ $product->id }})"
                    class="relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden cursor-pointer transition hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <div wire:loading wire:target="addToCart({{ $product->id }})"
                        class="bg-gray-200 dark:bg-gray-900 bg-opacity-80 absolute inset-0 flex items-center justify-center text-red-500 z-10">
                        <svg class="h-12 w-12" viewBox="0 0 120 30" fill="currentColor">
                            <circle cx="15" cy="15" r="10" fill="red">
                                <animate attributeName="opacity" values="0;1;0" dur="1.5s"
                                    repeatCount="indefinite" />
                            </circle>
                            <circle cx="60" cy="15" r="10" fill="red">
                                <animate attributeName="opacity" values="0;1;0" dur="1.5s" repeatCount="indefinite"
                                    begin="0.3s" />
                            </circle>
                            <circle cx="105" cy="15" r="10" fill="red">
                                <animate attributeName="opacity" values="0;1;0" dur="1.5s" repeatCount="indefinite"
                                    begin="0.6s" />
                            </circle>
                        </svg>
                    </div>

                    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}"
                        class="w-full h-32 object-cover bg-white dark:bg-gray-800" />
                    <p
                        class="text-gray-800 dark:text-gray-100 p-2 text-sm font-semibold flex justify-between items-center">
                        {{ $product->name }}
                        {{-- <span class="text-xs text-gray-500 dark:text-gray-400">({{ $product->quantity }})</span> --}}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 p-2 pt-0 text-md font-bold">
                        {{ $product->price . ' ' . $currencySymbol }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
