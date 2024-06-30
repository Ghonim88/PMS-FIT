<?php

namespace Controllers;

use Exception;
use Services\LoginService;
use \Firebase\JWT\JWT;


class LoginController extends Controller
{

  private $loginService;

  // initialize services
  function __construct()
  {
    $this->loginService = new LoginService();
  }

  public function login()
  {
    try {
      $json = file_get_contents('php://input');
       $data = json_decode($json, true);
        $username = $data['username'];
        $password = $data['password'];
      $user = $this->loginService->authenticate($username, $password);
      if ($user) {
        $jwt = $this->generateJwt($user);
        $userId = $user->getUserId();
        $userName=$user->getUserName();
        $userGoal=$user->getGoal();
        $userWeight=$user->getWeight();
        $userCaloriesIntake=$user->getCaloriesIntake();
        $userRole=$user->getRole();
        $this->respond(['token' => $jwt]);
      } else {
        $this->respondWithError(401, 'Invalid credentials');
      }
      
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }
  }

}

