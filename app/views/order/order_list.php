<div class="container mt-5 pt-5 vh-100">
    <div class="mb-3 pt-5">
        <input type="text" class="form-control w-25" id="inputSearch" placeholder="Search">
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Order id</th>
            <th scope="col">User id</th>
            <th scope="col">Username</th>
            <th scope="col">Shipping address</th>
            <th scope="col">Total Price</th>
            <th scope="col">Order date</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody id="orderList">
        <!--Order list goes here-->
        </tbody>
    </table>
    <div class="row justify-content-center">
        <a href="/order" class="btn btn-secondary w-25 mt-2 mb-5">Back</a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Order id : <span id="orderId"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row text-center fw-bold">
                        <div class="col">
                            <p>Product Name</p>
                        </div>
                        <div class="col">
                            <p>Price (each)</p>
                        </div>
                        <div class="col">
                            <p>Quantity</p>
                        </div>
                        <div class="col">
                            <p>Price total</p>
                        </div>
                    </div>
                    <div id="productList" class="text-center">
                    <!-- Product list detail goes here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <h5>Total price amount : <span id="priceAmount"></span></h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Display all order when page loaded
        let orders = <?= json_encode($orders); ?>;
        orders.forEach((order) => {
            appendOrder(order);
        });
        setTableRowListener();

        $('#inputSearch').keyup(() => {
            let keyword = $('#inputSearch').val().toLowerCase();
            console.log(keyword);
            $.ajax({
                url: '/order/find?keyword=' + keyword,
                type: 'GET',
                success: function (response) {
                    // console.log(response);
                    $('#orderList').empty();
                    response = JSON.parse(response);
                    response.forEach((order) => {
                        appendOrder(order);
                    });
                    setTableRowListener();
                }
            });
        });
    });

    function appendOrder(order) {
        $.ajax({
            url: '/user/get_by_id',
            method: 'POST',
            async: false,
            data: {
                user_id: order.order_user_id
            },
            success: (response) => {
                let user = JSON.parse(response);
                let tempHtml = `
                <tr data-id="${order.order_id}" data-bs-toggle="modal" data-bs-target="#detailModal">
                    <td>${order.order_id}</td>
                    <td>${order.order_user_id}</td>
                    <td>${user.user_name}</td>
                    <td>${order.order_shipping_address}</td>
                    <td class="text-center">${(parseInt(order.order_amount).toLocaleString()).replace(',', '.')}</td>
                    <td>${order.order_date}</td>
                    <td>${(order.order_status == 0) ? 'Pending' : 'Success'}</td>
                </tr>
                `;
                $('#orderList').append(tempHtml);
            }
        });
    }

    //  add listener to table row
    function setTableRowListener() {
        $('table tr').click(function () {
            let orderId = $(this).data('id');
            $('#detailModal #orderId').html(orderId);
            $('#productList').empty();
            $.ajax({
                url: '/order_item/get_products_by_order?order_id=' + orderId,
                method: 'GET',
                success: function (response) {
                    products = JSON.parse(response);
                    let priceAmount = 0;
                    products.forEach((product) => {
                        console.log(product);
                        let tempHtml = `
                        <div class="row">
                            <div class="col">
                                <p>${product.product_name}</p>
                            </div>
                            <div class="col">
                                <p>${(parseInt(product.product_price).toLocaleString()).replace(',', '.')}</p>
                            </div>
                            <div class="col">
                                <p>${product.order_item_quantity}</p>
                            </div>
                            <div class="col">
                                <p>${(parseInt(product.order_item_price).toLocaleString()).replace(',', '.')}</p>
                            </div>
                        </div>
                        `;
                        $('#productList').append(tempHtml);
                        priceAmount += parseInt(product.order_item_price);
                    });
                    $('#priceAmount').html((priceAmount.toLocaleString()).replace(',', '.'));
                }
            });
        });
    }
</script>