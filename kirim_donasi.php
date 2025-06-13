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

// misalnya $id berasal dari GET
// $id = $_GET['id'];
// $query = mysqli_query($conn, "SELECT judul FROM campaigns WHERE id=$id");

// $data = mysqli_fetch_assoc($query);

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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<style>
    .no-decoration {
        text-decoration: none;
    }

    body {
        background: url('./adminpanel/img/Gambar-donasi1.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
        padding: 2rem;
        background-color: rgba(255, 255, 255, 0.95);
        /* Putih solid sedikit transparan */
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        margin: 4rem auto;
        padding-top: 100px;
    }
</style>


<body>
    <!-- Form Donasi -->
    <form action="" method="post" enctype="multipart/form-data">
        <!-- isi form kamu seperti sebelumnya -->
    </form>
    </div>

    <?php require "navbar.php"; ?>
    <div class="container my-5">
        <div class="row">
            <!-- Kirim Donasi (Kiri) -->
            <div class="col-md-6">
                <h2 class="text-start">Kirim Donasi</h2>

                <?php if (!empty($error_msg)) : ?>
                    <div class="alert alert-danger mt-3"><?= $error_msg ?></div>
                <?php endif; ?>

                <?php if (!empty($success_msg)) : ?>
                    <?= $success_msg ?>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" class="mt-4">
                    <div class="mb-3">
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
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Bukti Donasi</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary">Kirim</button>
                    <a href="donations.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>

            <!-- Transfer Donasi (Kanan) -->
            <div class="col-md-6">
                <div class="payment-info text-center">
                    <h5>Transfer Donasi ke:</h5>
                    <p><strong>BCA</strong> - 1234567890 a.n. Yayasan Sosial</p>
                    <p><strong>DANA</strong> - 0813-9570-5998 Yayasan Sosial</p>
                    <p><strong>BJB</strong> - 0987654321 b.a Yayasan Sosial</p>
                    <img src="./adminpanel/img/kode-qr.jpg" alt="QR Code Donasi" class="img-fluid" style="max-width: 200px; border: 1px solid #ccc; padding: 8px; border-radius: 10px;">
                </div>
            </div>
        </div>
    </div>


    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>