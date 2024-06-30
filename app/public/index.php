<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the products endpoint
$router->get('/products', 'ProductController@getAll');

$router->delete('/categories/(\d+)', 'CategoryController@delete');

$router->post('/login', 'LoginController@login');
$router->post('/signup/create', 'signupController@create');
$router->get('/user/fetchusers', 'userController@fetchUsers');
$router->post('/user/update', 'userController@updateUser');
$router->delete('/user/delete', 'userController@deleteUser');

$router->get('/getUserWorkout', 'workoutController@getUserWorkout');
$router->post('/addWorkout', 'workoutController@addWorkout');
$router->delete('/deleteWorkout', 'workoutController@deleteWorkout');

$router->get('/getUserFood', 'userfoodController@getUserFood');
$router->post('/addFood', 'userfoodController@addFood');
$router->delete('/deleteUserFood', 'userfoodController@deleteFood');

$router->post('/addContent', 'BlogController@addContent');
$router->get('/getAllContent', 'BlogController@getAllContent');
$router->post('/updateContent', 'BlogController@updateContent');
$router->delete('/deleteContent', 'BlogController@deleteContent');


// Run it!
$router->run();