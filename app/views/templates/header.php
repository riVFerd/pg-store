<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bc63c5ed9f.js" crossorigin="anonymous"></script>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <title>PG Bee</title>
    <link rel="shortcut icon" href="app/views/home/img/pgbee.png">
</head>
<body>
<!--Navbar-->
<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand c-title" href="#">
            <img src="app/views/home/img/pgbee.png" onerror="this.src='../app/views/home/img/pgbee.png'" alt="logo" height="48">
            PgBee
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="/">Home Page</a>
                </li>
            </ul>
            <!--right side of navbar-->
            <div class="d-flex align-items-center">
                <?php
                if (!isset($_SESSION['user'])) {
                    echo '<a class="btn btn-dark mx-3 px-3 py-1" href="/user/login">Login</a>';
                    echo '<a class="btn btn-light border border-2 text-nowrap me-3s px-3 py-1" href="/user/signup">Sign Up</a>';
                } else {
                    if ($_SESSION['user']['user_role'] == 1) {
                        echo '<a class="btn btn-dark me-3 px-3 py-1" href="/products">Products</a>';
                        echo '<a class="btn btn-dark me-3 px-3 py-1" href="/user">Users</a>';
                        echo '<a class="btn btn-dark me-3 px-3 py-1" href="/order_list">Order History</a>';
                    }
                    echo '
                        <button type="button" data-bs-toggle="modal" data-bs-target="#ordersModal" class="btn me-3" id="orderListButton"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#cartModal" class="btn me-3" id="cartButton"><i class="fa-solid fa-cart-plus"></i></button>
                        <a class="fw-bold text-decoration-none me-3 text-dark" data-bs-toggle="collapse" href="#popUp" role="button" aria-expanded="false" aria-controls="popUp">
                            Hello, ' . $_SESSION['user']['user_name'] . '
                        </a>
                        <div class="collapse" id="popUp">
                          <div class="card card-body position-absolute top-100" style="right: 1rem">
                            Username : ' . $_SESSION['user']['user_name'] . '<br>
                            Email : ' . $_SESSION['user']['user_email'] . ' <br>
                            <a class="btn btn-outline-danger mt-3" id="logoutButton">Log out</a>
                          </div>
                        </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</nav>