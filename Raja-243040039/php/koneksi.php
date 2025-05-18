<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nama_database";
$dbname = "bengkel_db";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Untuk Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
