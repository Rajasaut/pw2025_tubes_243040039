<?php
require "./adminpanel/koneksi.php";

// Default: semua campaigns
$querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns");

// Filter berdasarkan keyword
if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns WHERE judul LIKE '%$keyword%'");
}

// Filter berdasarkan judul campaign
if (isset($_GET['campaigns'])) {
    $campaign = mysqli_real_escape_string($conn, $_GET['campaigns']);
    $queryGetcampaignsId = mysqli_query($conn, "SELECT id FROM campaigns WHERE judul='$campaign'");
    $campaignsId = mysqli_fetch_array($queryGetcampaignsId);

    if ($campaignsId && isset($campaignsId['id'])) {
        $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns WHERE id = '{$campaignsId['id']}'");
    } else {
        $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns");
    }
}

// Simpan hasil query dalam array agar bisa digunakan dua kali
$all_campaigns = [];
while ($c = mysqli_fetch_array($querycampaigns, MYSQLI_ASSOC)) {
    $all_campaigns[] = $c;
}

$coundata = mysqli_num_rows($querycampaigns);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi | Yayasan Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/donations.css">
</head>

<body>
    <?php require "navbar.php";  ?>

    <!-- bagian bannernya -->
    <div class="container-fluid banner-campaigns d-flex align-items-center ">
        <div class="container">
            <h1 class="text-white">Campaigns</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Judul Campaign</h3>
                <ul class="list-group">
                    <?php foreach ($all_campaigns as $c) { ?>
                        <a class="no_decoration" href="donations.php?campaigns=<?= urlencode($c['judul']) ?>">
                            <li class="list-group-item"><?= htmlspecialchars($c['judul']) ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h2 class="text-center mb-3">Donations</h2>
                <div class="row">
                    <?php
                    if ($coundata < 1) {
                    ?>
                        <h3 class="text-center my-3">Tempa donasi yang anda cari belum ada di organisasi kami 🙏 </h3>
                    <?php
                    }
                    ?>

                    <?php foreach ($all_campaigns as $c) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="uploads-box">
                                    <img src="./uploads/<?= htmlspecialchars($c['foto']) ?>" class="card-img-top" alt="Foto Campaign">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($c['judul']) ?></h5>
                                    <p class="card-text text-truncate"><?= htmlspecialchars($c['deskripsi']) ?></p>
                                    <p class="card-text">Rp <?= number_format($c['target_donasi'], 0, ',', '.') ?></p>
                                    <a href="donations-detail.php?judul=<?= urlencode($c['judul']) ?>" class=" btn btn-primary">Donasi Sekarang</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Untuk footer  -->
    <?php require "footer.php"; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>