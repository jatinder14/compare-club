<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use CompareClub\Repository\Clothing\ClothingRepository;
use CompareClub\Repository\Clothing\Clothing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ClothingController extends BaseController
{
    protected $clothingRepository;

    // Inject ClothingRepository through the constructor
    public function __construct(ClothingRepository $clothingRepository)
    {
        $this->clothingRepository = $clothingRepository;
    }

    /**
     * Get all clothes in the inventory
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $clothes = $this->clothingRepository->getAllClothes();

            if (empty($clothes)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No clothing items found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Clothing items retrieved successfully',
                'data' => $clothes
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving clothing items: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve clothing items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new clothing item
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the input (simplified here, consider using a validator)
            $clothing = new Clothing(
                0, // ID will be auto-assigned by the repository
                $request->input('brand'),
                $request->input('type'),
                $request->input('size'),
                $request->input('colour'),
                $request->input('price'),
                $request->input('gender')
            );

            $newId = $this->clothingRepository->add($clothing);

            return response()->json([
                'status' => 'success',
                'message' => 'Clothing item adddfadfed successfully',
                'data' => ['id' => $newId]
            ], 201);
        } catch (Exception $e) {
            Log::error('Error adding clothing item: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add clothing item',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update an existing clothing item
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $clothing = new Clothing(
                $id,
                $request->input('brand'),
                $request->input('type'),
                $request->input('size'),
                $request->input('colour'),
                $request->input('price'),
                $request->input('gender')
            );

            $this->clothingRepository->update($clothing);

            return response()->json([
                'status' => 'success',
                'message' => 'Clothing item updated successfully',
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating clothing item: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update clothing item',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Calculate the total price of all clothes in the inventory
     * @return JsonResponse
     */
    /**
     * Calculate discounts on a list of clothing items.
     * @param Request $request
     * @return JsonResponse
     */
    public function discount(Request $request): JsonResponse
    {
        try {
            // Validate the input
            $clothesData = $request->input('clothes');

            if (empty($clothesData) || !is_array($clothesData)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid input data. Please provide a list of clothing items.',
                ], 400);
            }

            // Create clothing items from the request data
            $clothes = [];
            foreach ($clothesData as $item) {
                $clothing = new Clothing(
                    $item['id'], // Assuming the ID is provided
                    $item['brand'],
                    $item['type'],
                    $item['size'],
                    $item['colour'],
                    (float)$item['price'], // Ensure price is treated as a float
                    $item['gender']
                );
                $clothes[] = $clothing;
            }

            $result = $this->clothingRepository->calculateDiscountedTotal($clothes);

            return response()->json([
                'status' => 'success',
                'message' => 'Discount calculation successful',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error calculating discounts: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to calculate discounts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
