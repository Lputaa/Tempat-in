@extends('layouts.user')

@section('title', $restaurant->name)

@section('content')
<div>
    <div class="h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $restaurant->profile_image_path ? asset('storage/' . $restaurant->profile_image_path) : 'https://via.placeholder.com/1200x400.png?text=Tempat-In' }}');">
        <div class="flex items-center justify-center h-full w-full bg-gray-900 bg-opacity-50">
            <div class="text-center">
                <h1 class="text-white text-3xl md:text-5xl font-bold">{{ $restaurant->name }}</h1>
                <p class="text-gray-300 text-lg mt-2"><i class="fas fa-map-marker-alt mr-2"></i>{{ $restaurant->address }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12">
        <div class="lg:flex lg:space-x-12">
            <div class="w-full lg:w-2/3">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Tentang Restoran</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    {{ $restaurant->description }}
                </p>

                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 border-b-2 border-indigo-500 pb-2">Menu Kami</h3>
                
                @if($menuGrouped->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Menu untuk restoran ini belum tersedia.</p>
                @else
                    {{-- Looping per Kategori Menu --}}
                    @foreach ($menuGrouped as $category => $menuItems)
                        <div class="mb-8">
                            <h4 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-4">{{ $category }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Looping per Item Menu --}}
                                @foreach ($menuItems as $item)
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between">
                                                <h5 class="font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h5>
                                                <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($item->price) }}</p>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $item->description }}</p>
                                        </div>
                                        {{-- Tombol Kontrol Kuantitas --}}
                                        <div class="flex items-center justify-end mt-4">
                                            <button type="button" data-id="{{ $item->id }}" data-action="decrease" class="cart-button bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold py-1 px-3 rounded-l">-</button>
                                            <span id="quantity-{{ $item->id }}" class="bg-gray-100 dark:bg-gray-600 py-1 px-4">0</span>
                                            <button type="button" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" data-action="increase" class="cart-button bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold py-1 px-3 rounded-r">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="w-full lg:w-1/3 mt-12 lg:mt-0">
                <div class="sticky top-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-4">Pesanan Anda</h3>
                    
                    <div id="cart-items" class="mb-4 max-h-48 overflow-y-auto">
                        <p id="empty-cart-message" class="text-center text-gray-500">Keranjang Anda kosong.</p>
                    </div>

                    <hr class="my-4 border-gray-200 dark:border-gray-700">

                    {{-- Kalkulasi Harga --}}
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span id="cart-subtotal" class="font-medium text-gray-900 dark:text-white">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Biaya Layanan</span>
                            <span id="cart-service-fee" class="font-medium text-gray-900 dark:text-white">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold text-gray-900 dark:text-white">Total</span>
                            <span id="cart-total" class="font-bold text-gray-900 dark:text-white">Rp 0</span>
                        </div>
                         <div class="flex justify-between text-base border-t pt-2 mt-2 border-dashed">
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">Uang Muka (50%)</span>
                            <span id="cart-down-payment" class="font-semibold text-indigo-600 dark:text-indigo-400">Rp 0</span>
                        </div>
                    </div>

                    <hr class="my-4 border-gray-200 dark:border-gray-700">

                    {{-- Form Reservasi Utama --}}
                    <form id="reservation-form" action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart" id="cart-input">
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                        <div class="mb-4">
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                            <input type="date" id="reservation_date" name="reservation_date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="reservation_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu</label>
                            <input type="time" id="reservation_time" name="reservation_time" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="number_of_guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Tamu</label>
                            <input type="number" id="number_of_guests" name="number_of_guests" min="1" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 font-bold text-lg">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = {};
    const serviceFee = 5000; // Biaya layanan, bisa dibuat dinamis nanti dari database/config
    const downPaymentPercentage = 0.5; // 50%

    // Fungsi untuk memformat angka ke Rupiah
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    // Fungsi untuk update tampilan keranjang dan total
    function updateCartView() {
        const cartItemsContainer = document.getElementById('cart-items');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        let subtotal = 0;
        
        let cartContent = '';

        if (Object.keys(cart).length > 0) {
            for (const id in cart) {
                const item = cart[id];
                subtotal += item.price * item.quantity;
                cartContent += `
                    <div class="flex justify-between items-center text-sm mb-1">
                        <div>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">${item.name}</span>
                            <span class="text-gray-500 dark:text-gray-400">x ${item.quantity}</span>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">${formatCurrency(item.price * item.quantity)}</span>
                    </div>
                `;
            }
            cartItemsContainer.innerHTML = cartContent;
        } else {
            cartItemsContainer.innerHTML = '<p id="empty-cart-message" class="text-center text-gray-500">Keranjang Anda kosong.</p>';
        }

        const total = subtotal > 0 ? subtotal + serviceFee : 0;
        const downPayment = total * downPaymentPercentage;

        document.getElementById('cart-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('cart-service-fee').textContent = formatCurrency(subtotal > 0 ? serviceFee : 0);
        document.getElementById('cart-total').textContent = formatCurrency(total);
        document.getElementById('cart-down-payment').textContent = formatCurrency(downPayment);
    }

    // Tambahkan event listener ke semua tombol + dan -
    document.querySelectorAll('.cart-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const action = this.dataset.action;

            if (action === 'increase') {
                if (!cart[id]) {
                    cart[id] = {
                        name: this.dataset.name,
                        price: parseInt(this.dataset.price),
                        quantity: 0
                    };
                }
                cart[id].quantity++;
            } else if (action === 'decrease' && cart[id]) {
                cart[id].quantity--;
                if (cart[id].quantity <= 0) {
                    delete cart[id];
                }
            }
            
            const quantitySpan = document.getElementById(`quantity-${id}`);
            if (quantitySpan) {
                quantitySpan.textContent = cart[id] ? cart[id].quantity : 0;
            }

            updateCartView();
        });
    });

    // Saat form di-submit, isi hidden input dengan data keranjang
    document.getElementById('reservation-form').addEventListener('submit', function(event) {
        const cartInput = document.getElementById('cart-input');
        if (Object.keys(cart).length === 0) {
            alert('Keranjang Anda kosong. Silakan pilih menu terlebih dahulu.');
            event.preventDefault(); // Hentikan submit form
            return;
        }
        cartInput.value = JSON.stringify(cart);
    });
    
    // Inisialisasi tampilan keranjang saat halaman dimuat
    updateCartView();
});
</script>
@endpush