<?php

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        require "app/views/templates/header.php";
        require "app/views/templates/style.html";
        require "app/views/$view.php";
        require "app/views/templates/footer.php";
    }

    public static function checkAdmin()
    {
        if (isset($_SESSION['user'])) if ($_SESSION['user']['user_role'] === 1) {
            return true;
        }
        header('Location: /');
        return false;
    }
}