import './bootstrap';


const themeToggleBtn = document.getElementById('theme-toggle');
const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');


// Fungsi untuk mengatur ikon mana yang tampil saat halaman pertama kali dimuat
function setInitialThemeIcon() {
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        themeToggleLightIcon.classList.remove('hidden');
        themeToggleDarkIcon.classList.add('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
        themeToggleLightIcon.classList.add('hidden');
    }
}

// Pastikan tombol toggle ada di halaman sebelum menjalankan kode
if (themeToggleBtn) {
    // Atur ikon yang benar saat halaman dimuat
    setInitialThemeIcon();

    // Tambahkan event listener untuk saat tombol di-klik
    themeToggleBtn.addEventListener('click', function() {
        // Ganti ikon di dalam tombol
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // Cek apakah tema sudah tersimpan di localStorage
        if (localStorage.getItem('color-theme')) {
            // Jika tema terang, ubah ke gelap dan simpan
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                // Jika tema gelap, ubah ke terang dan simpan
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        // Jika tema belum tersimpan di localStorage
        } else {
            // Jika <html> sudah punya class 'dark', hapus
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                // Jika tidak, tambahkan class 'dark'
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
    document.addEventListener('DOMContentLoaded', () => {

    // ===== Logika untuk Sliding Panel Login/Register =====
    const container = document.getElementById('main-container');
    
    // Hanya jalankan kode jika kita berada di halaman yang memiliki kontainer ini.
    if (container) {
        const signUpButton = document.getElementById('signUpBtn');
        const signInButton = document.getElementById('signInBtn');

        // Lakukan pengecekan 'null' untuk memastikan kedua tombol ada sebelum menambahkan listener.
        if (signUpButton && signInButton) {
            signUpButton.addEventListener('click', () => {
                container.classList.add("panel-active");
            });
    
            signInButton.addEventListener('click', () => {
                container.classList.remove("panel-active");
            });
        } else {
            // Beri feedback di console jika ada elemen yang tidak ditemukan.
            console.error("Satu atau lebih tombol (signInBtn/signUpBtn) untuk panel geser tidak ditemukan di dalam DOM.");
        }
    }

    // ===== Logika untuk Dark Mode Toggle (jika ada di halaman yang sama) =====
    const themeToggleBtn = document.getElementById('theme-toggle');
    if(themeToggleBtn){
    }

    

});
}