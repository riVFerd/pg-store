<?php
require 'input_products.php';
?>

<script>
    $(document).ready(() => {
        $('#submitButton').hide();
        $('#updateButton').show();

        var products = <?= json_encode($products)  ?>;
        $('#productName').val(products.product_name);
        $('#productDesc').val(products.product_desc);
        $('#productStock').val(products.product_stock);
        $('#productPrice').val(products.product_price);

        $('#updateButton').click(() => {
            var formData = new FormData();
            formData.append('product_id', products.product_id);
            formData.append('product_name', $('#productName').val());
            formData.append('product_desc', $('#productDesc').val());
            formData.append('product_stock', $('#productStock').val());
            formData.append('product_price', $('#productPrice').val());
            formData.append('old_product_img', products.product_img);
            formData.append('product_img', $('#productImage')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '/products/update',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (!(JSON.parse(response).message === 'true')) alert(response);
                    else alert('update success');
                    window.location.href = '/products';
                }
            });
        });
    });
</script>
