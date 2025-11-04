<?php
require_once 'libs/router/router.php';

// INSTANCIAR ROUTER
$router = new Router();

// Rutas apirest
// genero instancia de objeto $router, accedo al metodo AddRouter, y envio los valores por parametros
// valores por parametros: ('url','verbo','controllador','metodo')

// Rutas Productos
$router->addRoute('productos', 'get', 'PisosController', 'getPisos');
$router->addRoute('productos/:id', 'get', 'PisosController', 'getPisoById');
$router->addroute('productos', 'post', 'PisosController', 'addPiso');
$router->addRoute('productos/:id', 'delete', 'PisosController', 'deletePiso');
$router->addRoute('productos/:id', 'put', 'PisosController', 'updatePiso');


// Rutas Categorias


// rutear
// accedo al metodo route de la instancia router, obtengo el "recurso" y al server le pido el "verbo" (get, post, put, delete)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
