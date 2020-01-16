<?php

namespace App\Utils;

class EmailValidator
{
    public function isValid($email)
    {
        return preg_match('/^[0-9a-zA-Z\._-]+@([0-9a-zA-Z_-]+\.)+([a-zA-Z_-]+)$/', $email);
    }
}