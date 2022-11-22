<?php

namespace App\Contracts;

interface AuthUserAPI
{
    public function authenticate($login, $password);
}
