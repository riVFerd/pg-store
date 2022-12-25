<?php

class Products extends BaseModel
{
    public function __construct()
    {
        parent::__construct('products');
    }

    public function upload() {
        $VALID_TYPES = ['jpeg', 'jpg', 'png'];

        $file_name = $_FILES['product_img']['name'];
        $file_size = $_FILES['product_img']['size'];
        $file_tmp = $_FILES['product_img']['tmp_name'];
        $file_error = $_FILES['product_img']['error'];
        $target_dir = "app/assets/product_images/";

        if ($file_error === 4) {
            echo "No file was uploaded";
            return;
        }

        if ($file_size > 1000000) {
            echo "File size is too big";
            return;
        }

        $file_type = explode('.', $file_name);
        $file_type = strtolower(end($file_type));

        if (!in_array($file_type, $VALID_TYPES)) {
            echo "File type is not valid image type";
            return;
        }

        $file_name = uniqid() . '.' . $file_type;
        $target_file = $target_dir . $file_name;
        move_uploaded_file($file_tmp, $target_file);
        return $file_name;
    }
}