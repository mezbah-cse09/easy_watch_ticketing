<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken
{
    public static function CreateToken($userEmail, $userId){
        $Key = env('JWT_KEY');
        $payload = array(
            'iss' => 'easy watch ticketing',
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
            'userEmail' => $userEmail,
            'userId' => $userId
        );

        return JWT::encode($payload, $Key, 'HS256');

    }
    public static function CreateTokenForPassword($userEmail){
        $Key = env('JWT_KEY');
        $payload = array(
            'iss' => 'easy watch ticketing',
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
            'userEmail' => $userEmail
        );

        return JWT::encode($payload, $Key, 'HS256');

    }

    public static function VerifyToken($token){

        try{
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
        }catch(Exception $e){
            return 'unauthorized';
        }
    }
}
