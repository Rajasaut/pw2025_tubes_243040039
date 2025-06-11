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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>List Donations</title>
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

    body {
        background: linear-gradient(135deg, #f0f4ff, #dbeafe);
        min-height: 100vh;
        padding-top: 40px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container text-center ">
        <h2>List Donations</h2>
        <?php if (isset($_GET['email']) && $_GET['email'] == 'sukses') {
            echo "<div class='alert alert-success'>Donasi berhasil ditambahkan</div>";
        } ?>
        <div class="table-responsive">
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Campaign</th>
                        <th>Donatur</th>
                        <th>Jumlah</th>
                        <th>email</th>
                        <th>Tanggal Donasi</th>
                        <th>Bukti Donasi</th>
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
                                <td><?= htmlspecialchars($data['email'] ?? '') ?></td>

                                <td><?= $data['tanggal_donasi'] ?></td>
                                <td>
                                    <?= $data['foto'] ? "<img src='../image/{$data['foto']}'  height='100' width='100'>" : '-' ?>
                                </td>

                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>