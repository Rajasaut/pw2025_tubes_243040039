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
<style>
    .about-us {
        background: #f5f5f5;
    }

    .about-us h2 {
        color: #003566;
        font-size: 2.5rem;
        font-weight: bold;
    }

    .about-us p {
        color: #555;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .about-us img {
        border-radius: 20px;
        box-shadow: 0 4px 14px rgb(0 0 0 / 0.3);
    }
</style>

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
    <section id="about-us" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Tentang Organisasi Kami</h2>

            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="./adminpanel//img/sombako" alt="Organisasi Sosial" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6">
                    <p>Yayasan Sosial kami adalah sebuah organisasi nirlaba yang didirikan dengan tujuan untuk menciptakan perubahan positif di tengah masyarakat. Kami bergerak dalam bidang kemanusiaan, pendidikan, kesehatan, dan pemberdayaan ekonomi, dengan mengedepankan nilai kepedulian, keadilan, dan solidaritas.</p>

                    <p>Keberadaan kami lahir dari kepedulian terhadap kesenjangan sosial dan keinginan untuk menjadi jembatan kebaikan antara mereka yang ingin membantu dan mereka yang membutuhkan uluran tangan.</p>

                    <p>Kami menjalankan berbagai program sosial seperti pemberian bantuan sembako, pelayanan kesehatan gratis, pembangunan ransel umum, dan bantuan darurat untuk korban bencana alam. Selain itu, kami juga fokus pada pendidikan dengan menyediakan beasiswa dan perlengkapan sekolah bagi anak-anak dari keluarga kurang mampu.</p>

                    <p>Yayasan ini terbuka bagi siapa saja yang ingin berkontribusi, baik secara materi, tenaga, maupun pikiran. Dukungan dari donatur, relawan, dan mitra menjadi kekuatan besar dalam mewujudkan visi kami, yaitu memberikan dampak yang lebih luas dan lebih bermakna bagi penerimanya.</p>

                    <p>Melalui kerja sama dengan berbagai pihak, kami juga berkomitmen untuk terus hadir di tengah masyarakat, membantu yang lemah, menyemangati yang putus asa, dan memberikan harapan bagi yang kehilangan arah. Dengan satu langkah kebaikan, hidup dapat lebih manusiawi dan lebih adil.</p>
                </div>
            </div>


            <div class="row-6">
                <p> Yayasan Sosial adalah organisasi sosial yang berdedikasi untuk membantu masyarakat yang membutuhkan. Kami berkomitmen untuk meningkatkan kualitas hidup masyarakat melalui program-program sosial, pendidikan, dan kesehatan.Yayasan Sosial adalah organisasi sosial yang berdedikasi untuk membantu masyarakat yang membutuhkan. Kami berkomitmen untuk meningkatkan kualitas hidup masyarakat melalui program-program sosial, pendidikan, dan kesehatan.

                <h3>Misi Kami</h3>
                <p>- Membantu masyarakat yang membutuhkan melalui program-program sosial dan kemanusiaan</p>
                <p>- Meningkatkan kualitas hidup masyarakat melalui pendidikan dan pelatihan</p>

                <p>- Mendorong partisipasi masyarakat dalam kegiatan sosial dan kemanusiaan</p>

                <h3>Program Kami</h3>
                <p>- Program Pendidikan: memberikan bantuan pendidikan kepada anak-anak yang membutuhkan</p>
                <p>- Program Kesehatan: memberikan bantuan kesehatan kepada masyarakat yang membutuhkan</p>
                <p>- Program Sosial: memberikan bantuan sosial kepada masyarakat yang membutuhkan</p>

            </div>
        </div>
    </section>

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