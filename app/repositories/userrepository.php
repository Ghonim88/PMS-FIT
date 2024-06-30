<?php
namespace Repositories;

use Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository
{

  public function getUserByUserId($userId)
  {
    try {
      $stmt = $this->connection->prepare("
      SELECT id, userName,password, age, gender, weight, height, bmrInfo, goal, caloriesIntake, role FROM users
      WHERE  id = :id
  ");
      $stmt->bindParam(':id', $userId);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row === false) {
        return false;
      }
      $user = $this->fromRow($row);
      
      return $user;


    } catch (PDOException $e) {
      throw new PDOException('Error authenticating user: ' . $e->getMessage());

    }
  }

  public function updateUserInfo(User $user)
  {
    try {
      $bmrInfo = $user->calculateBMR();
      $caloriesIntake = $user->calculateCaloriesIntake();
      $user->setBmrInfo($bmrInfo);
      $user->setCaloriesIntake($caloriesIntake);
      $stmt = $this->connection->prepare("
    UPDATE users
    SET 
        password = :password, 
        age = :age, 
        gender = :gender, 
        weight = :weight, 
        height = :height, 
        goal = :goal, 
        username = :newUsername, 
        bmrInfo = :bmrInfo, 
        caloriesIntake = :caloriesIntake
    WHERE id = :userId
");

      $params = [
        ':password' => $user->getPassword(),
        ':age' => $user->getAge(),
        ':gender' => $user->getGender(),
        ':weight' => $user->getWeight(),
        ':height' => $user->getHeight(),
        ':goal' => $user->getGoal(),
        ':newUsername' => $user->getUserName(),
        ':caloriesIntake' => $user->getCaloriesIntake(),
        ':bmrInfo' => $user->getBmrInfo(),
        ':userId' => $user->getUserId(),
      ];
      $stmt->execute($params);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        return $user;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      throw new PDOException('Error updating user info: ' . $e->getMessage());
    }
  }


  public function deleteUser(User $user)
  {
    try{
      
      $stmt = $this->connection->prepare("DELETE FROM users WHERE id = :id");
      $userId = $user->getUserId();
      $stmt->bindParam(':id', $userId, PDO::PARAM_STR);
      $stmt->execute();
      return true;

    }catch(PDOException $e){
      throw new PDOException('Error deleting user: ' . $e->getMessage());
    }

  }

  public function DeleteUserFood($foodId)
  {
    try {
      $stmt = $this->connection->prepare("
    DELETE FROM userfood
    WHERE id = :id
");
      $stmt->bindParam(':id', $foodId, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    } 

  }


  public function deleteUserWorkout($userId)
  {
    try {
      $stmt = $this->connection->prepare("
    DELETE FROM workout
    WHERE userId = :userId
");
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
      $stmt->execute();
      return true;

    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }

}