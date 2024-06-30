<?php

namespace Controllers;

use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Controller
{
    function respond($data)
    { 
         http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($data);

    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    private function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        // echo json_encode($data);
    }

    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $object = new $className();
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                continue;
            }
            $object->{$key} = $value;
        }
        return $object;
    }


    protected function generateJwt($user)
    {
        $key = "fitness_key"; 
        $payload = array(
            "iss" => "http://pms.com", 
            "aud" => "myApp_user",
            "iat" => time(),
            "exp" => time() + (60 * 60), 
            "data" => array(
                "id" => $user->getUserId(),
                "username" => $user->getUserName(),
                "age" => $user->getAge(),
                "gender" => $user->getGender(),
                "weight" => $user->getWeight(),
                "height" => $user->getHeight(),
                "bmrInfo" => $user->getBMRInfo(),
                "goal" => $user->getGoal(),
                "caloriesIntake" => $user->getCaloriesIntake(),
                "role" => $user->getRole()
            )
        );

        return JWT::encode($payload, $key, 'HS256');
    }

    protected function getUserDataFromJwt()
    {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? null;

        if (!$authHeader) {
            throw new Exception('Authorization header not found');
        }

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new Exception('Invalid authorization header format');
        }

        $jwt = $matches[1];
        $key = "fitness_key"; // Replace with your secret key

        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new Exception('JWT expired: ' . $e->getMessage());
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            throw new Exception('JWT signature invalid: ' . $e->getMessage());
        } catch (\Firebase\JWT\BeforeValidException $e) {
            throw new Exception('JWT not yet valid: ' . $e->getMessage());
        } catch (\UnexpectedValueException $e) {
            throw new Exception('Unexpected JWT error: ' . $e->getMessage());
        }

        if (!is_object($decoded) || !isset($decoded->data)) {
            throw new Exception('Decoded JWT does not contain user data');
        }

        return $decoded->data;
    }

}

