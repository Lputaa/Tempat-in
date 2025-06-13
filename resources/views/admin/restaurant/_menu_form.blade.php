{{-- resources/views/admin/restaurant/_menu_form.blade.php --}}

{{-- Tampilkan error validasi --}}
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p class="font-bold">Terjadi Kesalahan:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($menuItem) ? route('admin.menu-items.update', $menuItem->id) : route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($menuItem))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Kolom Kiri --}}
        <div>
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Item</label>
                <input type="text" id="name" name="name" value="{{ old('name', $menuItem->name ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                <textarea id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">{{ old('description', $menuItem->description ?? '') }}</textarea>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div>
            <div class="mb-4">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga (Rp)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $menuItem->price ?? '') }}" placeholder="Contoh: 25000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                    @php
                        $category = old('category', $menuItem->category ?? '');
                    @endphp
                    <option value="Makanan Utama" @if($category == 'Makanan Utama') selected @endif>Makanan Utama</option>
                    <option value="Minuman" @if($category == 'Minuman') selected @endif>Minuman</option>
                    <option value="Cemilan" @if($category == 'Cemilan') selected @endif>Cemilan</option>
                    <option value="Hidangan Penutup" @if($category == 'Hidangan Penutup') selected @endif>Hidangan Penutup</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="image_path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Item (Opsional)</label>
                <input type="file" id="image_path" name="image_path" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Kosongkan jika tidak ingin mengubah foto.</p>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            {{ isset($menuItem) ? 'Simpan Perubahan' : 'Simpan Item' }}
        </button>
    </div>
</form>