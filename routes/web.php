<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
// unsecure routes

$router->get('/login', 'UserController@login');
$router->post('/validation', 'UserController@validation'); 
$router->get('/users', 'UserController@show');
$router->post('/users', 'UserController@addUser');  //ADDS USER
$router->get('/users/{id}', 'UserController@index');   //FIND THE INPUT ID
$router->put('/users/{id}', 'UserController@updateUser');   //UPDATE
$router->patch('/users/{id}', 'UserController@updateUser');   //update user
$router->delete('/users/{id}', 'UserController@removeUser');  //DELETES USER





