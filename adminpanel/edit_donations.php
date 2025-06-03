<?php

require "session.php";
require "koneksi.php";

// Ambil data donations dan campaigns berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT a.*, b.judul AS judul_campaigns 
                              FROM donations a 
                              JOIN campaigns b ON a.campaign_id = b.id 
                              WHERE a.id = '$id'");

    $data = mysqli_fetch_array($query);

    $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns WHERE id!='$data[campaign_id]'");
}

// Fungsi untuk generate nama acak file
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container {
        margin-top: 100px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container">
        <h2 class="mt-5">Edit Donations</h2>
        <div class="my-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="campaign_id">Judul Campaign</label>
                    <select name="campaign_id" id="campaign_id" class="form-control" required>
                        <option value="<?php echo $data['campaign_id']; ?>"><?php echo $data['judul_campaigns']; ?></option>
                        <?php while ($datacampaigns = mysqli_fetch_array($querycampaigns)) { ?>
                            <option value="<?= $datacampaigns['id'] ?>"><?= htmlspecialchars($datacampaigns['judul']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah">Jumlah Donasi</label>
                    <input type="number" class="form-control" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="currentfoto">Foto Campaign Saat Ini</label><br>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="" width="300px">
                </div>
                <div class="mb-3">
                    <label for="foto">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>⏳ Menunggu Konfirmasi</option>
                        <option value="confirmed" <?= $data['status'] == 'confirmed' ? 'selected' : '' ?>>✔️ Donasi Dikonfirmasi</option>
                        <option value="rejected" <?= $data['status'] == 'rejected' ? 'selected' : '' ?>>❌ Donasi Ditolak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $campaign_id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
                $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';
                $jumlah = isset($_POST['jumlah']) ? htmlspecialchars($_POST['jumlah']) : '';

                if ($campaign_id == 0 || $jumlah == '') {
                    echo '<div class="alert alert-danger mt-3">Bagian Judul Campaign dan Jumlah Wajib Diisi</div>';
                } else {
                    $queryUpdate = mysqli_query($conn, "UPDATE donations SET campaign_id='$campaign_id', status='$status', jumlah='$jumlah' WHERE id=$id");

                    if (!$queryUpdate) {
                        echo '<div class="alert alert-danger mt-3">Gagal mengupdate data utama: ' . mysqli_error($conn) . '</div>';
                    }

                    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
                        if ($_FILES['foto']['error'] !== 0) {
                            echo '<div class="alert alert-danger mt-3">Terjadi error saat upload: ' . $_FILES['foto']['error'] . '</div>';
                        } else {
                            $target_dir = "../image/";
                            $nama_file = basename($_FILES["foto"]["name"]);
                            $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                            $image_size = $_FILES["foto"]["size"];
                            $random_name = generateRandomString(20);
                            $new_name = $random_name . "." . $imageFileType;
                            $target_file = $target_dir . $new_name;

                            if ($image_size > 5000000) {
                                echo '<div class="alert alert-danger mt-3">File tidak boleh lebih dari 5 MB</div>';
                            } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo '<div class="alert alert-danger mt-3">File wajib bertipe jpg, jpeg, png, atau gif</div>';
                            } else {
                                if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {
                                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new)) {
                                        $queryUpdateFoto = mysqli_query($conn, "UPDATE donations SET foto='$new_name' WHERE id='$id'");

                                        if ($queryUpdateFoto) {
                                            echo '<div class="alert alert-success mt-2">Donasi berhasil diupdate dengan foto baru</div>';
                                            echo '<meta http-equiv="refresh" content="3; url=donations.php">';
                                        } else {
                                            echo '<div class="alert alert-danger mt-2">Gagal mengupdate foto di database: ' . mysqli_error($conn) . '</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger mt-3">Upload file gagal: gagal memindahkan file.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-warning mt-3">Tidak ada file yang diupload secara sah.</div>';
                                }
                            }
                        }
                    } else {
                        echo '<div class="alert alert-success mt-2">Donasi berhasil diupdate (tanpa ganti foto)</div>';
                        echo '<meta http-equiv="refresh" content="3; url=donations.php">';
                    }
                }
            }

            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>