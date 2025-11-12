<?php

class AuthHelper
{
    private static $secretKey = 'admin'; // ¡IMPORTANTE: Cambiar y mantener en secreto!

    /**
     * Crea un token JWT.
     */
    public static function createToken($payload)
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = self::base64url_encode(json_encode($header));
        $payload = self::base64url_encode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$header.$payload", self::$secretKey, true);
        $signature = self::base64url_encode($signature);

        return "$header.$payload.$signature";
    }

    /**
     * Verifica un token JWT.
     * Devuelve el payload si es válido, null en caso contrario.
     */
    public static function verifyToken($token)
    {
        if (empty($token)) {
            return null;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        list($header, $payload, $signature) = $parts;

        $newSignature = hash_hmac('SHA256', "$header.$payload", self::$secretKey, true);
        $newSignature = self::base64url_encode($newSignature);

        if (hash_equals($newSignature, $signature)) {
            return json_decode(self::base64url_decode($payload));
        }

        return null;
    }

    /**
     * Obtiene el token del header Authorization.
     */
    public static function getAuthHeader()
    {
        $header = null;
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        // Añadir soporte para cabecera personalizada X-Authorization
        if (isset($_SERVER['HTTP_X_AUTHORIZATION'])) {
            $header = $_SERVER['HTTP_X_AUTHORIZATION'];
        }
        return $header;
    }

    private static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }
}
