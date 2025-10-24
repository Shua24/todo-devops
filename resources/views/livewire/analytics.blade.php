<div class="p-6 min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 ring-gray-300">
    <h1 class="text-2xl font-semibold mb-6">Analitik Produktivitas</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Total Kegiatan --}}
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-medium mb-2 text-gray-800 dark:text-gray-200">Total Kegiatan</h2>
            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalTodos }}</p>
        </div>

        {{-- Selesai --}}
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-medium mb-2 text-gray-800 dark:text-gray-200">Selesai</h2>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $completedTodos }}</p>
        </div>

        {{-- Belum Selesai --}}
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-medium mb-2 text-gray-800 dark:text-gray-200">Belum Selesai</h2>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $incompleteTodos }}</p>
        </div>
    </div>

    {{-- Example Chart Placeholder --}}
    <div class="mt-10 bg-gray-100 dark:bg-gray-800 p-6 rounded-xl shadow">
        <h2 class="text-lg font-medium mb-4 text-gray-800 dark:text-gray-200">
            Persentase Kegiatan Selesai {{ $completionRate }}%
        </h2>
        <!--
        <div class="w-full h-64 flex items-center justify-center text-gray-500 dark:text-gray-400">
            <span>Chart will go here (e.g., with Chart.js or LivewireCharts)</span>
        </div>
        -->
    </div>

    {{-- Productivity Insights --}}
    <div class="mt-6 bg-gray-100 dark:bg-gray-800 rounded-xl p-6 shadow">
        <h2 class="text-lg font-medium mb-4 text-gray-800 dark:text-gray-200">Productivity Insights</h2>

        @if ($completionRate == 100)
            <p class="text-green-600 dark:text-green-400 font-semibold">🔥 Hebat! Semuanya selesai!!</p>
        @elseif ($completionRate >= 70)
            <p class="text-yellow-600 dark:text-yellow-400 font-semibold">💪 Bagus! Teruslah selesaikan kegiatan-kegiatanmu!</p>
        @elseif ($completionRate > 0)
            <p class="text-orange-600 dark:text-orange-400 font-semibold">📈 Sudah ada beberapa yang selesai, coba selesaikan beberapa lagi!</p>
        @else
            <p class="text-red-600 dark:text-red-400 font-semibold">🕒 Belum ada kegiatan selesai. Mari mulai kerja!!</p>
        @endif
    </div>
</div>

