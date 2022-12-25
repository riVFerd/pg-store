CREATE DATABASE  db_pghoney_test;

USE db_pghoney_test;

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY ,
    product_name VARCHAR(255) NOT NULL ,
    product_desc VARCHAR(255) NOT NULL ,
    product_stock INT NOT NULL ,
    product_img VARCHAR(255) NOT NULL ,
    product_price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY ,
    user_name VARCHAR(255) NOT NULL ,
    user_email VARCHAR(255) NOT NULL ,
    user_pass VARCHAR(255) NOT NULL ,
    user_role INT NOT NULL DEFAULT 0
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY ,
    order_user_id INT NOT NULL ,
    order_amount INT NOT NULL ,
    order_shipping_address VARCHAR(255) NOT NULL ,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    order_status INT NOT NULL ,
    FOREIGN KEY (order_user_id) REFERENCES users(user_id)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY ,
    order_item_order_id INT NOT NULL ,
    order_item_product_id INT NOT NULL ,
    order_item_quantity INT NOT NULL ,
    order_item_price DECIMAL(10, 2) NOT NULL ,
    FOREIGN KEY (order_item_order_id) REFERENCES orders(order_id) ,
    FOREIGN KEY (order_item_product_id) REFERENCES products(product_id)
);

CREATE TABLE carts (
    cart_id INT AUTO_INCREMENT PRIMARY KEY ,
    cart_user_id INT NOT NULL ,
    cart_product_id INT NOT NULL ,
    cart_quantity INT NOT NULL ,
    cart_price DECIMAL(10, 2) NOT NULL ,
    FOREIGN KEY (cart_user_id) REFERENCES users(user_id) ,
    FOREIGN KEY (cart_product_id) REFERENCES products(product_id)
);