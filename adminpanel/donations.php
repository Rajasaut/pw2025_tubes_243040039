<?php
require "session.php";
require "koneksi.php";
$user_id = $_SESSION['user_id'];

// Ambil semua donations beserta data campaign dan user
$query = mysqli_query(
    $conn,
    "SELECT donations.*, users.username, campaigns.judul 
     FROM donations 
     JOIN users ON donations.user_id = users.id 
     JOIN campaigns ON donations.campaign_id = campaigns.id 
     ORDER BY donations.tanggal_donasi DESC"
);
$jumlahdonations = mysqli_num_rows($query);

$querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns");

// untuk bagian  Upload gambar dengan nama acak agar tidak menimpa file lain, misalnya nama file sama .
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString = $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<style>
    .container {
        padding-top: 100px;
    }

    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../adminpanel" class="no-decoration">
                        <i class="bi bi-house-fill text-muted"> Home</i>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Donations</li>
            </ol>
        </nav>

        <!-- Tambah donations -->
        <h3>Tambah Donation</h3>
        <div class="my-4 col-12 col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="judul">Judul Campaign</label>
                    <select name="campaign_id" id="campaign_id" class="form-control" required>
                        <option value="">Pilih satu</option>
                        <?php while ($data = mysqli_fetch_array($querycampaigns)) { ?>
                            <option value="<?= $data['id'] ?>"><?= htmlspecialchars($data['judul']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="jumlah">Jumlah Donasi</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending">⏳ Menunggu Konfirmasi</option>
                        <option value="confirmed">✔️ Donasi Dikonfirmasi</option>
                        <option value="rejected">❌ Donasi Ditolak</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
            <?php
            if (isset($_POST['simpan'])) {
                // Ambil semua input
                $campaign_id = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
                $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';
                $jumlah = isset($_POST['jumlah']) ? htmlspecialchars($_POST['jumlah']) : '';

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($campaign_id == 0 || $jumlah == '') {
            ?>
                    <div class="alert alert-danger mt-3">Bagian Judul Campaign dan Jumlah Wajib Diisi</div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 500000) {
                    ?>
                            <div class="alert alert-danger mt-3">File tidak boleh lebih dari 500 KB</div>
                        <?php
                        } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
                        ?>
                            <div class="alert alert-danger mt-3">File wajib bertipe jpg, png, atau gif</div>
                        <?php
                        } else {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                        }
                    } else {
                        $new_name = ''; // jika tidak upload gambar
                    }

                    // Jalankan query insert
                    $queryTambah = mysqli_query($conn, "INSERT INTO donations (user_id, campaign_id, jumlah, foto, status) VALUES ($user_id, $campaign_id, '$jumlah', '$new_name', '$status')");


                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-success mt-2">Donations berhasil tersimpan</div>
                        <meta http-equiv="refresh" content="3; url=donations.php">
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
            ?>

        </div>
        <!-- List donations -->
        <div class="mb-5">
            <h3 class="mt-5">List Donations</h3>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Campaign</th>
                            <th>Donatur</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Donasi</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahdonations == 0) {
                            echo '<tr><td colspan="8" class="text-center">Data donations tidak tersedia</td></tr>';
                        } else {
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($data['judul']) ?></td>
                                    <td><?= htmlspecialchars($data['username']) ?></td>
                                    <td>Rp <?= number_format($data['jumlah'], 0, ',', '.') ?></td>
                                    <td><?= ucfirst($data['status']) ?></td>
                                    <td><?= $data['tanggal_donasi'] ?></td>
                                    <td>
                                        <?php if ($data['foto']) { ?>
                                            <img src="uploads/<?= $data['foto'] ?>" width="100" alt="_Foto">
                                        <?php } else {
                                            echo '-';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="edit_donations.php?id=<?php echo $data['id']; ?>" class="btn btn-info btn-sm bi bi-search"> Detail</a>
                                        <a href="hapus_donations.php?id=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm bi bi-trash3" onclick="return confirm('Yakin hapus?')"> Hapus</a>
                                    </td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>