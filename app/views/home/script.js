window.onscroll = function () {
    animationOnScroll()
};
let height = document.querySelector(".content-container").clientHeight - 20;
let navBar = document.getElementsByClassName("nav-bar")[0];
let btnOrder = document.getElementById("btn-order");
let productItem = document.getElementsByClassName("product-item")[0];
let homeImage = document.getElementById("home-image");

function animationOnScroll() {
    // scroll on home page
    if (document.documentElement.scrollTop > height) {
        navBar.style.backgroundColor = "RGBA(250, 228, 181, 0.9)";
        navBar.style.padding = "10px 0px 10px 24px";
        btnOrder.style.display = "block";

        homeImage.style.opacity = "0";
        homeImage.style.transform = "translatex(200%)";

        $(".content-container .title").fadeOut(100);
        $(".content-container a").slideUp(100);
    } else {
        navBar.style.backgroundColor = "RGBA(250, 250, 250, 0.9)";
        navBar.style.padding = "10px 24px 10px 24px";
        btnOrder.style.display = "none";

        homeImage.style.opacity = "1";
        homeImage.style.transform = "translatex(0)";

        $(".content-container .title").fadeIn(800);
        $(".content-container a").slideDown(800);
    }

    // scroll on product page
    if (document.documentElement.scrollTop > height / 2 && document.documentElement.scrollTop < height * 2) {
        productItem.style.transform = "translatex(0px)";
        productItem.style.opacity = "1";

        showProductDesc(800);
    } else {
        productItem.style.transform = "translatex(-200%)";
        productItem.style.opacity = "0";

        hideProductDesc(100);
    }

    // scroll on about page
    if (document.documentElement.scrollTop > height * 1.3) {
        $(".about-us .about-container").fadeIn(800);
    } else {
        $(".about-us .about-container").fadeOut(100);
    }
}

// Resources
let images = [
    "app/views/home/img/pg-product2.png",
    "app/views/home/img/pg-product3.png",
    "app/views/home/img/pg-product4.png"
];

let imageTitles = [
    "MMY Honey Jam",
    "Hell Like Heaven Honey Jam",
    "The Garden Honey Jam"
];

let imageDescs = [
    "Best out of the best, this best seller product made by 100% pure honey from the best honey bees in the world. This honey jam is the best for your breakfast, lunch, dinner, and even for your midnight snack.",
    "Spicy as hell but sweet as heaven, this honey jam is the best for your breakfast, lunch, dinner, and even for your midnight snack.",
    "Lemon and honey, the best combination for your breakfast, lunch, dinner, and even for your midnight snack."
];

let imageLinks = [
    "https://open.spotify.com/album/7zfmFf6krDP8vc1HQW2Z8h?si=z9oJg2nPQ2W4Ecx-iDD6AA",
    "https://open.spotify.com/album/4BwNfk4ijLhq6O4GzkNl6a?si=FSNqIwH0QQWhXHardiYhmw",
    "https://open.spotify.com/album/13FIa91YpnboJjrwmKRrG8?si=D6JlHn1OTTWJTQIx-8sPzA"
];

let aboutImages = [
    "app/views/home/img/pg-about1.jpg",
    "app/views/home/img/pg-about2.jpg",
    "app/views/home/img/pg-about3.jpg",
    "app/views/home/img/pg-about4.jpg"
]
// Resources

// Indexes
let productIndex = 0;

let aboutIndex = 0;
// Indexes

// Reusable function
function animateProductOnChange() {
    let img = document.getElementById("product-image");
    img.style.opacity = "0";
    hideProductDesc(400, true);
    setTimeout(() => {
        img.src = images[productIndex];
        img.style.opacity = "1";
        document.getElementById("product-title").innerHTML = imageTitles[productIndex];
        document.getElementById("product-desc").innerHTML = imageDescs[productIndex];
        document.getElementById("product-link").href = imageLinks[productIndex];
        showProductDesc(400, true);
    }, 500);
}

function nextImage() {
    productIndex++;
    if (productIndex >= images.length) {
        productIndex = 0;
    }
    animateProductOnChange();
}

function prevImage() {
    productIndex--;
    if (productIndex < 0) {
        productIndex = images.length - 1;
    }
    animateProductOnChange();
}

// JQuery
$(document).ready(function () {

    // On close pupup button
    $(".close-button").click(function () {
        $("#pop-up").fadeOut();

        $("#home-image").css("opacity", "1");
        $("#home-image").css("transform", "translatex(0)");

        $(".content-container .title").fadeIn(800);
        $(".content-container a").slideDown(800);
    });

    // About page background carousel
    window.setInterval(
        function () {
            aboutIndex++;
            if (aboutIndex >= aboutImages.length) {
                aboutIndex = 0;
            }
            $(".about-container").css(
                "background-image",
                "linear-gradient(to bottom, rgba(254, 208, 120, 0.7),rgba(255, 255, 255, 0.7)) , url(" + aboutImages[aboutIndex] + ")"
            );
        },
        3000
    );

});

// Reusable function
function showProductDesc(duration, isFade = false) {
    if (isFade) {
        $(".products .product-desc").fadeIn(duration);
        return
    }
    $(".products .product-desc").slideDown(duration);
}

function hideProductDesc(duration, isFade = false) {
    if (isFade) {
        $(".products .product-desc").fadeOut(duration);
        return
    }
    $(".products .product-desc").slideUp(duration);
}