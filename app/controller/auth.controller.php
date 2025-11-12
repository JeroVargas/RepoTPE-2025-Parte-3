<?php
require_once 'app/model/user.model.php';
require_once 'app/helpers/auth.helper.php';

class AuthController {
    // No se necesita constructor, $req y $res se pasan directamente al método login()

    public function login($req, $res) {
        $userModel = new UserModel(); // Instanciar el modelo dentro del método

        $data = $req->body;

        if (!isset($data->email) || !isset($data->password)) {
            return $res->json(["message" => "Faltan datos obligatorios (email o password)."], 400);
        }

        $user = $userModel->getUserByEmail($data->email);

        if ($user && password_verify($data->password, $user->password)) {
            // Credenciales válidas, generar token
            $tokenPayload = [
                'id' => $user->id,
                'email' => $user->email,
                'level' => $user->level,
                'exp' => time() + (60 * 60) // Token válido por 1 hora
            ];
            $token = AuthHelper::createToken($tokenPayload);
            return $res->json(['token' => $token], 200);
        } else {
            return $res->json(["message" => "Email o password incorrectos."], 401);
        }
    }
}
