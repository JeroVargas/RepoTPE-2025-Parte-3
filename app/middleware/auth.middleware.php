<?php
require_once 'app/helpers/auth.helper.php';
require_once 'app/router/router.php'; // Asegurarse de que la clase Middleware esté disponible

class AuthMiddleware extends Middleware { // <-- CORRECCIÓN AQUÍ
    // No se necesita constructor, $request y $response se pasan directamente al método run()

    public function run($request, $response) {
        // Rutas que no requieren autenticación (públicas)
        $publicRoutes = [
            ['method' => 'POST', 'path' => 'login'],
            ['method' => 'GET', 'path' => 'productos'],
            ['method' => 'GET', 'path' => 'productos/:id'],
            ['method' => 'GET', 'path' => 'categorias'],
            ['method' => 'GET', 'path' => 'categorias/:id'],
        ];

        // Normalizar la ruta de la solicitud para comparación
        // El router pasa el recurso sin los query params, pero puede incluir parámetros de ruta como :id
        $requestPath = $request->resource; 
        $requestMethod = $request->verb; 

        // Verificar si la ruta actual es pública
        foreach ($publicRoutes as $route) {
            // Convertir la ruta pública a un patrón de regex para manejar :id
            $pattern = preg_replace('/:\w+/', '(\w+)', $route['path']);
            // Asegurarse de que el patrón coincida con el inicio de la ruta para rutas como 'productos' y 'productos/:id'
            if (preg_match("#^" . $pattern . "(/.*)?$#", $requestPath) && $requestMethod === $route['method']) {
                return; // Es una ruta pública, no requiere autenticación
            }
        }

        // Si no es una ruta pública, requiere autenticación
        $authHeader = AuthHelper::getAuthHeader();

        if (empty($authHeader)) {
            $response->json(["message" => "No autorizado (Token no proporcionado)."], 401);
            die();
        }

        $token = str_replace('Bearer ', '', $authHeader);
        $payload = AuthHelper::verifyToken($token);

        if (!$payload) {
            $response->json(["message" => "No autorizado (Token inválido o expirado)."], 401);
            die();
        }

        // Token válido, se puede adjuntar el payload al request si es necesario
        $request->user = $payload; // Adjuntar información del usuario al objeto request
    }
}
