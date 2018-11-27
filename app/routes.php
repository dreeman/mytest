<?php

$this->router->get('/', 'TasksController@index');
$this->router->get('/tasks', 'TasksController@index');

$this->router->get('/tasks/new', 'TasksController@create');
$this->router->post('/tasks/new', 'TasksController@store');

$this->router->get('/tasks/{id}', 'TasksController@edit');
$this->router->post('/tasks/{id}', 'TasksController@update');

$this->router->get('/login', 'UsersController@loginForm');
$this->router->post('/login', 'UsersController@login');
$this->router->get('/logout', 'UsersController@logout');
