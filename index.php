<?php

require_once 'app/Core/Database.php';
require_once 'app/Core/View.php';
require_once 'app/Core/Router.php';
require_once 'app/models/BaseModel.php';
require_once 'app/models/Products.php';
require_once 'app/models/User.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/OrderItem.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/ProductsController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/OrderController.php';
require_once 'app/controllers/OrderItemController.php';
require_once 'app/controllers/CartController.php';

$path = '/';

if (isset($_SERVER['PATH_INFO'])) $path = $_SERVER['PATH_INFO'];

// Root path
Router::add_get('/', HomeController::class, 'home_page');

// Products related paths
Router::add_get('/products', ProductsController::class, 'products_page');
Router::add_get('/products/input', ProductsController::class, 'input_products');
Router::add_get('/products/edit', ProductsController::class, 'edit_products');
Router::add_get('/products/find', ProductsController::class, 'find');
Router::add_post('/products/insert', ProductsController::class, 'insert');
Router::add_post('/products/delete', ProductsController::class, 'delete');
Router::add_post('/products/update', ProductsController::class, 'update');

// User related paths
Router::add_get('/user', UserController::class, 'user_page');
Router::add_get('/user/login', UserController::class, 'login');
Router::add_get('/user/signup', UserController::class, 'signup');
Router::add_post('/user/login/create_session', UserController::class, 'create_session');
Router::add_post('/user/login/delete_session', UserController::class, 'delete_session');
Router::add_post('/user/insert', UserController::class, 'insert');
Router::add_post('/user/delete', UserController::class, 'delete');
Router::add_post('/user/get_by_id', UserController::class, 'get_by_id');

// Order related paths
Router::add_get('/order', OrderController::class, 'order_page');
Router::add_get('/payment', OrderController::class, 'payment_page');
Router::add_get('/order_list', OrderController::class, 'order_list');
Router::add_get('/order/find', OrderController::class, 'find');
Router::add_post('/order/send_mail', OrderController::class, 'send_mail');
Router::add_post('/order/checkout', OrderController::class, 'checkout');
Router::add_post('/order/verify_payment', OrderController::class, 'verify_payment');
Router::add_get('/order/get_user_orders', OrderController::class, 'get_user_orders');

// OrderItem related paths
Router::add_get('/order_item/get_by_order', OrderItemController::class, 'get_by_order');
Router::add_get('/order_item/get_products_by_order', OrderItemController::class, 'get_products_by_order');

// Cart related paths
Router::add_get('/cart/get_user_cart', CartController::class, 'get_user_cart');
Router::add_post('/cart/add', CartController::class, 'add');
Router::add_post('/cart/remove', CartController::class, 'remove');
Router::add_post('/cart/plus', CartController::class, 'plus');
Router::add_post('/cart/minus', CartController::class, 'minus');

Router::run();

//Just in case my router doesn't work, use this simple router implementation
//switch ($path) {
//    case '/':
//        require 'app/views/home/home.php';
//        break;
//    case '/products':
//        $products = new Products();
//        $products = $products->getAll();
//        View::render('products/products', ['products' => $products]);
//        break;
//    case '/products/input':
//        View::render('products/input_products');
//        break;
//    case '/products/save':
//        $products = new Products();
//        $products->insert([
//            'id' => 'DEFAULT',
//            'name' => $_POST['product_name'],
//            'description' => $_POST['product_desc'],
//            'stock' => $_POST['product_stock'],
//            'img' => 'masih belum di set',
//            'price' => $_POST['product_price']
//        ]);
//        header('Location: /products');
//        break;
//    default:
//        http_response_code(404);
//        exit('Not Found');
//}