<?php

class UserController
{
    const USER_IDENTIFIER = 'user_id';

    public function user_page()
    {
        session_start();
        if (!View::checkAdmin()) return;
        $users = (new User())->getAll();
        View::render('user/user', ['users' => $users]);
    }

    public function login()
    {
        session_start();
        View::render('user/login');
    }

    public function signup()
    {
        session_start();
        View::render('user/signup');
    }

    public function create_session()
    {
        $user = (new User())->getById('user_name', $_POST['user_name']);
        if (!$user) {
            echo 'Username not found!';
            return false;
        }

        if (!password_verify($_POST['user_pass'], $user['user_pass'])) {
            echo 'Wrong password!';
            return false;
        }

        session_start();
        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'user_name' => $user['user_name'],
            'user_email' => $user['user_email'],
            'user_role' => $user['user_role']
        ];
        echo 'true';
    }

    public function delete_session()
    {
        session_start();
        if (isset($_SESSION)) {
            $_SESSION = [];
            session_destroy();
            echo 'you have been logged out!';
            return true;
        }
        echo 'you are not logged in!';
    }

    public function insert()
    {
        $user = new User();
        if ($user->getById('user_name', $_POST['user_name'])) {
            echo 'false';
            return;
        }
        $user->insert([
            'user_id' => 'DEFAULT',
            'user_name' => $_POST['user_name'],
            'user_email' => $_POST['user_email'],
            'user_password' => password_hash($_POST['user_pass'], PASSWORD_DEFAULT),
            'user_role' => 0
        ]);
        echo 'Sign Up Success';
    }

    public function delete()
    {
        (new User())->delete(self::USER_IDENTIFIER, $_POST['user_id']);
        echo 'User was deleted';
    }

    public function get_by_id() {
        $user = (new User())->getById(self::USER_IDENTIFIER, $_POST['user_id']);
        echo json_encode($user);
    }
}