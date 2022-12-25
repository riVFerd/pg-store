<?php

class OrderItemController
{
    public function get_by_order()
    {
        $order_items = (new OrderItem())->getAllById('order_item_order_id', $_GET['order_id']);
        echo json_encode($order_items, JSON_PRETTY_PRINT);
    }

    public function get_products_by_order()
    {
        $order_items = (new OrderItem())->getAllById('order_item_order_id', $_GET['order_id']);
        $products = [];
        foreach ($order_items as $item) {
            $product = (new Products())->getById('product_id', $item['order_item_product_id']);
            $product['order_item_quantity'] = $item['order_item_quantity']; // add quantity to product, this is not in the product table
            $product['order_item_price'] = $item['order_item_price'];    // add price to product, this is not in the product table
            $products[] = $product;
        }
        echo json_encode($products, JSON_PRETTY_PRINT);
    }
}