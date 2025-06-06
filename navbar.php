<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Boostep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        /* bagian navbar  */
        .navbar {
            background: #f8f9fa91;
            backdrop-filter: blur(10px);
        }

        .navbar-collapse {
            position: absolute;
            width: 100%;
            top: 60px;
            left: 0;
            padding: 6px 20px;
            border-radius: 25px;
            background: #f8f9fa91;
        }


        @media (min-width: 992px) {
            .navbar-collapse {
                position: relative;
                top: 0;
                background: none;
            }
        }

        body {
            height: 2000px;
        }

        .bg img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .navbar-brand {
            color: darkblue;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg rounded-pill px-4 m-4 fixed-top ">
        <div class="container-fluid ">
            <a class="navbar-brand" href="index.php">Organisasi Yayasan Sosial</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentang_kami.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donations.php">campaigns</a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="bg">
        <!-- <img src="img/bacground.jpg" alt=""> -->
    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>