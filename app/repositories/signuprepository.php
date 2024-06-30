<?php
namespace Repositories;

use PDO;
use Models\User;

class SignupRepository extends Repository
{

  public function createUser(User $user)
  {
    try {
      $stmt = $this->connection->prepare("
  INSERT INTO users (userName, password, age, gender, weight, height, bmrInfo, goal, caloriesIntake)
  VALUES (:userName, :password, :age, :gender, :weight, :height, :bmrInfo, :goal, :caloriesIntake)
");
      $params = [
        ':userName' => $user->getUserName(),
        ':password' => $user->getPassword(),
        ':age' => (int) $user->getAge(),
        ':gender' => $user->getGender(),
        ':weight' => $user->getWeight(),
        ':height' => $user->getHeight(),
        ':bmrInfo' => $user->getBmrInfo(),
        ':goal' => $user->getGoal(),
        ':caloriesIntake' => $user->getCaloriesIntake(),
      ];
      $bmrInfo = $user->calculateBMR();
      $caloriesIntake = $user->calculateCaloriesIntake();

      $user->setBmrInfo($bmrInfo);
      $user->setCaloriesIntake($caloriesIntake);
      
      $stmt->execute($params);

      return $this->connection->lastInsertId();
    } catch (\PDOException $e) {
      error_log('Error creating user: ' . $e->getMessage());
    }

  }
  
}