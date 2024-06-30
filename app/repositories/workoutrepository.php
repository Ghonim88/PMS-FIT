<?php

namespace Repositories;

use Exception;
use Models\Workout;

use PDO;

class WorkoutRepository extends Repository
{

  public function getAllWorkouts($userId)
  {
    try {
      $stmt = $this->connection->prepare("
        SELECT userId, workoutName, duration
        FROM workout
        WHERE userId = :userId
      ");
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
  
      $stmt->execute();
      $workouts=[];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $workouts[] = self::workoutRow($row);
      }
      // var_dump($workouts);
      return $workouts;
  
    } catch (\PDOException $e) {
      throw new Exception('Error getting workouts: ' . $e->getMessage());
    }
  }
  
  private static function workoutRow(array $row) {
    return new Workout($row['userId'], $row['workoutName'], $row['duration']);
  }

  public function addWorkout(Workout $workout)
  {
    try {
      $stmt = $this->connection->prepare("
      INSERT INTO workout (userId, workoutName, duration)
      VALUES (:userId, :workoutName, :duration)
    ");
      $params = [
        ':userId' => $workout->getUserId(),
        ':workoutName' => $workout->getWorkoutName(),
        ':duration' => $workout->getDuration()
      ];
      $stmt->execute($params);


    } catch (\PDOException $e) {
      throw new Exception('Error adding workout: ' . $e->getMessage());
    }
  }

  public function deleteWorkout($userId, $workoutName, $duration)
  {
    try {
      $stmt = $this->connection->prepare("
      DELETE FROM workout
      WHERE userId = :userId AND workoutName = :workoutName AND duration = :duration
     ");
      $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
      $stmt->bindParam(':workoutName', $workoutName, PDO::PARAM_STR);
      $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
      $stmt->execute();

      return true;

    } catch (\PDOException $e) {
      throw new Exception('Error deleting workout: ' . $e->getMessage());
    }
  }

}