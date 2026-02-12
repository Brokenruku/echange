<?php
require 'vendor/autoload.php';

Flight::route('/', function(){
    echo 'Hello Flight MVC!';
});

Flight::start();
