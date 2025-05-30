<?php require "session.php";
require "koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<style class="css">
    .container {
        padding-top: 100px;
    }

    .kotak {
        border: solid;
    }

    .summary-campaigns {
        background-color: rgb(47, 128, 221);
        border-radius: 20px;
    }

    .summary-donations {
        background-color: rgb(100, 250, 80);
        border-radius: 20px;
    }

    .col-6 {
        font-size: 90px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-house-fill"> Home</i>
                </li>
            </ol>
        </nav>
        <h2>Hallo <?php echo $_SESSION['login']; ?></h2>

        <!-- Untuk kontak icon campains -->
        <div class="container pt-4 ">
            <div class="row">
                <div class="col-lg-4  col-md-6 col-12 mb-3">
                    <div class="summary-campaigns p-1">
                        <div class="row">
                            <div class="col-6">
                                <i class="bi bi-justify text-dark"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">campaigns</h3>
                                <p class="fs-5"><?php echo $jumlahcampaigns ?> Campaigns</p>
                                <p class="fs-5"> <a href="campaigns.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Untuk kotak icon donasion -->
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-donations p-1">
                        <div class="row">
                            <div class="col-6">
                                <i class="bi bi-wallet-fill text-dark"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">donations</h3>
                                <p class="fs-5"><?php echo $jumlahdonations; ?> Donations</p>
                                <p class="fs-5"> <a href="donations.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>