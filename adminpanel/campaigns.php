<?php
require "session.php";
require "koneksi.php";

// Fungsi nama acak
function generateRandomString($length = 20)
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
    <title>Campaigns</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .container {
            padding-top: 100px;
        }

        .no-decoration {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../adminpanel" class="no-decoration">
                        <i class="bi bi-house-fill text-muted "> Home</i>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Campaigns</li>
            </ol>
        </nav>

        <div class="my-4 col-12 col-md-12">
            <h3>Tambah Campaign Baru</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul" placeholder="Input nama judul" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="4" placeholder="Input Deskripsi" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="target_donasi" class="form-label">Target Donasi</label>
                    <input type="number" class="form-control" name="target_donasi" placeholder="Input dana donasi" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" name="foto" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <button type="submit" name="simpan_Campaigns" class="btn btn-primary">Simpan</button>
            </form>

            <?php
            $user_id = $_SESSION['user_id'] ?? null;

            if (isset($_POST['simpan_Campaigns'])) {
                if (!$user_id) {
                    echo '<div class="alert alert-danger mt-3">User belum login.</div>';
                } else {
                    $judul = htmlspecialchars($_POST['judul']);
                    $deskripsi = htmlspecialchars($_POST['deskripsi']);
                    $target_donasi = $_POST['target_donasi'];
                    $status = $_POST['status'];

                    $judul_safe = mysqli_real_escape_string($conn, $judul);
                    $queryExist = mysqli_query($conn, "SELECT judul FROM campaigns WHERE judul = '$judul_safe'");
                    $jumlahDataCampaignsBaru = mysqli_num_rows($queryExist);

                    if ($jumlahDataCampaignsBaru > 0) {
                        echo '<div class="alert alert-warning mt-3" role="alert">Campaign sudah ada</div>';
                    } else {
                        // Upload file
                        $target_dir = "../uploads/";
                        $nama_file = basename($_FILES["foto"]["name"]);
                        $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                        $image_size = $_FILES["foto"]["size"];
                        $tmp = $_FILES['foto']['tmp_name'];
                        $error = false;
                        $new_name = '';

                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }

                        if ($nama_file != '') {
                            if ($image_size > 500000) {
                                echo '<div class="alert alert-danger mt-3">File tidak boleh lebih dari 500 KB</div>';
                                $error = true;
                            } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo '<div class="alert alert-danger mt-3">File wajib bertipe jpg, jpeg, png, atau gif</div>';
                                $error = true;
                            } else {
                                $new_name = generateRandomString(20) . '.' . $imageFileType;
                                $upload_path = $target_dir . $new_name;

                                if (!move_uploaded_file($tmp, $upload_path)) {
                                    echo '<div class="alert alert-danger mt-3">Gagal menyimpan file gambar</div>';
                                    $error = true;
                                }
                            }
                        }

                        if (!$error) {
                            $insert = mysqli_query($conn, "INSERT INTO campaigns (user_id, judul, deskripsi, target_donasi, foto, status) 
                                VALUES ('$user_id', '$judul', '$deskripsi', '$target_donasi', '$new_name', '$status')");

                            if ($insert) {
                                echo '<div class="alert alert-success mt-3">Campaign berhasil ditambahkan.</div>';
                                echo '<meta http-equiv="refresh" content="3;url=campaigns.php">';
                            } else {
                                echo '<div class="alert alert-danger mt-3">Gagal menambahkan campaign: ' . mysqli_error($conn) . '</div>';
                            }
                        }
                    }
                }
            }



            ?>
            <h3 class="mt-5">Daftar Campaign</h3>
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Target Donasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns ORDER BY dibuat_pada DESC");
                        $jumlahcampaigns = mysqli_num_rows($querycampaigns);

                        if ($jumlahcampaigns == 0) {
                            echo "<tr><td colspan='6' class='text-center'>Data campaigns tidak ada</td></tr>";
                        } else {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($querycampaigns)) {
                                echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['judul']}</td>
                            <td>" . substr($row['deskripsi'], 0, 50) . "...</td>
                            <td>Rp " . number_format($row['target_donasi'], 0, ',', '.') . "</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='edit_campaign.php?id={$row['id']}' class='btn btn-warning btn-sm bi bi-pencil-square'  >  Edit</a>
                                <a href='hapus_campaign.php? id={$row['id']}' class='btn btn-danger btn-sm bi bi-trash3' onclick='return confirm(\"Yakin hapus? \")'>  Hapus</a>                            
                                </td>
                        </tr>";
                                $no++;
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>