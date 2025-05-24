<div>
    <input wire:model="query" wire:keydown.escape="closeErrorModal" wire:keydown.enter="addToCart"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Scan barcode..." />

    @if ($error)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-70 transition-opacity duration-500 ease-in-out"
            style="display: flex; opacity: 1;" aria-modal="true" role="dialog">
            <!-- Modal Container -->
            <div wire:click.outside="$set('error', false)"
                class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-sm w-full transform transition-all duration-300 ease-in-out opacity-100 scale-100">
                <div class="text-center">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Erreur !</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $error }}</p>
                    <button wire:click="$set('error', false)"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
