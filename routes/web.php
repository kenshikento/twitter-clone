<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->get('/users/', 'UserController@index');
$router->post('/users/', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@delete');

$router->get('/posts','PostController@index');
$router->post('/posts','PostController@store');
$router->get('/posts/{id}','PostController@show');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@delete');

$router->get('/comments', 'CommentController@index');
$router->get('/comments/{id}', 'CommentController@show');

$router->get('/posts/{id}/comments', 'PostCommentController@index');
$router->post('/posts/{id}/comments', 'PostCommentController@store');
$router->put('/posts/{id}/comments/{commentID}', 'PostCommentController@update');
$router->delete('/posts/{id}/comments/{commentID}', 'PostCommentController@delete');
