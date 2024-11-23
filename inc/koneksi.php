<?php
// Mengaktifkan pelaporan error MySQLi untuk debug
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Membuat koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "gratis_masjid");

    // Set karakter encoding untuk memastikan dukungan karakter khusus
    $koneksi->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Opsional: Hapus baris ini di lingkungan produksi
// echo "Koneksi berhasil!";
?>
