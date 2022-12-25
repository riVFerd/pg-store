<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';

class OrderController
{
    public function order_page()
    {
        session_start();
        $products = (new Products())->getAll();
        View::render('order/order_page', ['products' => $products]);
    }

    public function payment_page()
    {
        session_start();
        View::render('order/payment_page');
    }

    public function order_list()
    {
        session_start();
        if (!View::checkAdmin()) return;
        $orders = (new Order())->getAll();
        View::render('order/order_list', ['orders' => $orders]);
    }

    public function send_mail()
    {
        session_start();
        $mail = new PHPMailer(true);

        $_SESSION['user'][$_POST['order_id']] = mt_rand(10000, 99999);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pgbee.honeystore@gmail.com';
        $mail->Password = 'bolgnqlgnpmsznsr';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('pgbee.honeystore@gmail.com');
        $mail->addAddress($_SESSION['user']['user_email']);
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation';
        $mail->Body = 'Thank you for your order. Your payment code is: <b>' . $_SESSION['user'][$_POST['order_id']] . '</b>';
        $mail->Body .= '<br> Please enter this code in the payment page to confirm your order.';

        if ($mail->send()) {
            echo json_encode(['message' => 'Check your email for payment instructions.']);
        } else {
            echo json_encode(['message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    }

    public function verify_payment()
    {
        session_start();
        if ($_SESSION['user'][$_POST['order_id']] == $_POST['payment_code']) {
            (new Order())->update(['order_status' => 1], 'order_id', $_POST['order_id']);
            echo json_encode(['message' => 'Payment successful.']);
        } else {
            echo json_encode(['message' => 'Payment failed.']);
        }
    }

    public function checkout()
    {
        try {
            session_start();
            $cart = (new Cart())->getById('cart_user_id', $_SESSION['user']['user_id']);

            if (empty($cart)) {
                echo json_encode(['message' => 'Your cart is empty.']);
                return;
            }

            $order_amount = 0;
            foreach ($cart as $item) {
                $order_amount += $item['cart_price'];
            }

//            insert into orders table
            date_default_timezone_set('Asia/Jakarta');
            (new Order())->insert([
                'order_id' => 'DEFAULT',
                'order_user_id' => $_SESSION['user']['user_id'],
                'order_amount' => $order_amount,
                'order_shipping_address' => $_POST['shipping_address'],
                'order_date' => date('Y-m-d H:i:s'),
                'order_status' => '0'
            ]);

            $order_id = (new OrderItem())->getLastInsertedId();

//            insert into order_details table
            foreach ($cart as $item) {
                (new OrderItem())->insert([
                    'order_item_id' => 'DEFAULT',
                    'order_item_order_id' => $order_id,
                    'order_item_product_id' => $item['cart_product_id'],
                    'order_item_quantity' => $item['cart_quantity'],
                    'order_item_price' => $item['cart_price']
                ]);
            }

//            delete cart
            (new Cart())->delete('cart_user_id', $_SESSION['user']['user_id']);
            echo json_encode(['message' => 'Order successfully placed.']);
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function get_user_orders()
    {
        session_start();
        $orders = (new Order())->getAllById('order_user_id', $_SESSION['user']['user_id']);
        echo json_encode($orders, JSON_PRETTY_PRINT);
    }

    public function find() {
        $orders = (new Order())->find(
            [
                'order_id', 'order_user_id', 'order_amount', 'order_shipping_address', 'order_date', 'order_status'
            ],
            $_GET['keyword']
        );
        echo json_encode($orders, JSON_PRETTY_PRINT);
    }
}