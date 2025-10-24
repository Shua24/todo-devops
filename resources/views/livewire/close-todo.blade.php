<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
        Kegiatan yang Tenggat Waktunya Seminggu dan yang Sudah Terlambat
    </h2>

    @if ($todos->isEmpty())
        <p class="text-gray-700 dark:text-gray-300">
            Tidak ada kegiatan yang tenggat waktu dan terlambat.
        </p>
    @else
        <ul class="space-y-3">
            @foreach ($todos as $task)
                <li
                    class="p-4 border rounded-lg flex justify-between items-center bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                    <div>
                        <strong class="text-gray-900 dark:text-gray-100">{{ $task->name }}</strong>
                        <span class="ml-2 text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}
                        </span>
                    </div>

                    <div class="flex space-x-2">
                        <button wire:click="toggleCompleted({{ $task->id }})"
                            class="px-3 py-1 rounded bg-green-500 text-white hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600">
                            {{ $task->is_completed == 1 ? 'Urungkan' : 'Selesai' }}
                        </button>

                        <button wire:click="deleteTodo({{ $task->id }})"
                            class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
