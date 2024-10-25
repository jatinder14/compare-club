<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use CompareClub\Repository\Clothing\ClothingRepository;

use Exception;

class ClothingController extends BaseController
{
    protected $clothingRepository;

    // Inject ClothingRepository through the constructor
    public function __construct(ClothingRepository $clothingRepository)
    {
        $this->clothingRepository = $clothingRepository;
    }

    public function get()
    {
        // Fetching all clothes using the repository
        $clothes = $this->clothingRepository->getAllClothes();

        // Respond with the clothing data as JSON
        return response()->json($clothes, 200);
    }
}