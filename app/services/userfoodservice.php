<?php

namespace Services;

use Repositories\NutritionFactRepository;
use Models\NutritionFact;
use Models\GoalEnum;

class UserFoodService {
    private $nutritionFactRepository;

    function __construct()
    {
        $this->nutritionFactRepository = new NutritionFactRepository();
    }
    
    public function processUserGoal($userGoal)
    {
      $goalId = 0;
        switch ($userGoal) {
            case GoalEnum::LOSE_WEIGHT:

                $foods = $this->nutritionFactRepository->getFoodsByUserGoal($goalId);
             
                break;
            case GoalEnum::MAINTAIN_WEIGHT:
              $goalId=1 ;
                $foods = $this->nutritionFactRepository->getFoodsByUserGoal($goalId);

                break;
            case GoalEnum::BUILD_MUSCLE:
              $goalId=2 ;
                $foods = $this->nutritionFactRepository->getFoodsByUserGoal($goalId);
                break;
            default:
                $foods = $this->nutritionFactRepository->getFoodsByUserGoal($goalId);
                break;
        }
        return $foods;
    }
    public function getUserFoodChoice($userId){

      return $this->nutritionFactRepository->getUserFood($userId);
  }
   
    public function addUserFood(NutritionFact $userFood)
    {
        try {
            // $nutritionFact = $this->convertArrayToNutritionFact($nutritionFact);
            $this->nutritionFactRepository->addUserFood($userFood);
        } catch (\Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \Exception('Error adding user food: ' . $e->getMessage());
        }
    }

    public function DeleteUserFood($foodId)
    {
        try {
            $this->nutritionFactRepository->DeleteUserFood($foodId);
        } catch (\Exception $e) {
            // Handle the exception (log, show an error message, etc.)
            throw new \Exception('Error deleting user food: ' . $e->getMessage());
        }
    }

    private function convertArrayToNutritionFact(array $nutritionFactData): NutritionFact
    {
        // Ensure that all required keys are present in the array
        $requiredKeys = ['userId', 'foodname', 'carbs', 'proteins', 'fats', 'fibers'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $nutritionFactData)) {
                throw new \Exception("Missing key in nutrition fact data: $key");
            }
        }

        // Now you can create a new NutritionFact object
        $nutritionFact = new NutritionFact(
            $nutritionFactData['userId'],
            $nutritionFactData['foodname'],
            $nutritionFactData['carbs'],
            $nutritionFactData['proteins'],
            $nutritionFactData['fats'],
            $nutritionFactData['fibers']
        );

        return $nutritionFact;
    }
    


} 