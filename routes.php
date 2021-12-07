<?php 

$router->define([
    '/' => 'controllers/home.php',
    '/404' => 'controllers/404.php',
    '/add-student' => 'controllers/add-student.php',
    '/update-student' => 'controllers/update-student.php',
    '/delete-student' => 'controllers/delete-student.php',
    '/data' => 'controllers/data.php'
]);