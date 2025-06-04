<?php
require "koneksi.php";

$id = $_GET["id"];

if (hapus_donations($id) > 0) {
    echo "
<script>
            alert('data berhasil dihapus!.');
            document.location.href = 'donations.php';
        </script>
";
}
