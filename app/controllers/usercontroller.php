<?php

namespace Controllers;

use Services\UserService;
use Models\User;

use Exception;

class UserController extends Controller
{
  private $userService;

  // initialize services
  function __construct()
  {
    $this->userService = new UserService();
  }
  public function fetchUsers()
  {
    try {
      $userId = $_GET['userId'];
      $user = $this->userService->getUserByUserId($userId);
      $userArray = (array) $user;
      $this->respond(json_encode($user->toPublicArray()));
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }

  }

  public function updateUser()
  {
    try {
      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
     $updatedUser= $this->userService->updateUser($data);
     $caloriesIntake = $updatedUser->getCaloriesIntake();
      $this->respond([
        'caloriesIntake' => $caloriesIntake 
      ]);

    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }

  }

  public function deleteUser()
  {
    try {
      $json = file_get_contents('php://input');
      $data = json_decode($json, true);
      $this->userService->deleteUser($data);
      
      $this->respond(['message' => 'User information deleted successfully']);
    } catch (Exception $e) {
      $this->respondWithError(500, $e->getMessage());
    }
  }
}
