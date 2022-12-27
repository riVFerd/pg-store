<div class="container-fluid d-flex justify-content-center mt-5 pt-5 vh-100">
    <div class="row">
        <div class="col text-center mt-5 pt-5">
            <h2>Enter a payment code</h2>
            <input type="text" maxlength="5" class="form-control mt-3 text-center" name="payment_code" placeholder="Enter 5 digit payment code">
            <button class="btn btn-primary mt-3" id="verifyButton">Verify Payment</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#verifyButton').click(function () {
            let payment_code = $('input[name=payment_code]').val();
            $.ajax({
                url: '/order/verify_payment',
                method: 'POST',
                data: {
                    payment_code: payment_code,
                    order_id: <?= $_GET['order_id'] ?>
                },
                success: function (response) {
                    alert(JSON.parse(response).message);
                    window.location.href = '/order';
                }
            });
        });
    });
</script>