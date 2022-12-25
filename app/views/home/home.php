<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG BEE</title>
    <link rel="stylesheet" href="app/views/home/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
<div id="pop-up">
    <div class="close-button" onclick="closePopUp()">
        <h1>X</h1>
    </div>
    <div class="container">
        <img src="app/views/home/img/pgbee.png" class="pg-icon">
        <div class="discount-ads">
            <h1>50% OFF</h1>
            <h2>on all products</h2>
        </div>
    </div>
</div>

<div class="main-container">
    <div class="nav-bar">
        <div class="logo">
            <a href="#">
                <img src="app/views/home/img/pgbee.png" alt="logo">
                <p>PgBee</p>
            </a>
        </div>
        <div class="nav-links">
            <ul>
                <li id="btn-order" style="display: none;"><a href="/order" target="_blank">Order Now</a>
                </li>
                <li><a href="#footer">Contact</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#">Home</a></li>
            </ul>
        </div>
    </div>

    <div class="content-container">
        <div class="title">
            <h1>PG BEE</h1>
            <p>
                We produces honey jam and other honey products with high quality and affordable price.
            </p>
        </div>
        <div class="button">
            <img src="app/views/home/img/pgbee_icon.png">
            <a href="/order" target="_blank">Order Now</a>
        </div>
        <div class="image" id="home-image">
            <img src="app/views/home/img/pg-product0.png">
        </div>
    </div>

    <div class="products" id="products">
        <div class="title">
            <h1>Our Products</h1>
        </div>
        <div class="product-item">
            <div class="product-img">
                <a href="https://open.spotify.com/album/7zfmFf6krDP8vc1HQW2Z8h?si=z9oJg2nPQ2W4Ecx-iDD6AA"
                   id="product-link" target="_blank">
                    <img src="app/views/home/img/pg-product2.png" id="product-image">
                </a>
            </div>
            <div class="prev" onclick="prevImage()">
                <img src="app/views/home/img/arrows_prev.png">
            </div>
            <div class="next" onclick="nextImage()">
                <img src="app/views/home/img/arrows_next.png">
            </div>
        </div>
        <div class="product-desc">
            <h1 id="product-title">
                MMY Honey Jam
            </h1>
            <p id="product-desc">
                Best out of the best, this best seller product made by 100% pure honey from the best honey bees in
                the world. This honey jam is the best for your breakfast, lunch, dinner, and even for your midnight
                snack.
            </p>
        </div>
    </div>

    <div class="about-us" id="about-us">
        <div class="about-container">
            <div class="about-title">
                <h1>About Us</h1>
            </div>

            <div class="about-desc">
                <p>
                    PG BEE is a company that produces honey jam and other bee products with high quality and affordable price. We are located in the heart of the city, Tokyo, Japan. We are a company that is committed to providing the best products for our customers. Our products come from the best honey farms in the world, and we make sure that our products are made with the best ingredients.
                </p>
            </div>
        </div>
    </div>

    <div class="footer" id="footer">
        <div class="footer-logo">
            <img src="app/views/home/img/pgbee.png" alt="logo">
        </div>
        <div class="footer-links">
            <img src="app/views/home/img/ig.png"></img>
            <img src="app/views/home/img/weibo.png"></img>
            <img src="app/views/home/img/fb.png"></img>
        </div>
        <div class="footer-bottom">
            <p>© 2022 PG BEE. All Rights Reserved.</p>
        </div>
    </div>
</div>

<script src="app/views/home/script.js"></script>
</body>

</html>