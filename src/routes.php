<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@signup');
$router->post('/cadastro', 'LoginController@signupAction');

$router->post('/post/new', 'PostController@new');
$router->get('/post/{id}/delete', 'PostController@delete');

$router->get('/perfil/{id}/fotos', 'ProfileController@photos');
$router->get('/perfil/{id}/amigos', 'ProfileController@friends');
$router->get('/perfil/{id}/follow', 'ProfileController@follow');
$router->get('/perfil/{id}', 'ProfileController@index');


$router->get('/perfil', 'ProfileController@index');
$router->get('/amigos', 'ProfileController@friends');
$router->get('/fotos', 'ProfileController@photos');


$router->get('/config', 'ConfigController@index');
$router->post('/config', 'ConfigController@atualizaAction');


$router->get('/pesquisa', 'SearchController@index');


$router->get('/Quiz', 'QuizController@index');

$router->get('/Pong', 'PongController@index');

$router->get('/Comment', 'ChatController@index');
$router->post('/Comment', 'ChatController@index');


$router->get('/ajax/like/{id}', 'AjaxController@like');
$router->post('/ajax/comment', 'AjaxController@comments');
$router->post('/ajax/upload', 'AjaxController@upload');


//AJAX do chat
$router->post('/ajax/old_message', 'AjaxController@old_message');
$router->get('/ajax/get_groups', 'AjaxController@get_groups');
$router->post('/ajax/add_group', 'AjaxController@add_group');
$router->post('/ajax/add_message', 'AjaxController@add_message');
$router->get('/ajax/get_messages', 'AjaxController@get_messages');



$router->get('/sair', 'LoginController@logout');