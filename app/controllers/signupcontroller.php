<?php

namespace Controllers;
use Services\SignupService;
use Models\User;

use Exception;

class SignupController extends Controller
{
    private $signupService;

    // initialize services
    function __construct()
    {
        $this->signupService = new SignupService();
    }

    public function create()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $user = new User(

                $data['username'] ?? null,
                $data['password'] ?? null,
                $data['age'] ?? null,
                $data['gender'] ?? null,
                $data['weight'] ?? null,
                $data['height'] ?? null,
                $data['goal'] ?? null
            );

            $userId=$this->signupService->createUser($user);
            $user->setUserId($userId);
            // var_dump($user);
            $userName=$user->getUserName();
            $userGoal=$user->getGoal();
            $userWeight=$user->getWeight();
            $userCaloriesIntake=$user->getCaloriesIntake();
            $userRole=$user->getRole();
            $jwt = $this->generateJwt($user);
            $this->respond(['token' => $jwt]);
          

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
}