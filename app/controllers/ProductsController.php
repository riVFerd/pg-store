<?php

class ProductsController
{
//    represent the identifier of table 'products'
    const PRODUCT_IDENTIFIER = 'product_id';

    public function products_page()
    {
        session_start();
        if (!View::checkAdmin()) return;
        $products = (new Products())->getAll();
        View::render('products/products', ['products' => $products]);
    }

    public function input_products()
    {
        session_start();
        if (!View::checkAdmin()) return;
        View::render('products/input_products');
    }

    public function edit_products()
    {
        session_start();
        if (!View::checkAdmin()) return;
        $products = (new Products())->getById(self::PRODUCT_IDENTIFIER, $_GET['product_id']);
        View::render('products/edit_products', ['products' => $products]);
    }

    public function insert()
    {
        $products = new Products();
        $product_img = $products->upload();
        $products->insert([
            'product_id' => 'DEFAULT',
            'product_name' => $_POST['product_name'],
            'product_desc' => $_POST['product_desc'],
            'product_stock' => $_POST['product_stock'],
            'product_img' => $product_img,
            'product_price' => $_POST['product_price']
        ]);
        header('Location: /products');
    }

    public function delete()
    {
        (new Products())->delete(self::PRODUCT_IDENTIFIER, $_POST['product_id']);
    }

    public function update()
    {
        $product_img = '';
        if (!isset($_FILES['product_img'])) {
            $product_img = $_POST['old_product_img'];
        } else {
            $product_img = (new Products())->upload();
        }
        (new Products())->update([
            'product_name' => $_POST['product_name'],
            'product_desc' => $_POST['product_desc'],
            'product_stock' => $_POST['product_stock'],
            'product_img' => $product_img,
            'product_price' => $_POST['product_price']
        ], self::PRODUCT_IDENTIFIER,
            $_POST['product_id']
        );
        echo json_encode(['message' => 'true']);
    }

    public function find()
    {
        $result = (new Products())->find([
            'product_id', 'product_name', 'product_price'
        ], $_GET['keyword']);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}