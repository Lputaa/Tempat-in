<!DOCTYPE html>
<html>
<head>
    <title>Buat Reservasi</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <form method="POST" action="{{ route('reservasi.simpan') }}" class="bg-white p-8 rounded-xl shadow w-full max-w-md">
        @csrf

        <h2 class="text-2xl font-bold text-[#660000] mb-6">Buat Reservasi</h2>

        @if ($errors->any())
            <div class="text-red-500 mb-4">
                <ul class="text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label class="block mb-2 font-semibold">Restoran</label>
        <select name="restaurant_id" class="w-full mb-4 px-4 py-2 border rounded" required>
            <option value="">-- Pilih Restoran --</option>
            @foreach ($restaurants as $restaurant)
                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
            @endforeach
        </select>

        <label class="block mb-2 font-semibold">Tanggal</label>
        <input type="date" name="reservation_date" class="w-full mb-4 px-4 py-2 border rounded" required>

        <label class="block mb-2 font-semibold">Waktu</label>
        <input type="time" name="reservation_time" class="w-full mb-4 px-4 py-2 border rounded" required>

        <label class="block mb-2 font-semibold">Jumlah Orang</label>
        <input type="number" name="guest_count" min="1" class="w-full mb-4 px-4 py-2 border rounded" required>

        <button type="submit" class="w-full bg-[#660000] text-white py-2 rounded hover:bg-red-900">
            Kirim Reservasi
        </button>
    </form>

</body>
</html>
