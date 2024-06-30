<?php
namespace Services;

use Repositories\WorkoutRepository;
use Models\Workout;

class WorkoutService {
    private $workoutRepository;

    function __construct()
    {
        $this->workoutRepository = new WorkoutRepository();
    }

    

  public function getUserWorkout($userId)
  {
      try {
          $workouts = $this->workoutRepository->getAllWorkouts($userId);
        //   var_dump($workouts);
          return $workouts;
      } catch (\Exception $e) {
          // Handle the exception (log, show an error message, etc.)
          throw new \Exception('Error getting workouts: ' . $e->getMessage());
      }
  }

  public function addWorkout(Workout $workout)
  {
      try {
          // $workout = $this->convertArrayToWorkout($workoutData);
         
          $this->workoutRepository->addWorkout($workout);
      } catch (\Exception $e) {
          // Handle the exception (log, show an error message, etc.)
          throw new \Exception('Error adding workout: ' . $e->getMessage());
      }
  }

  public function deleteWorkout($userId, $workoutName, $duration)
  {
      try {
          $this->workoutRepository->deleteWorkout($userId, $workoutName, $duration);
      } catch (\Exception $e) {
          // Handle the exception (log, show an error message, etc.)
          throw new \Exception('Error deleting workout: ' . $e->getMessage());
      }
  }
}