<?php
require "session.php";
require "koneksi.php";

// untuk mengubah campaign_id di donasions yg tadiyah angka jadi judul dari campaigns
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT a.*, b.judul AS judul_campaigns 
                              FROM donations a 
                              JOIN campaigns b ON a.campaign_id = b.id 
                              WHERE a.id = '$id'");

    $data = mysqli_fetch_array($query);

    $querycampaigns = mysqli_query($conn, "SELECT * FROM campaigns WHERE id!='$data[campaign_id]'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit donasions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
    .container {
        margin-top: 100px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container ">
        <h2 class="mt-5">Detail Donaions</h2>
        <div class="my-3 ">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="judul">Judul Campaign</label>
                    <select name="campaign_id" id="campaign_id" class="form-control" required>
                        <option value="<?php echo $data['campaign_id']; ?>"><?php echo $data['judul_campaigns']; ?></option>
                        <?php while ($datacampaigns = mysqli_fetch_array($querycampaigns)) { ?>
                            <option value="<?= $datacampaigns['id'] ?>"><?= htmlspecialchars($datacampaigns['judul']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="jumlah">Jumlah Donasi</label>
                    <input type="number" class="form-control" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
                </div>
                <div>
                    <label for="currentfoto">foto Campaigns Sekarang</label>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending">⏳ Menunggu Konfirmasi</option>
                    <option value="confirmed">✔️ Donasi Dikonfirmasi</option>
                    <option value="rejected">❌ Donasi Ditolak</option>
                    <?php echo $data['status']; ?>
                </select>
        </div>
        </form>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>