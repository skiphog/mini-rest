<?php

/**
 * @noinspection UnusedFunctionResultInspection
 */

use System\Routing\Router;

/**
 * @var Router $route
 */

// Города
$route->group('/cities', static function (Router $router) {
    // GET Получить все или один город по id
    $router->get('/', 'City\CityController@index');
    $router->get('/{id:\d+}', 'City\CityController@show');

    // POST Создать, Обновить, Удалить город
    $router->post('/', 'City\CityController@create');
    $router->post('/{id:\d+}/update', 'City\CityController@update');
    $router->post('/{id:\d+}/delete', 'City\CityController@delete');

    // GET Получить все или один город с достопримечательностями
    $router->get('/sights', 'City\CitySightController@index');
    $router->get('/{id:\d+}/sights', 'City\CitySightController@show');
});

// Достопримечательности
$route->group('/sights', static function (Router $router) {
    // GET Получить все достопримечательности какие есть
    $router->get('/', 'Sight\SightController@index');
    $router->get('/{id:\d+}', 'Sight\SightController@show');

    // POST Создать, Обновить, Удалить достопримечательность
    $router->post('/', 'Sight\SightController@create');
    $router->post('/{id:\d+}/update', 'Sight\SightController@update');
    $router->post('/{id:\d+}/delete', 'Sight\SightController@delete');

});

// Путешественники
$route->group('/users', static function (Router $router) {
    //GET Получить всех или одного путешественника
    $router->get('/', 'User\UserController@index');
    $router->get('/{id:\d+}', 'User\UserController@show');

    // POST Создать, Обновить, Удалить достопримечательность
    $router->post('/', 'User\UserController@create');
    $router->post('/{id:\d+}/update', 'User\UserController@update');
    $router->post('/{id:\d+}/delete', 'User\UserController@delete');

    // 
});