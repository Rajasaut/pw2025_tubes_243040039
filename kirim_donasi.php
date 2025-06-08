<?php
require "./adminpanel/session.php";
require "./adminpanel/koneksi.php";

$user_id = $_SESSION['user_id'];
$querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$error = false;
$error_msg = '';
$success_msg = '';

if (isset($_POST['simpan'])) {
    $campaign_id = (int)$_POST['campaign_id'];
    $email = htmlspecialchars($_POST['email']);
    $jumlah = htmlspecialchars($_POST['jumlah']);

    $target_dir = __DIR__ . "/image/";
    $nama_file = basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $image_size = $_FILES["foto"]["size"];
    $random_name = generateRandomString(20);
    $new_name = $random_name . "." . $imageFileType;
    $upload_path = $target_dir . $new_name;

    // Cek validasi input
    if ($campaign_id == 0 || $jumlah == '') {
        $error = true;
        $error_msg = 'Bagian Judul Campaign dan Jumlah Wajib Diisi';
    } elseif ($nama_file != '') {
        if ($_FILES['foto']['error'] !== 0) {
            $error = true;
            $error_msg = 'Terjadi kesalahan saat upload file.';
        } elseif ($image_size > 500000) {
            $error = true;
            $error_msg = 'File tidak boleh lebih dari 500 KB';
        } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
            $error = true;
            $error_msg = 'File wajib bertipe jpg, png, atau gif';
        } elseif (!move_uploaded_file($_FILES["foto"]["tmp_name"], $upload_path)) {
            $error = true;
            $error_msg = 'Gagal menyimpan file gambar ke: ' . $upload_path;
        }
    } else {
        $new_name = ''; // Jika tidak ada file, kosongkan nama file
    }

    if (!$error) {
        $queryTambah = mysqli_query($conn, "INSERT INTO donations (user_id, campaign_id, jumlah, foto, email) VALUES ($user_id, $campaign_id, '$jumlah', '$new_name', '$email')");
        if ($queryTambah) {
            $success_msg = "<div class='alert alert-success mt-3'>Donasi berhasil ditambahkan.</div>";
        } else {
            $error = true;
            $error_msg = 'Gagal menyimpan ke database: ' . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Yayasan Sosial | Kirim Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container {
        padding-top: 100px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container">
        <h2 class="text-center">Kirim Donation</h2>

        <?php if (!empty($error_msg)) : ?>
            <div class="alert alert-danger mt-3"><?= $error_msg ?></div>
        <?php endif; ?>

        <?php if (!empty($success_msg)) : ?>
            <?= $success_msg ?>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-5">
                <label for="campaign_id" class="form-label">Judul Campaign</label>
                <select name="campaign_id" id="campaign_id" class="form-control" required>
                    <option value="">Pilih satu</option>
                    <?php while ($data = mysqli_fetch_array($querycampaigns)) { ?>
                        <option value="<?= $data['id'] ?>"><?= htmlspecialchars($data['judul']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Donasi</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="email">Email</label>
                <input type="text" class="form-control" name="email" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Kirim</button>
            <a href="donations.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>