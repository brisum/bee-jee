<?php

namespace App\Utils\Security;

class SecurityService
{
    public function signIn($username, $password)
    {
        if (empty($username)) {
            return 'Please, enter username.';
        }

        if (empty($password)) {
            return 'Please, enter password.';
        }

        if (ADMIN_USERNAME == $username && ADMIN_PASSWORD == $password) {
            $_SESSION['is_admin'] = true;
            return true;
        }

        return 'Login failed. Wrong username or password.';
    }

    public function signOut()
    {
        unset($_SESSION['is_admin']);
    }

    public function isSignedIn()
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    }
}
