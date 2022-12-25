<?php

class CartController
{
    const CART_IDENTIFIER = 'cart_id';

    public function getAll()
    {
        $carts = (new Cart())->getAll();
        echo json_encode($carts, JSON_PRETTY_PRINT);
    }

    public function getById()
    {
        $cart = (new Cart())->getById(self::CART_IDENTIFIER, $_GET['id']);
        echo json_encode($cart, JSON_PRETTY_PRINT);
    }

    public function get_user_cart()
    {
        session_start();
        $cart = (new Cart())->getById('cart_user_id', $_SESSION['user']['user_id']);
        echo json_encode($cart, JSON_PRETTY_PRINT);
    }

    public function add()
    {
        session_start();
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user']['user_id'];
        $product = (new Products())->getById(ProductsController::PRODUCT_IDENTIFIER, $product_id);
        $product_price = $product['product_price'];
        $product_stock = $product['product_stock'];
        $product_quantity = 1;
        $product_total_price = $product_price * $product_quantity;
        $product_total_stock = $product_stock - $product_quantity;

//        check if the product is already in the user cart
        $carts = (new Cart())->getById('cart_user_id', $user_id);
        foreach ($carts as $cart) {
            if ($cart['cart_product_id'] == $product_id) {
                $_POST['cart_id'] = $cart['cart_id'];
                $this->plus();
                return;
            }
        }

        if ($product_stock < $product_quantity) {
            echo 'false';
        } else {
            $cart = new Cart();
            $cart->insert([
                'cart_id' => 'DEFAULT',
                'cart_user_id' => $user_id,
                'cart_product_id' => $product_id,
                'cart_product_quantity' => $product_quantity,
                'cart_product_price' => $product_total_price
            ]);

            $products = new Products();
            $products->update([
                'product_stock' => $product_total_stock
            ], ProductsController::PRODUCT_IDENTIFIER,
                $product_id);
            echo 'true';
        }
    }

    public function remove()
    {
        try {
            $cart_id = $_POST['cart_id'];
            $cart = (new Cart())->getById(self::CART_IDENTIFIER, $cart_id);

//        restore stock to products table
            $product_id = $cart[0]['cart_product_id'];
            $product = (new Products())->getById(ProductsController::PRODUCT_IDENTIFIER, $product_id);
            $product_total_stock = $product['product_stock'] + $cart[0]['cart_quantity'];
            (new Products())->update([
                'product_stock' => $product_total_stock
            ], ProductsController::PRODUCT_IDENTIFIER,
                $product_id
            );

//        remove cart
            (new Cart())->delete(self::CART_IDENTIFIER, $cart_id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        echo 'true';
    }

    public function minus()
    {
        try {
            //        calculate everything here :")
            $cart = (new Cart())->getById(self::CART_IDENTIFIER, $_POST['cart_id']);
            $product = (new Products())->getById(ProductsController::PRODUCT_IDENTIFIER, $cart[0]['cart_product_id']);
            $product_price = $product['product_price'];
            $product_stock = $product['product_stock'];
            $product_quantity = $cart[0]['cart_quantity'] - 1;
            $product_total_price = $product_price * $product_quantity;
            $product_total_stock = $product_stock + 1;

            if ($product_quantity < 1) {
                echo 'false';
                return;
            }

            (new Products())->update([
                'product_stock' => $product_total_stock
            ], ProductsController::PRODUCT_IDENTIFIER, $cart[0]['cart_product_id']);

            (new Cart())->update([
                'cart_quantity' => $product_quantity,
                'cart_price' => $product_total_price
            ], self::CART_IDENTIFIER, $_POST['cart_id']);
            echo 'true';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function plus()
    {
//        calculate everything here :")
        $cart = (new Cart())->getById(self::CART_IDENTIFIER, $_POST['cart_id']);
        $product = (new Products())->getById(ProductsController::PRODUCT_IDENTIFIER, $cart[0]['cart_product_id']);
        $product_price = $product['product_price'];
        $product_stock = $product['product_stock'];
        $product_quantity = $cart[0]['cart_quantity'] + 1;
        $product_total_price = $product_price * $product_quantity;
        $product_total_stock = $product_stock - 1;

        if ($product_total_stock < 0) {
            echo 'stock is not enough';
            return;
        }

        (new Products())->update([
            'product_stock' => $product_total_stock
        ], ProductsController::PRODUCT_IDENTIFIER, $cart[0]['cart_product_id']);

        (new Cart())->update([
            'cart_quantity' => $product_quantity,
            'cart_price' => $product_total_price
        ], self::CART_IDENTIFIER, $_POST['cart_id']);
        echo 'true';
    }
}