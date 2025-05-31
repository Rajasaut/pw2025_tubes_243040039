<?php
require "session.php";
require "koneksi.php";
$query = mysqli_query($conn, "SELECT * FROM donations");
$jumlahdonations = mysqli_num_rows($query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
    .container {
        padding-top: 100px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

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
                <li class="breadcrumb-item active" aria-current="page">donations</li>
            </ol>
        </nav>
        <!-- tambah donations -->
        <div class="my-4  col-12 col-md-12"></div>
        <div class="mt-3">
            <h3 class="mt-5">List donations</h3>
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>Campaigns </th>
                            <th>User </th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal donasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahdonations == 0) {
                        ?>
                            <tr>
                                <td colspan=6 class="text-center">Data donations tidak tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['campaign_id']; ?></td>
                                    <td><?php echo $data['user_id']; ?></td>
                                    <td><?php echo $data['jumlah']; ?></td>
                                    <td><?php echo $data['status']; ?></td>
                                    <td><?php echo $data['tanggal_donasi']; ?></td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>


                    </tbody>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>