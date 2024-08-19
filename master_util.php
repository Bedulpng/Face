<?php

class Util
{
    // Method of input value sanitization
    public function testInput($data)
    {
        $data = stripslashes($data);
        return $data;
    }
    // Method for displaying Success And Error Message
    public function showMessage($type, $message)
    {
        return '<div class="alert alert-' .
            $type .
            ' alert-dismissible fade show" role="alert">' .
            $message .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    public function showToastMessage($message)
    {
        return $message;
    }
}
