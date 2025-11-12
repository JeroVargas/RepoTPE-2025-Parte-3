<?php
require_once 'app/router/router.php';
require_once 'app/controller/pisos.controller.php';
require_once 'app/model/pisos.model.php';


// INSTANCIAR ROUTER
$router = new Router();

// Rutas apirest
// genero instancia de objeto $router, accedo al metodo AddRouter, y envio los valores por parametros
// valores por parametros: ('url','verbo','controllador','metodo')

// Rutas Productos
$router->addRoute('productos', 'GET', 'PisosController', 'getAll');
$router->addRoute('productos/:id', 'GET', 'PisosController', 'get');
$router->addroute('productos', 'POST', 'PisosController', 'create');
$router->addRoute('productos/:id', 'DELETE', 'PisosController', 'delete');
$router->addRoute('productos/:id', 'PUT', 'PisosController', 'update');


// Rutas Categorias


// rutear
// accedo al metodo route de la instancia router, obtengo el "recurso" y al server le pido el "verbo" (get, post, put, delete)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
