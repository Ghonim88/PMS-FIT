<?php
namespace Services;

use Repositories\UserRepository;
use Models\User;

class UserService{
  private $userRepository;
  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function getUserByUserId($userId)
  {
      return $this->userRepository->getUserByUserId($userId);
  }



  public function  updateUser(array $userData)
  {
      try {
          $user = $this->convertArrayToUser($userData);
      
        $user=$this->userRepository->updateUserInfo($user);
        return $user;
        
        
      } catch (\Exception $e) {
          throw new \Exception('Error updating user information: ' . $e->getMessage());      
        }
 }

  public function deleteUser(array $userData)
  {
      try {
          $user = $this->convertArrayToUser($userData);
          $this->userRepository->deleteUser($user);
        
      } catch (\Exception $e) {
          throw new \Exception('Error deleting user information: ' . $e->getMessage());
      }
  }
  
  private function convertArrayToUser(array $userData): User
  {
      // Ensure that all required keys are present in the array
      $requiredKeys = ['username', 'password', 'age', 'gender', 'weight', 'height', 'goal', 'id'];
  
      foreach ($requiredKeys as $key) {
          if (!array_key_exists($key, $userData)) {
              throw new \Exception("Missing key in user data: $key");
          }
      }
      // Create a User instance and set additional properties
      $user = new User(
          $userData['username'], // Correct key is 'username'
          $userData['password'],
          $userData['age'],
          $userData['gender'],
          $userData['weight'],
          $userData['height'],
          $userData['goal'],
          
      );
     $_SESSION["caloriesIntake"]=htmlspecialchars($user->getCaloriesIntake());      
      //can you set the id??
      $user->setUserId($userData['id']);

  
      return $user;
  }


  

}