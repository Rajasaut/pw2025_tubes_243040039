<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayasan sosial | Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/donations.css">
</head>

<body>
    <?php require "navbar.php";  ?>
    <!-- bagian bannernya -->
    <div class="container-fluid banner-campaigns d-flex align-items-center ">
        <div class="container">
            <h1 class="text-white" data-aos="fade-up"
                data-aos-duration="2000">
                Tentang Organisasi Kami</h1>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="containe-fluid py-5">
        <div class="container text-center fs-5">
            <p class="text-start">
                Yayasan Sosial kami adalah sebuah organisasi nirlaba yang didirikan dengan tujuan utama untuk menciptakan perubahan positif di tengah masyarakat. Kami bergerak dalam bidang kemanusiaan, pendidikan, kesehatan, dan pemberdayaan ekonomi dengan mengedepankan nilai-nilai kepedulian, keadilan, dan solidaritas. Keberadaan kami lahir dari kepedulian terhadap ketimpangan sosial dan keinginan untuk menjadi jembatan kebaikan antara mereka yang ingin membantu dan mereka yang membutuhkan uluran tangan.
            </p>
            <p class="text-start">
                Kami menjalankan berbagai program sosial seperti pemberian bantuan sembako, layanan kesehatan gratis, pembangunan fasilitas umum, serta bantuan darurat untuk korban bencana alam. Selain itu, kami juga fokus pada pendidikan dengan menyediakan beasiswa dan perlengkapan sekolah bagi anak-anak dari keluarga kurang mampu. Kami percaya bahwa pendidikan adalah kunci utama untuk memutus rantai kemiskinan dan membuka jalan menuju masa depan yang lebih cerah.
            </p>
            <p class="text-start">
                Yayasan ini terbuka bagi siapa saja yang ingin berkontribusi, baik secara materi, tenaga, maupun pemikiran. Dukungan dari donatur, relawan, dan mitra menjadi kekuatan besar dalam mewujudkan misi kami. Kami memastikan bahwa setiap bantuan yang disalurkan akan sampai tepat sasaran dan memberikan dampak nyata bagi penerimanya.
            </p>
            <p class="text-start">
                Melalui kerja sama dengan berbagai pihak, kami berkomitmen untuk terus hadir di tengah masyarakat, membantu yang lemah, menyemangati yang putus asa, dan memberikan harapan bagi yang kehilangan arah. Kami percaya bahwa setiap tindakan kebaikan, sekecil apa pun, mampu membawa perubahan besar dalam kehidupan seseorang.
            </p>
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