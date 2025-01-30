<?php
// ! Remove this file with composer autoloading
require_once('./src/controllers/User.php');
$Users = new User('John Doe');
echo $Users->name;
