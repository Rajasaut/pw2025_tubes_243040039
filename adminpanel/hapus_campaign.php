<?php
require "koneksi.php";
require "edit_campaign.php";

$id = $_GET["id"];

// Untuk ngcek apakah campaign masih digunakan di tabel donations
$queryCheck = mysqli_query($conn, "SELECT * FROM donations WHERE campaign_id = '$id'");
$dataCount = mysqli_num_rows($queryCheck);

if ($dataCount > 0) {
    echo "
        <script>
            alert('Campaign tidak bisa dihapus karena sudah digunakan di donations.');
            document.location.href = 'campaigns.php';
        </script>
    ";
    exit;
}


if (hapus($id) > 0) {
    echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'campaigns.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = 'campaigns.php';
        </script>
    ";
}
