<?php
require_once 'app/router/router.php';
require_once 'app/controller/pisos.controller.php';
require_once 'app/model/pisos.model.php';
require_once 'app/model/categorias.model.php';
require_once 'app/controller/categorias.controller.php';
require_once 'app/model/user.model.php'; // Nuevo
require_once 'app/controller/auth.controller.php'; // Nuevo
require_once 'app/helpers/auth.helper.php'; // Nuevo
require_once 'app/middleware/auth.middleware.php'; // Nuevo


// INSTANCIAR ROUTER
$router = new Router();

// Instanciar Request y Response (asumo que se crean aquí o son globales)
// Si no existen, necesitaríamos crearlos o ajustar la forma en que se pasan a los controladores y middleware
// Por ahora, asumo que $req y $res son accesibles o se crean en el contexto del router.
// Si el router no los pasa automáticamente, esto necesitará ajuste.
// Basado en el README del router, los controladores reciben $req y $res.
// El middleware también recibe $request y $response.

// Añadir el middleware de autenticación
$router->addMiddleware(new AuthMiddleware());

// Rutas apirest
// genero instancia de objeto $router, accedo al metodo AddRouter, y envio los valores por parametros
// valores por parametros: ('url','verbo','controllador','metodo')

// Rutas de Autenticación
$router->addRoute('login', 'POST', 'AuthController', 'login'); // Nueva ruta para login

// Rutas Productos
$router->addRoute('productos', 'GET', 'PisosController', 'getAll');
$router->addRoute('productos/:id', 'GET', 'PisosController', 'get');
$router->addroute('productos', 'POST', 'PisosController', 'create');
$router->addRoute('productos/:id', 'DELETE', 'PisosController', 'delete');
$router->addRoute('productos/:id', 'PUT', 'PisosController', 'update');

//Rutas Categorias
$router->addRoute('categorias/', 'GET', 'CategoriasController', 'getAll'); //check
$router->addRoute('categorias/:id', 'GET', 'CategoriasController', 'get'); //check
$router->addRoute('categoria', 'POST', 'CategoriasController', 'create'); //check
$router->addRoute('categoria/:id', 'DELETE', 'CategoriasController', 'delete'); //check
$router->addRoute('categoria/:id', 'PUT', 'CategoriasController', 'update'); //check

// rutear
// accedo al metodo route de la instancia router, obtengo el "recurso" y al server le pido el "verbo" (get, post, put, delete)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
