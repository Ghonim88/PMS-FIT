<?php
namespace Models;

class Workout{

  private $userId;
  private $workoutName;
  private $duration;

  public function __construct($userId, $workoutName, $duration) {
      $this->userId = $userId;
      $this->workoutName = $workoutName;
      $this->duration = $duration;
  }

  public function getUserId()
  {
      return $this->userId;
  }
  public function setUserId($userId)
  {
      $this->userId = $userId;
  }
    public function getWorkoutName() {
        return $this->workoutName;
    }
    public function setWorkoutName($workoutName) {
        $this->workoutName = $workoutName;
    }
    public function getDuration() {
        return $this->duration;
    }
    public function setDuration($duration) {
        $this->duration = $duration;
    }
    public function toArray() {
        return [
          'userId' => $this->getUserId(),
          'workoutName' => $this->getWorkoutName(),
          'duration' => $this->getDuration(),
        ];
      }

}