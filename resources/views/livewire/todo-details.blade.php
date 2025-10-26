<!-- resources/views/livewire/todo-details.blade.php -->
<div class="max-w-2xl mx-auto mt-6"> <!-- ROOT DIV FOR LIVEWIRE -->

    <!-- Card -->
    <div class="p-6 bg-white dark:bg-gray-800 shadow rounded text-gray-900 dark:text-gray-100">

        <!-- Success message -->
        @if (session()->has('message'))
            <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">
                {{ session('message') }}
            </div>
        @endif

        <!-- Content Wrapper -->
        <div>

            @if ($editing)
                <!-- EDIT FORM -->
                <form wire:submit.prevent="save" class="space-y-4">

                    <!-- Title -->
                    <div>
                        <x-input-label for="Nama" :value="'Name'" />
                        <x-text-input id="name" type="text" wire:model="name" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="'Description'" />
                        <textarea id="description" wire:model="description" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-green-500 dark:focus:border-green-500"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Deadline -->
                    <div>
                        <x-input-label for="deadline" :value="'Deadline'" />
                        <x-text-input id="deadline" type="date" wire:model="deadline" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    </div>

                    <!-- Completed -->
                    <div class="flex items-center">
                        <input id="is_completed" type="checkbox" wire:model="is_completed"
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600">
                        <x-input-label for="is_completed" :value="'Completed'" class="ml-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-2 mt-4">
                        <x-primary-button type="submit">Save</x-primary-button>
                        <x-secondary-button type="button" wire:click="cancelEdit">Cancel</x-secondary-button>
                    </div>

                </form>
            @else
                <!-- READ-ONLY VIEW -->
                <div class="space-y-4">

                    <div>
                        <h1 class="text-2xl font-bold">{{ $todo->name }}</h1>
                    </div>
                    <div>
                        <p><strong>Nama:</strong> {{ $todo->name }}</p>
                    </div>
                    <div>
                        <p><strong>Deskripsi:</strong> {{ $todo->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <div>
                        <p><strong>Deadline:</strong>
                            {{ $todo->deadline ? \Carbon\Carbon::parse($todo->deadline)->format('d M Y') : 'No deadline' }}
                        </p>
                    </div>

                    <div>
                        <p><strong>Status:</strong>
                            @if ($todo->is_completed)
                                ✅ Selesai
                            @else
                                ❌ Belum selesai
                            @endif
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-2 mt-4">
                        <button wire:click="enableEdit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</button>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Back</a>
                    </div>

                </div>
            @endif

        </div> <!-- END Content Wrapper -->

    </div> <!-- END Card -->

</div> <!-- END ROOT DIV -->
