<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Catatan</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-2">
        <input type="text" wire:model.defer="title" placeholder="Judul (opsional)"
            class="border border-gray-300 dark:border-gray-700 rounded p-2 w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <textarea wire:model.defer="content" placeholder="Tulis catatanmu..."
            class="border border-gray-300 dark:border-gray-700 rounded p-2 w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
            rows="6"></textarea>
        <div class="flex items-center mt-2">
            <button type="Kumpulkan"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-150">
                Simpan Semuanya
            </button>
            <a href="{{ route('notes') }}" class="ml-3 text-gray-600 dark:text-gray-400 hover:underline">
                Batal
            </a>
        </div>
    </form>
</div>
