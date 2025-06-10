<?php
require "./adminpanel/koneksi.php";

$judul = htmlspecialchars($_GET['judul']);
$querycampaigns = mysqli_query($conn, " SELECT * FROM campaigns WHERE judul='$judul'");
$campaigns = mysqli_fetch_array($querycampaigns);

// bagian donasi terkait 
$querycampaignsterkait = mysqli_query($conn, "SELECT judul, foto FROM campaigns WHERE foto!='{$campaigns['foto']}' LIMIT  4");
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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <?php require "navbar.php";  ?>

    <!-- detail tentang donasi  -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mt-5 ">
                    <img src="./uploads/<?php echo $campaigns['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 my-5  offset-md-1">
                    <h1> <?php echo $campaigns['judul']; ?></h1>
                    <p class="lg-5">
                        <?php echo $campaigns['deskripsi']; ?>
                    <p class="text-target_donasi">
                        target donasi kita Rp: <?php echo $campaigns['target_donasi']; ?>
                    </p>
                    <p class="fs-5">Status aktif atau selesai : <strong><?php echo $campaigns['status']; ?></strong></p>
                    <a href="kirim_donasi.php" class="nav-link"><button class=" btn btn-primary">Donasi Sekarang</button></a>
                </div>
            </div>
        </div>
    </div>

    <!-- donations terkait -->
    <div class="container-fluid py warna2">
        <div class="contain">
            <h2 class="text-center text-whitec mb-5">donations terkait</h2>
            <div class="row">

                <?php while ($data = mysqli_fetch_array($querycampaignsterkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3 uploads-box">
                        <a href="donations-detail.php?judul=<?php echo $data['judul']; ?>">
                            <img src="./uploads/<?= $data['foto']; ?>" class="img-fluid img-thumbnail " alt="">
                        </a>
                    </div>
                <?php  } ?>
            </div>
        </div>
    </div>

    <!-- Untuk footer  -->
    <?php require "footer.php"; ?>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>