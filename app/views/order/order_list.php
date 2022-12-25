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

        </tbody>
    </table>
    <div class="row justify-content-center">
        <a href="/order" class="btn btn-secondary w-25 mt-2 mb-5">Back</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Display all order when page loaded
        let orders = <?= json_encode($orders); ?>;
        orders.forEach((order) => {
            appendOrder(order);
        });

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
                <tr>
                    <td>${order.order_id}</td>
                    <td>${order.order_user_id}</td>
                    <td>${user.user_name}</td>
                    <td>${order.order_shipping_address}</td>
                    <td>${order.order_amount}</td>
                    <td>${order.order_date}</td>
                    <td>${(order.order_status == 0) ? 'Pending' : 'Success'}</td>
                </tr>
                `;
                $('#orderList').append(tempHtml);
            }
        });
    }
</script>