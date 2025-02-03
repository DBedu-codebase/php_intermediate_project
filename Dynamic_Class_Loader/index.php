<?php
// ! Remove this file with composer autoloading
require_once('./vendor/autoload.php');

use App\Controllers\User;

$Users = new User('John Doe');
echo $Users->name;
