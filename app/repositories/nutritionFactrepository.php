<?php
namespace Repositories;

use Models\NutritionFact;
use PDO;


class NutritionFactRepository extends Repository
{
  public function getFoodsByUserGoal($goalId)
  {
    try {
      $stmt = $this->connection->prepare("
              SELECT food_id, food_name, carbs, proteins, fats, fibers, goal_id
              FROM nutrition_facts
              WHERE goal_id = :goalId
          ");
      $stmt->bindParam(':goalId', $goalId);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\NutritionFact');
      return $stmt->fetchAll(); //this should return all, check if it is working

    } catch (\PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getUserFood($userId)
  {
    try {
      $stmt = $this->connection->prepare("
                SELECT id,foodname,carbs, proteins, fats, fibers
                FROM userfood
                WHERE userId = :userId
            ");
      $stmt->bindParam(':userId', $userId);
      $stmt->execute();
      return $stmt->fetchAll();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $workouts[] = self::nutritionFactRow($row);
      }
      return $workouts;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage());
    }
  } 
  private static function nutritionFactRow(array $row)
  {
    return new NutritionFact($row['userId'], $row['foodname'], $row['carbs'], $row['proteins'], $row['fats'], $row['fibers']);
  }

  public function addUserFood(NutritionFact $nutritionFact)
  {
// var_dump($nutritionFact);
    try {
      $stmt = $this->connection->prepare("INSERT INTO userfood (userId,foodname,carbs,proteins,fats,fibers) VALUES (:userId, :foodname, :carbs, :proteins, :fats, :fibers)");
      $params = [
        ':userId' => $nutritionFact->getUserId(),
        ':foodname' => $nutritionFact->getFoodName(),
        ':carbs' => $nutritionFact->getCarbs(),
        ':proteins' => $nutritionFact->getProteins(),
        ':fats' => $nutritionFact->getFats(),
        ':fibers' => $nutritionFact->getFibers()
      ];

      $stmt->execute($params);
      return true;

    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage());
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

    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage());
    }

  }

}