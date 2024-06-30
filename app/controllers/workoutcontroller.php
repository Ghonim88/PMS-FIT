<?php

namespace Controllers;

use Services\WorkoutService;

use Models\Workout;

class WorkoutController extends Controller
{

    private $workoutService;

    function __construct()
    {
        $this->workoutService = new WorkoutService();
    }

    public function getUserWorkout()
    {
        try {
            $userId = $_GET['userId']; 
            $workouts = $this->workoutService->getUserWorkout($userId);
            // Convert each Workout object to an array
            $workoutsArray = array_map(function ($workout) {
                return $workout->toArray();
            }, $workouts);

            $this->respond($workoutsArray);
        } catch (\Exception $e) {
            $this->respondWithError(500, 'An error occurred while fetching workouts.');
        }
    }

    public function addWorkout()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $workout = new Workout(
                $data['userId'] ?? null,
                $data['workoutName'] ?? null,
                $data['duration'] ?? null,
            );
            $this->workoutService->addWorkout($workout);
            $this->respond(['message' => 'Workout added successfully']);
        } catch (\Exception $e) {
            $this->respondWithError(500, 'Failed to add workout');
        }

    }

    public function deleteWorkout()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $workout = new Workout(
                $data['userId'] ?? null,
                $data['workoutName'] ?? null,
                $data['duration'] ?? null,
            );
            $this->workoutService->deleteWorkout($workout->getUserId(), $workout->getWorkoutName(), $workout->getDuration());
            $this->respond(['message' => 'Workout deleted successfully']);
        } catch (\Exception $e) {
            $this->respondWithError(500, 'Failed to delete workout');
        }
    }
}