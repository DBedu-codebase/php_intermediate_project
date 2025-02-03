<?php

namespace App\Controllers;

class User
{
    public $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
