<?php
//coneksi ke db & pilih Databese
$conn = mysqli_connect('localhost', 'root', '', 'bengkel_db');

//query isi tabel mahasiswa
$result = mysqli_query($conn, "SELECT * FROM users");

//<-------------------------------------- cara ke 2 untuk mengkonekan ke db & pilih database-------------------------------------------->//
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "nama_database";
// $dbname = "bengkel_db";

// Membuat koneksi ke database
// $conn = new mysqli($servername, $username, $password, $dbname);

// Untuk Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
