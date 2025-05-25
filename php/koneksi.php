<?php
//coneksi ke db & pilih Databese
$conn = mysqli_connect('localhost', 'root', '', 'bengkel_db');

//query isi tabel mahasiswa
$result = mysqli_query($conn, "SELECT * FROM users");
$result = mysqli_query($conn, "SELECT * FROM campaigns");
$result = mysqli_query($conn, "SELECT * FROM donations");

// Untuk Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
