<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="my-4">Add Product Detail</h1>
            <form action="/products/insert" method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="productName" name="product_name" placeholder="Product Name">
                    <label for="productName">Product Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="productDesc" name="product_desc" placeholder="Product Desc">
                    <label for="productDesc">Product Desc</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="productStock" name="product_stock" placeholder="Product Stock">
                    <label for="productStock">Product Stock</label>
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="productImage" name="product_img">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="productPrice" name="product_price" placeholder="Product Price">
                    <label for="productPrice">Product Price</label>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-primary w-50" id="submitButton">Submit</button>
                    <a class="btn btn-primary w-50" id="updateButton">Update</a>
                </div>
                <div class="row justify-content-center">
                    <a href="/products" class="btn btn-secondary w-25 mt-2">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#updateButton').hide();
</script>