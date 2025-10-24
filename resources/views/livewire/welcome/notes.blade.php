<div class="p-4 max-w-6xl mx-auto" x-data="{ deleteNoteId: null }">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">
        Catatan
    </h1>

    {{-- Flash message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 p-2 mb-4 rounded shadow">
            {{ session('message') }}
        </div>
    @endif

    {{-- Add new note form --}}
    <form wire:submit.prevent="saveNote" class="mb-6 flex flex-col sm:flex-row gap-2">
        <x-text-input type="text" wire:model="title" placeholder="Judul (opsional)"
            class="border rounded p-2 w-full sm:w-1/3 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />

        <textarea wire:model="content" placeholder="Tulis catatanmu..."
            class="border rounded p-3 w-full sm:flex-1
                   dark:bg-gray-700 dark:border-gray-700 dark:text-gray-300
                   placeholder-gray-400 dark:placeholder-gray-200
                   resize-none
                   focus:outline-none
                   focus:border-green-300 focus:ring-2 focus:ring-green-300
                   dark:focus:border-green-600 dark:focus:ring-green-600"
            required></textarea>

        <x-primary-button type="submit"
            class="bg-blue-500 dark:bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600 dark:hover:bg-blue-700">
            {{ $editId ? 'Perbaharui Catatan' : 'Tambah Catatan' }}
        </x-primary-button>
    </form>

    {{-- Notes list --}}
    <div class="relative min-h-[500px]">
        @forelse($notes as $note)
            <div class="p-4 rounded shadow absolute bg-blue-300 dark:bg-blue-500 text-gray-900 dark:text-gray-100"
                style="top: {{ rand(0, 300) }}px; left: {{ rand(0, 300) }}px; width: 200px;">

                @if ($note->title)
                    <div class="font-semibold mb-2">{{ $note->title }}</div>
                @endif

                <p class="whitespace-pre-wrap">{{ $note->content }}</p>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" wire:click="goToEdit({{ $note->id }})"
                        class="text-yellow-600 dark:text-yellow-500 hover:underline">
                        Edit
                    </button>

                    <button type="button" @click="deleteNoteId = {{ $note->id }}"
                        class="text-red-400 dark:text-red-600 hover:underline">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan. Buatlah satu catatan!</p>
        @endforelse
    </div>

    {{-- Alpine.js Modal --}}
    <div x-show="deleteNoteId" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-black opacity-50" @click="deleteNoteId = null"></div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md relative">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Hapus Catatan?
            </h2>

            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex justify-end gap-3">
                <button type="button" @click="deleteNoteId = null"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500">
                    Batal
                </button>

                <button type="button" wire:click="deleteNote(deleteNoteId)" @click="deleteNoteId = null"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
