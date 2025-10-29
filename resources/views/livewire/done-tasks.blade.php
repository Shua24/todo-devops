<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                {{-- Page Title --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Kegiatan yang Sudah Selesai</h1>
                    <a href="{{ route('dashboard') }}" class="text-sm text-blue-500 hover:underline">
                        ← Kembali ke Dashboard
                    </a>
                </div>

                {{-- Completed Todos --}}
                @if ($todos->isEmpty())
                    <p class="text-gray-500">Belum ada kegiatan selesait.</p>
                @else
                    <ul class="space-y-2">
                        @foreach ($todos as $todo)
                            <li wire:key="done-{{ $todo->id }}"
                                class="bg-green-100 border border-green-300 rounded-md p-3 flex justify-between items-center">
                                <span class="text-gray-700">{{ $todo->name }}</span>
                                <span class="text-sm text-gray-500">
                                    {{ $todo->updated_at->diffForHumans() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</div>
