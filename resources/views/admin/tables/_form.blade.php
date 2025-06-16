@if ($errors->any())
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
        <p class="font-bold">Oops! Ada yang salah:</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6">
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Meja</label>
        <input type="text" name="name" id="name" value="{{ old('name', $table->name ?? '') }}" placeholder="Contoh: Meja 01, Sofa VIP" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 block text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
    </div>
    <div class="mb-4">
        <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kapasitas (Orang)</label>
        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $table->capacity ?? '') }}" min="1" placeholder="Contoh: 4" class="mt-1 block w-full rounded-md block text-sm font-medium text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
    </div>
</div>