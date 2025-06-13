<?php
require "session.php";
require "koneksi.php";

$query = mysqli_query(
    $conn,
    "SELECT donations.*, users.username, campaigns.judul 
     FROM donations 
     JOIN users ON donations.user_id = users.id 
     JOIN campaigns ON donations.campaign_id = campaigns.id 
     ORDER BY donations.tanggal_donasi DESC"
);

$jumlahdonations = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>List Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font-bootstrap-icons.css">
    <style>
        .container {
            padding-top: 100px;
        }

        .zoomable-img {
            cursor: zoom-in;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff, #dbeafe);
            min-height: 100vh;
            padding-top: 40px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            max-width: 40%;
            max-height: 80%;
            border: 5px solid #fff;
            border-radius: 10px;
            box-shadow: 0 0 5px #fff;
        }

        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10;
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container text-center">
        <h2>List Donations</h2>
        <?php if (isset($_GET['email']) && $_GET['email'] == 'sukses') : ?>
            <div class='alert alert-success'>Donasi berhasil ditambahkan</div>
        <?php endif ?>
        <div class="table-responsive">
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Campaign</th>
                        <th>Donatur</th>
                        <th>Jumlah</th>
                        <th>Email</th>
                        <th>Tanggal Donasi</th>
                        <th>Bukti Donasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($jumlahdonations == 0) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Data donations tidak tersedia</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1 ?>
                        <?php while ($data = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= htmlspecialchars($data['judul']) ?> </td>
                                <td><?= htmlspecialchars($data['username']) ?> </td>
                                <td>Rp <?= number_format($data['jumlah'], 0, ',', '.') ?> </td>
                                <td><?= htmlspecialchars($data['email'] ?? '') ?> </td>
                                <td><?= $data['tanggal_donasi'] ?> </td>
                                <td>
                                    <?= $data['foto'] ? "<img src='../image/{$data['foto']}' class='zoomable-img' height='100' width='100'>" : '-' ?>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <span id="close" class="close">&times;</span>
        <img id="modal-img" class="modal-content">
    </div>

    <script>
        // Mengaktifkan modal saat gambar di-klik
        document.querySelectorAll('.zoomable-img').forEach(function(img) {
            img.addEventListener('click', function() {
                document.getElementById('modal-img').src = this.src;
                document.getElementById('modal').classList.add('active');
            });
        });

        // Menghilangkan modal saat close di-klik
        document.getElementById('close').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('active');
        });

        // Menghilangkan modal saat area di luar gambar di-klik
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target == modal) {
                modal.classList.remove('active');
            }
        });
    </script>



</body>

</html>