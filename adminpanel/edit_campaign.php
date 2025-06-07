<?php
require "session.php";
require "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM campaigns WHERE id='$id'");
$data = mysqli_fetch_array($query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detai campaign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
    .container {
        margin-top: 100px;
    }
</style>

<body>
    <!-- Untuk menu edit (kalau ada yg salah bisa di edit) -->
    <?php require "navbar.php"; ?>
    <div class="container">
        <h2 class="mt-4">Edit Campaign</h2>
        <div class="my-5 col-12 col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>">
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="target_donasi" class="form-label">Target Donasi</label>
                    <input type="number" name="target_donasi" id="target_donasi" class="form-control" value="<?= $data['target_donasi'] ?>">
                </div>

                <div>
                    <label for="currentfoto">Foto Sekarang</label>
                    <img src="../uploads/<?php echo $data['foto'] ?>" alt="" width="300px">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="aktif" <?= $data['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="selesai" <?= $data['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <button type="sub   mit" name="editBtn" class="btn btn-primary">Simpan Perubahan</button>
                <a href="campaigns.php" class="btn btn-secondary">Batal</a>
            </form>

            <?php
            if (isset($_POST['editBtn'])) {
                $judul = htmlspecialchars($_POST['judul']);
                $deskripsi = htmlspecialchars($_POST['deskripsi']);
                $target_donasi = $_POST['target_donasi'];
                $status = $_POST['status'];

                // Cek apakah upload foto baru
                if ($_FILES['foto']['name'] != '') {
                    $foto = $_FILES['foto']['name'];
                    $tmp = $_FILES['foto']['tmp_name'];
                    move_uploaded_file($tmp, '../uploads/' . $foto);
                } else {
                    $foto = $data['foto']; // dari campaign yang sedang diedit
                }

                // Cek apakah judul sudah dipakai oleh campaign lain (kecuali campaign ini sendiri)
                $cek_judul = mysqli_query($conn, "SELECT id FROM campaigns WHERE judul = '$judul' AND id != '$id'");
                if (mysqli_num_rows($cek_judul) > 0) {
                    echo '<div class="alert alert-warning mt-3">Judul campaign sudah digunakan oleh campaign lain.</div>';
                } else {
                    // Lanjut update
                    $update = mysqli_query($conn, "UPDATE campaigns SET 
            judul = '$judul',
            deskripsi = '$deskripsi',
            target_donasi = '$target_donasi',
            foto = '$foto',
            status = '$status'
            WHERE id = '$id'");

                    if ($update) {
                        echo '<div class="alert alert-success mt-2">Data berhasil diperbarui!</div>';
                        echo '<meta http-equiv="refresh" content="3; url=campaigns.php">';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Gagal memperbarui data: ' . mysqli_error($conn) . '</div>';
                    }
                }
            }

            // untuk menghapus data
            function hapus($id)
            {
                global $conn;
                mysqli_query($conn, "DELETE FROM campaigns WHERE id = $id");

                return mysqli_affected_rows($conn);
            }




            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>