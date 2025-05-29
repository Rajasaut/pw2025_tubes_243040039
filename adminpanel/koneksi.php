<?php
//coneksi ke db & pilih Databese
$conn = mysqli_connect('localhost', 'root', '', 'yayasan_sosial');
//query isi tabel users,campains,samadonations
$result = mysqli_query($conn, "SELECT * FROM users");

// Untuk melihat campains dan donasions 
$querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns");
$jumlahcampaigns = mysqli_num_rows($querycampaigns);

$querydonations = mysqli_query($conn, "SELECT * FROM donations");
$jumlahdonations = mysqli_num_rows($querydonations);


// Untuk Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
