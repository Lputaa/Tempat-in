@extends('layouts.user')

@section('title', $restaurant->name)

@section('content') 
<div>
    @php
    $backgroundImageUrl = $restaurant->profile_image_path 
        ? asset('storage/' . $restaurant->profile_image_path) 
        : 'https://via.placeholder.com/1200x400.png?text=Tempat-In';
@endphp

<div class="h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $backgroundImageUrl }}')">
    <div class="flex items-center justify-center h-full w-full">
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

                {{-- Bagian Paket Booking Opsional --}}
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 border-b-2 border-indigo-500 pb-2">Paket Reservasi (Opsional)</h3>
                <div class="mb-8">
                    @if($bookingPackages->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Restoran ini tidak menawarkan paket booking khusus saat ini.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($bookingPackages as $package)
                                <label for="package-{{ $package->id }}" class="cursor-pointer">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border-2 border-transparent has-[:checked]:border-indigo-500 has-[:checked]:ring-2 has-[:checked]:ring-indigo-500">
                                        <input type="radio" name="booking_package_id" id="package-{{ $package->id }}" value="{{ $package->id }}" class="hidden package-radio" data-name="{{ $package->name }}" data-price="{{ $package->price }}">
                                        <img src="{{ $package->image_path ? asset('storage/' . $package->image_path) : 'https://via.placeholder.com/300x200' }}" alt="{{ $package->name }}" class="w-full h-32 object-cover rounded-t-lg">
                                        <div class="p-4">
                                            <h5 class="font-bold text-lg text-gray-900 dark:text-white">{{ $package->name }}</h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $package->description }}</p>
                                            <p class="font-bold text-indigo-600 dark:text-indigo-400 mt-2 text-lg">Rp {{ number_format($package->price) }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>


                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 border-b-2 border-indigo-500 pb-2">Pre-Order Menu (Opsional)</h3>
                
                @if($menuGrouped->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Menu untuk restoran ini belum tersedia.</p>
                @else
                    @foreach ($menuGrouped as $category => $menuItems)
                        <div class="mb-8">
                            <h4 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-4">{{ $category }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($menuItems as $item)
                                    {{-- Kartu Item Menu dengan Gambar --}}
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow flex items-start space-x-4 p-4">
                                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : 'https://via.placeholder.com/150' }}" 
                                             alt="{{ $item->name }}" 
                                             class="w-24 h-24 object-cover rounded-md flex-shrink-0">
                                        <div class="flex-grow flex flex-col justify-between h-24">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h5 class="font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h5>
                                                    <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($item->price) }}</p>
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $item->description }}</p>
                                            </div>
                                            <div class="flex items-center justify-end">
                                                <button type="button" data-id="{{ $item->id }}" data-action="decrease" class="cart-button bg-gray-200 dark:bg-gray-700 font-bold py-1 px-3 rounded-l">-</button>
                                                <span id="quantity-{{ $item->id }}" class="bg-gray-100 dark:bg-gray-600 py-1 px-4">0</span>
                                                <button type="button" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" data-action="increase" class="cart-button bg-gray-200 dark:bg-gray-700 font-bold py-1 px-3 rounded-r">+</button>
                                            </div>
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
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-4">Ringkasan & Reservasi</h3>
                    
                    <div id="cart-items" class="mb-4 max-h-48 overflow-y-auto">
                        <p id="empty-cart-message" class="text-center text-gray-500">Pilih paket atau menu untuk memulai.</p>
                    </div>

                    <hr class="my-4 border-gray-200 dark:border-gray-700">

                    {{-- Kalkulasi Harga --}}
                    <div class="space-y-2 text-sm">
                        <div id="package-summary" class="hidden justify-between font-semibold">
                            <span class="text-gray-600 dark:text-gray-400">Paket Booking</span>
                            <span id="package-summary-price" class="text-gray-900 dark:text-white"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal Menu</span>
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
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                        <div class="mb-4">
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal</label>
                            <input type="date" id="reservation_date" name="reservation_date" class="mt-1 block w-full rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="reservation_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu</label>
                            <input type="time" id="reservation_time" name="reservation_time" class="mt-1 block w-full rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="number_of_guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Tamu</label>
                            <input type="number" id="number_of_guests" name="number_of_guests" min="1" class="mt-1 block w-full rounded-md" required>
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
    // State management
    const cart = {
        items: {},
        selectedPackage: null
    };
    const serviceFee = 5000;
    const downPaymentPercentage = 0.5;

    // Elemen-elemen DOM
    const cartItemsContainer = document.getElementById('cart-items');
    const packageSummaryDiv = document.getElementById('package-summary');
    const packageSummaryPrice = document.getElementById('package-summary-price');
    const subtotalEl = document.getElementById('cart-subtotal');
    const serviceFeeEl = document.getElementById('cart-service-fee');
    const totalEl = document.getElementById('cart-total');
    const downPaymentEl = document.getElementById('cart-down-payment');
    const form = document.getElementById('reservation-form');

    // Fungsi untuk format mata uang
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    // Fungsi utama untuk update semua tampilan
    function updateFullView() {
        let menuSubtotal = 0;
        let cartContent = '';

        // Update tampilan item menu di keranjang
        if (Object.keys(cart.items).length > 0) {
            for (const id in cart.items) {
                const item = cart.items[id];
                menuSubtotal += item.price * item.quantity;
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
             if (!cart.selectedPackage) {
                cartItemsContainer.innerHTML = '<p id="empty-cart-message" class="text-center text-gray-500">Pilih paket atau menu untuk memulai.</p>';
            } else {
                cartItemsContainer.innerHTML = '';
            }
        }

        // Update tampilan paket yang dipilih
        if (cart.selectedPackage) {
            packageSummaryDiv.classList.remove('hidden');
            packageSummaryDiv.classList.add('flex');
            packageSummaryPrice.textContent = formatCurrency(cart.selectedPackage.price);
        } else {
            packageSummaryDiv.classList.add('hidden');
            packageSummaryDiv.classList.remove('flex');
        }

        const packagePrice = cart.selectedPackage ? cart.selectedPackage.price : 0;
        const currentServiceFee = menuSubtotal > 0 ? serviceFee : 0;
        const total = packagePrice + menuSubtotal + currentServiceFee;
        const downPayment = total * downPaymentPercentage;

        subtotalEl.textContent = formatCurrency(menuSubtotal);
        serviceFeeEl.textContent = formatCurrency(currentServiceFee);
        totalEl.textContent = formatCurrency(total);
        downPaymentEl.textContent = formatCurrency(downPayment);
    }

    // Event listener untuk tombol +/- pada item menu
    document.querySelectorAll('.cart-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const action = this.dataset.action;

            if (action === 'increase') {
                if (!cart.items[id]) {
                    cart.items[id] = { name: this.dataset.name, price: parseInt(this.dataset.price), quantity: 0 };
                }
                cart.items[id].quantity++;
            } else if (action === 'decrease' && cart.items[id]) {
                cart.items[id].quantity--;
                if (cart.items[id].quantity <= 0) delete cart.items[id];
            }
            
            document.getElementById(`quantity-${id}`).textContent = cart.items[id] ? cart.items[id].quantity : 0;
            updateFullView();
        });
    });
    
    // Event listener untuk radio button paket
    document.querySelectorAll('.package-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked && cart.selectedPackage && cart.selectedPackage.id === this.value) {
                this.checked = false;
                cart.selectedPackage = null;
            } else if (this.checked) {
                cart.selectedPackage = { id: this.value, name: this.dataset.name, price: parseInt(this.dataset.price) };
            }
            updateFullView();
        });
    });

    // Event listener untuk submit form
    form.addEventListener('submit', function(event) {
        // Hapus input lama jika ada untuk menghindari duplikasi
        document.querySelectorAll('input[name="booking_package_id"], input[name="cart_items"]').forEach(el => el.remove());

        if (cart.selectedPackage) {
            const packageInput = document.createElement('input');
            packageInput.type = 'hidden';
            packageInput.name = 'booking_package_id';
            packageInput.value = cart.selectedPackage.id;
            form.appendChild(packageInput);
        }

        if (Object.keys(cart.items).length > 0) {
             const itemsInput = document.createElement('input');
             itemsInput.type = 'hidden';
             itemsInput.name = 'cart_items';
             itemsInput.value = JSON.stringify(cart.items);
             form.appendChild(itemsInput);
        }
    });

    updateFullView();
});
</script>
@endpush