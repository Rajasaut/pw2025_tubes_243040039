<?php
require "./adminpanel/session.php";
require "./adminpanel/koneksi.php";

// Cek apakah sudah login dan role-nya user
if (!isset($_SESSION['login']) || !isset($_SESSION['role']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin')) {
	header("Location: ./adminpanel/login.php");
	exit();
}

$querycampaigns = mysqli_query($conn, "SELECT id, judul, deskripsi, target_donasi, foto, status FROM campaigns LIMIT 9");


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Yayasan Sosial | Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="./css/donations.css">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>

	<!-- bagian untuk banner -->

	<?php require "navbar.php"; ?>
	<div class="container-fluid banner d-flex align-items-center">
		<div class="container text-center text-white " data-aos="fade-up"
			data-aos-duration="3000">
			<h1>Yayasan Sosial</h1>
			<h4> Anda dapat membatu kami membuat perbedaan dalam kehidupan masyarakat yang membutuhkan. <br>
				Donasi anda dapat disalurkan melalui (informasi donasi)
			</h4>
			<div class="col-md-8 offset-md-2">
				<form method="get" action="donations.php">
					<div class="input-group my-3">
						<input type="text" class="form-control" placeholder="mau donasi kemana"
							aria-label="Recipient’s username" aria-describedby="basic-addon2" name="keyword">
						<button type="submit" class="btn btn-primary text-white">Telusuri</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- highlighted-donations -->
	<div class="container-fluid py-4 text-center">
		<div class="container">
			<h3>campaigns</h3>
			<div class="row mt-5">
				<div class="col-md-4 mb-3">
					<div class="highlighted-donations campaigns-sekolah d-flex justify-content-center align-items-center">
						<h5 class="text-white"><a class="no-decoration" href="donations.php?campaigns=Sekolah"> sekolah di bawah jembatan</a></h5>
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<div class="highlighted-donations campaigns-banjir d-flex justify-content-center align-items-center">
						<h5 class="text-white"><a class="no-decoration" href="donations.php?campaigns=Banjir">banjir bandang</a></h5>
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<div class="highlighted-donations campaigns-roboh d-flex justify-content-center align-items-center">
						<h5 class="text-white"><a class="no-decoration" href="donations.php?campaigns=Runtuh">rumah runtuh</a></h5>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Tentang Organisasi Kami -->
	<div class="containe-fluid warna3 py-5">
		<div class="container">
			<h3 class="text-center">Tentang Organisa Kami</h3>
			<p class="fs-5 mt-3">Yayasan Sosial kami adalah organisasi nirlaba yang berkomitmen untuk meningkatkan kesejahteraan masyarakat melalui berbagai program sosial, pendidikan, dan kemanusiaan. Didirikan dengan semangat kepedulian dan gotong royong, kami hadir untuk menjembatani kebaikan dari para donatur kepada mereka yang membutuhkan.
				Dengan dukungan para relawan dan mitra, kami menyelenggarakan berbagai kegiatan seperti penggalangan dana untuk bantuan bencana, beasiswa pendidikan bagi anak-anak kurang mampu, distribusi sembako, serta program pemberdayaan ekonomi bagi keluarga prasejahtera.
				Kami percaya bahwa perubahan besar dimulai dari langkah kecil. Oleh karena itu, kami mengajak seluruh elemen masyarakat untuk ikut berkontribusi dalam menciptakan kehidupan yang lebih adil dan sejahtera untuk semua.</p>
		</div>
	</div>

	<!-- donations -->
	<div class="container-fluid py-5">
		<div class="container text-center">
			<h3>donations</h3>
			<div class="row mt-5 ">
				<?php while ($data = mysqli_fetch_array($querycampaigns)) { ?>

					<div class="col-sm-6 col-md-4 mb-3">
						<div class="card h-100">
							<div class="uploads-box">

								<img src="./uploads/<?= $data['foto']; ?>" class="card-img-top" alt="Foto Campaign">
							</div>

							<div class="card-body">
								<h5 class="card-title"><?= $data['judul']; ?> </h5>
								<p class="card-text text-truncate"><?= $data['deskripsi']; ?></p>
								<p class="card-text">Target: Rp <?= number_format($data['target_donasi'], 0, ',', '.'); ?></p>
								<a href="donations-detail.php?judul=<?php echo $data['judul']; ?>"
									class="btn btn-primary">Lihat Detail</a>
							</div>
						</div>
					</div>

				<?php } ?>
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