<?php

namespace Controllers;
use Services\UserFoodService;
use Models\NutritionFact;

use Exception;

class UserFoodController extends Controller
{
    private $userFoodService;

    // initialize services
    function __construct()
    {
        $this->userFoodService = new UserFoodService();
    }

    public function addFood()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            // var_dump($data);
            $userFood = new NutritionFact(
                $data['userId'] ?? null,
                $data['foodName'] ?? null,
                $data['carbs'] ?? null,
                $data['proteins'] ?? null,
                $data['fat'] ?? null,
                $data['fibers'] ?? null
            );
            // var_dump($userFood);

            $this->userFoodService->addUserFood($userFood);

            // var_dump($user);
            $this->respond(['message' => 'Food added successfully']);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getUserFood()
    {
        try {
            $userId = $_GET['userId'];
            $userFood = $this->userFoodService->getUserFoodChoice($userId);
            
            $this->respond($userFood);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        } 
    }

    public function deleteFood()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $foodId = $data['foodId'] ?? null;
            $this->userFoodService->DeleteUserFood($foodId);
            $this->respond(['message' => 'Food deleted successfully']);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
}