<!--main content for order page-->
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-3">
            <input class="form-control me-2 " type="search" placeholder="Search Products" aria-label="Search"
                   id="searchButton">
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 my-3 justify-content-around" id="productList">
        <!--Here your product will be displayed-->
    </div>
</div>


<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cartModalLabel">Your Shopping Cart</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="cartItemList">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <h5 class="fw-bold">Total : Rp <span id="totalPrice"></span></h5>
                <button type="button" class="btn btn-primary" id="checkButton" data-bs-toggle="modal"
                        data-bs-target="#checkoutConfirmModal">Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal fade" id="ordersModal" tabindex="-1" aria-labelledby="ordersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ordersModalLabel">Your Order List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="orderList">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Confirmation Modal -->
<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" aria-labelledby="checkoutConfirmModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="checkoutConfirmModalLabel">Please input a valid shipping address!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <input class="form-control" type="text" placeholder="Your full address" id="shippingAddress">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" id="checkoutButton">Checkout</button>
            </div>
        </div>
    </div>
</div>

<!--Loading-->
<div class="justify-content-center align-items-center loading"
     style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex">
    <div class="spinner-border text-light loading" role="status">
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.loading').css('display', 'none');

        // get all products and display them
        let products = <?= json_encode($products); ?>;
        for (let i = 0; i < products.length; i++) {
            $('#productList').append(`
                <div class="col mb-3 d-flex justify-content-center">
                    <div class="card h-100" style="max-width: 18rem; min-width: 18rem; min-height: 29rem">
                      <img src="app/assets/product_images/${products[i].product_img}" class="card-img-top mx-auto d-block" style="max-height: 14rem; object-fit: contain;" alt="...">
                      <div class="card-body">
                        <h5 class="card-title">${products[i].product_name}</h5>
                        <p class="card-text c-text-collapse">${products[i].product_desc}</p>
                        <h5 class="card-title mb-3">Rp ${(parseInt(products[i].product_price).toLocaleString()).replace(',', '.')}</h5>
                        <button value="${products[i].product_id}" class="btn btn-primary w-100 addToCartButton">Add to cart</button>
                      </div>
                    </div>
                </div>
            `);
        }

        // Start add to cart button listener
        setAddCartListener();

        // get cart items and display them in the modal
        $('#cartButton').click(function () {
            $.ajax({
                url: '/cart/get_user_cart',
                method: 'GET',
                success: function (response) {
                    let cart = JSON.parse(response);
                    $('#cartItemList').empty();
                    let totalPrice = 0;
                    for (let i = 0; i < cart.length; i++) {
                        $.ajax({
                            url: '/products/find?keyword=' + cart[i].cart_product_id,
                            method: 'GET',
                            async: false,
                            success: function (response) {
                                let product = JSON.parse(response);
                                $('#cartItemList').append(
                                    `
                                        <div class="card mb-3" style="max-width: 30rem;">
                                          <div class="row g-0">
                                            <div class="col-md-4 justify-content-center d-flex">
                                              <img src="app/assets/product_images/${product[0].product_img}" class="img-fluid rounded-start" style="width: 50%; aspect-ratio: 3/2; object-fit: contain" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                              <div class="card-body">
                                                <h5 class="card-title">${product[0].product_name}</h5>
                                                <h5 class="card-text"><small class="text-muted">Rp ${(parseInt(cart[i].cart_price).toLocaleString()).replace(',', '.')}</small></h5>
                                                <div class="row justify-content-evenly align-items-baseline mt-3">
                                                    <div class="col-2 text-center d-flex align-items-baseline">
                                                        <button class="btn btn-outline-danger minusButton" value="${cart[i].cart_id}"><i class="fa-solid fa-minus"></i></button>
                                                    </div>
                                                    <div class="col-2 text-center d-flex align-items-baseline">
                                                        <p class="btn">${cart[i].cart_quantity}</p>
                                                    </div>
                                                    <div class="col-2 text-center d-flex align-items-baseline">
                                                        <button class="btn btn-outline-success plusButton" value="${cart[i].cart_id}"><i class="fa-solid fa-plus"></i></button>
                                                    </div>
                                                    <div class="col-4">
                                                        <button value="${cart[i].cart_id}" class="btn btn-danger removeButton">Remove</button>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    `
                                );
                                totalPrice += parseInt(cart[i].cart_price);
                            }
                        });
                    }
                    setCartModalListener();
                    $('#totalPrice').text(totalPrice.toLocaleString().replace(',', '.'));
                }
            });
        });

        // get order list and display them in the modal
        $('#orderListButton').click(() => {
            $.ajax({
                url: '/order/get_user_orders',
                method: 'GET',
                success: (response) => {
                    let orders = JSON.parse(response);
                    $('#orderList').empty();

                    // display order list to the modal
                    orders.forEach((order) => {

                        // get product name from each order to display it in the modal
                        let products;
                        $.ajax({
                            url: '/order_item/get_products_by_order?order_id=' + order.order_id,
                            method: 'GET',
                            async: false,
                            success: (response) => {
                                products = JSON.parse(response);
                                console.log(products);
                            }
                        });
                        let products_name = '[';
                        products.forEach((product) => {
                            products_name += product.product_name + ', ';
                        });
                        products_name = products_name.substring(0, products_name.length - 2);
                        products_name += ']';

                        $('#orderList').append(
                            (`
                                        <div class="card mb-3" style="max-width: 30rem;">
                                          <div class="row">
                                            <div class="col-md-8">
                                              <div class="card-body pb-1">
                                                <h5 class="card-title text-truncate mb-0">${products_name}</h5>
                                                <p class="card-text mb-0">${products.length} product/s</p>
                                                <h5 class="card-text"><small class="text-muted">Rp ${(parseInt(order.order_amount).toLocaleString()).replace(',', '.')}</small></h5>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row justify-content-between px-3">
                                               ${
                                (order.order_status === 0)
                                    ? `<p class="mb-0 text-warning"><span class="text-black fw-bold">Status :</span> Pending, waiting for your payment</p>`
                                    : `<p class="mb-0 text-success"><span class="text-black fw-bold">Status :</span> Success</p>`
                            }
                                          </div>
                                          <div class="row justify-content-between align-items-baseline px-3">
                                              <div class="col justify-content-start d-flex">
                                                  <p class="text-nowrap">${order.order_date}</p>
                                              </div>
                                              <div class="col justify-content-end d-flex">
                                                  ${
                                (order.order_status === 0) ? `<button onclick="payOrder(${order.order_id})" class="btn btn-success">Pay</button>` : ''
                            }
                                              </div>
                                          </div>
                                        </div>
                                    `)
                        );

                    });
                }
            });
        });

        $('#logoutButton').click(function () {
            $.ajax({
                url: '/user/login/delete_session',
                type: 'POST',
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });
        });

        $('#searchButton').keyup(function () {
            let keyword = $(this).val();
            $.ajax({
                url: '/products/find?keyword=' + keyword,
                type: 'GET',
                success: function (response) {
                    let products = JSON.parse(response);
                    $('#productList').empty();
                    if (products.length == 0) $('#productList').append('<h3 class="text-center my-5">No products found</h3>');
                    for (let i = 0; i < products.length; i++) {
                        $('#productList').append(`
                            <div class="col mb-3 d-flex justify-content-center">
                                <div class="card h-100" style="max-width: 18rem; min-width: 18rem; min-height: 29rem;">
                                  <img src="app/assets/product_images/${products[i].product_img}" class="card-img-top mx-auto d-block" style="max-height: 14rem; object-fit: contain; alt="...">
                                  <div class="card-body">
                                    <h5 class="card-title">${products[i].product_name}</h5>
                                    <p class="card-text c-text-collapse">${products[i].product_desc}</p>
                                    <h5 class="card-title mb-3">Rp ${(parseInt(products[i].product_price).toLocaleString()).replace(',', '.')}</h5>
                                    <button value="${products[i].product_id}" class="btn btn-primary w-100 addToCartButton">Add to cart</button>
                                  </div>
                                </div>
                            </div>
                        `);
                    }
                    setAddCartListener();
                }
            });
        });

        $('#checkoutButton').click(() => {
            $.ajax({
                url: '/order/checkout',
                type: 'POST',
                data: {
                    'shipping_address': $('#shippingAddress').val(),
                },
                success: function (response) {
                    alert(JSON.parse(response).message);
                    window.location.reload();
                }
            });
        });
    });

    // set listener for add to cart button
    // note: since the button is dynamically created, I need to set the listener after the button is created
    function setAddCartListener() {
        $('.addToCartButton').click(function () {
            if (<?= !isset($_SESSION['user']) ? 'true' : 'false' ?>) {
                alert('Please login first!');
                window.location.href = '/user/login';
                return;
            }

            let product_id = $(this).val();
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: {
                    product_id: product_id
                },
                success: function (response) {
                    if (response == 'true') {
                        alert('Product added to cart!');
                    } else {
                        alert('Failed to add product to cart!');
                    }
                }
            });
        });
    }

    // set listener for all button in modal
    // note: since the button is dynamically created, I need to set the listener after the button is created
    function setCartModalListener() {
        $('.removeButton').click(function () {
            let cart_id = $(this).val();
            if (confirm('Are you sure you want to remove this item from cart?'))
                $.ajax({
                    url: '/cart/remove',
                    type: 'POST',
                    data: {
                        cart_id: cart_id
                    },
                    success: function (response) {
                        if (response == 'true') {
                            $('#cartModal').modal('hide');
                            setTimeout(function () {
                                $('#cartButton').click();
                            }, 300);
                        } else {
                            alert(response);
                            alert('Failed to remove product from cart!');
                        }
                    }
                });
        });

        $('.plusButton').click(function () {
            let cart_id = $(this).val();
            $.ajax({
                url: '/cart/plus',
                type: 'POST',
                data: {
                    cart_id: cart_id
                },
                success: function (response) {
                    if (response == 'true') {
                        $('#cartModal').modal('hide');
                        setTimeout(function () {
                            $('#cartButton').click();
                        }, 300);
                        return;
                    }
                    alert(response);
                }
            });
        });

        $('.minusButton').click(function () {
            let cart_id = $(this).val();
            $.ajax({
                url: '/cart/minus',
                type: 'POST',
                data: {
                    cart_id: cart_id
                },
                success: function (response) {
                    if (response == 'true') {
                        $('#cartModal').modal('hide');
                        setTimeout(function () {
                            $('#cartButton').click();
                        }, 300);
                        return;
                    }

                    if (response == 'false') {
                        $("button").filter(function () {
                            return $(this).val() == cart_id && $(this).hasClass("removeButton");
                        }).click();
                        return;
                    }
                    alert(response);
                }
            });
        });
    }

    function payOrder(order_id) {
        $('.loading').css('display', 'flex');
        $.ajax({
            url: '/order/send_mail',
            type: 'POST',
            data: {
                order_id: order_id
            },
            success: function (response) {
                alert(JSON.parse(response).message);
                window.location.href = '/payment?order_id=' + order_id;
                $('.loading').css('display', 'none');
            }
        });
    }
</script>