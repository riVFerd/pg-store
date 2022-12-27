<div class="container mb-5 mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="container d-flex flex-row justify-content-between align-items-center mt-4">
                <h1>Products</h1>
                <a href="/products/input" class="btn btn-primary h-50">Add Product</a>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control w-25" id="inputSearch" placeholder="Search products">
            </div>
            <table class="table table-responsive table-striped text-center">
                <thead>
                <tr>
                    <th class="col-2">Product Name</th>
                    <th class="col-2">Description</th>
                    <th class="col-2">Stock</th>
                    <th class="col-2">Image</th>
                    <th class="col-2">Price</th>
                    <th class="col-2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="col-2"><?= $product['product_name']; ?></td>
                        <td class="col-2"><?= $product['product_desc']; ?></td>
                        <td class="col-2"><?= $product['product_stock']; ?></td>
                        <td class="col-2"><img src="/app/assets/product_images/<?= $product['product_img']; ?>" alt="" width="100px"></td>
                        <td class="col-2"><?= number_format($product['product_price'], 0, ',', '.'); ?></td>
                        <td class="col-2">
                            <a href="/products/edit?product_id=<?= $product['product_id'] ?>" class="btn btn-warning">Edit</a>
                            <a onclick="deleteProduct(<?= $product['product_id'] ?>)" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <a href="/order" class="btn btn-secondary w-25 mt-2">Back</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteProduct(id) {
        if (confirm('Are you sure want to delete this product?')) {
            $.ajax({
                url: '/products/delete',
                type: 'POST',
                data: {
                    product_id: id
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    }

    $(document).ready(function () {
        $('#inputSearch').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();
            $.ajax({
                url: '/products/find?keyword=' + keyword,
                type: 'GET',
                data: {},
                success: function (response) {
                    let products = JSON.parse(response);
                    console.log(products);
                    $('tbody').empty();
                    if (products.length == 0) $('tbody').append('<tr><td colspan="6">No data found</td></tr>');
                    for (let i = 0; i < products.length; i++) {
                        $('tbody').append(`
                            <tr>
                                <td>${products[i].product_name}</td>
                                <td>${products[i].product_desc}</td>
                                <td>${products[i].product_stock}</td>
                                <td><img src="/app/assets/product_images/${products[i].product_img}" alt="" width="100px"></td>
                                <td>${(parseInt(products[i].product_price).toLocaleString()).replace(',', '.')}</td>
                                <td>
                                    <a href="/products/edit?product_id=${products[i].product_id}" class="btn btn-warning">Edit</a>
                                    <a onclick="deleteProduct(${products[i].product_id})" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        `);
                    }
                }
            });
        });
    });
</script>