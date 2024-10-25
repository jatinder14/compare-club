<?php

namespace CompareClub\Repository\Clothing;

use CompareClub\Repository\Clothing\IClothingRepository;
use CompareClub\Repository\Clothing\Clothing;

use Exception;

class ClothingRepository implements IClothingRepository
{

    private static $clothingItems = [];
    private static $maxId = 0;
    private static $lock;

    public function __construct()
    {
        self::$lock = fopen('php://temp', 'r+');
        $this->loadClothingItems();
    }

    private function loadClothingItems()
    {
        if (count(self::$clothingItems) > 0) {
            return self::$clothingItems;
        }

        $file = __DIR__ . '/clothing.json'; // Assume clothing.json is in the same directory
        if (file_exists($file)) {
            $jsonData = file_get_contents($file);
            $decodedData = json_decode($jsonData, true);

            foreach ($decodedData as $item) {
                self::$clothingItems[] = new Clothing(
                    $item['id'],
                    $item['brand'],
                    $item['type'],
                    $item['size'],
                    $item['colour'],
                    $item['price'],
                    $item['gender']
                );
            }

            $this->setMaxId();
        }

        return self::$clothingItems;
    }

    private function setMaxId()
    {
        if (!empty(self::$clothingItems)) {
            self::$maxId = max(array_map(function ($item) {
                return $item->id;
            }, self::$clothingItems));
        }
    }

    public function getAllClothes()
    {
        usleep(10000); // Simulate delay
        return self::$clothingItems;
    }

    public function add(Clothing $clothing)
    {
        $this->validateClothing($clothing);

        $maxId = -1;
        flock(self::$lock, LOCK_EX);
        try {
            if ($clothing->id == 0) {
                $clothing->id = ++self::$maxId;
            }

            self::$clothingItems[] = $clothing;
            $maxId = self::$maxId;
            $this->saveClothingItems(); // Save to file after adding
        } finally {
            flock(self::$lock, LOCK_UN);
        }

        return $maxId;
    }

    public function update(Clothing $clothing)
    {
        $this->validateClothing($clothing);

        flock(self::$lock, LOCK_EX);
        try {
            foreach (self::$clothingItems as &$currentItem) {
                if ($currentItem->id == $clothing->id) {
                    $currentItem->brand = $clothing->brand;
                    $currentItem->type = $clothing->type;
                    $currentItem->size = $clothing->size;
                    $currentItem->colour = $clothing->colour;
                    $currentItem->price = $clothing->price;
                    $currentItem->gender = $clothing->gender;
                    $this->saveClothingItems(); // Save to file after updating
                    return;
                }
            }
            throw new Exception("The clothing item with Id: '{$clothing->id}' does not exist");
        } finally {
            flock(self::$lock, LOCK_UN);
        }
    }

    public function calculateDiscountedTotal(array $clothes)
    {
        $total = 0;
        $itemCount = count($clothes);
        $hasLargeItem = false;

        foreach ($clothes as $clothing) {
            $total += $clothing->price;
            if (strtolower($clothing->size) === 'large') {
                $hasLargeItem = true;
            }
        }

        // Apply discounts
        $discount = 0;

        if ($total > 100) {
            $discount += 10; // 10% discount
        }

        if ($itemCount > 2) {
            $discount += 5; // 5% discount
        }

        if ($hasLargeItem) {
            $discount += 3; // 3% discount
        }

        // Calculate the final total after applying the discount
        $discountedAmount = ($total * $discount) / 100;
        $finalTotal = $total - $discountedAmount;

        return [
            'originalTotal' => $total,
            'discount' => $discount,
            'finalTotal' => $finalTotal
        ];
    }

    private function validateClothing(Clothing $clothing)
    {
        if (empty(self::$clothingItems)) {
            throw new Exception("Clothing repository is not available");
        }

        if (!$clothing) {
            throw new Exception("Please supply a valid clothing item. It's empty!");
        }

        if (empty(trim($clothing->brand))) {
            throw new Exception("Please supply a valid Brand. It is empty!");
        }

        if (empty(trim($clothing->type))) {
            throw new Exception("Please supply a valid Type. It is empty!");
        }

        if (empty(trim($clothing->size))) {
            throw new Exception("Please supply a valid Size. It is empty!");
        }

        if (empty(trim($clothing->colour))) {
            throw new Exception("Please supply a valid Colour. It's empty!");
        }

        if ($clothing->price <= 0) {
            throw new Exception("Please supply a valid Price. It should be positive!");
        }

        if (empty(trim($clothing->gender))) {
            throw new Exception("Please supply a valid Gender. It is empty!");
        }
    }

    private function saveClothingItems()
    {
        $file = __DIR__ . '/clothing.json'; // Assume clothing.json is in the same directory
        $jsonData = json_encode(array_map(function ($item) {
            return [
                'id' => $item->id,
                'brand' => $item->brand,
                'type' => $item->type,
                'size' => $item->size,
                'colour' => $item->colour,
                'price' => $item->price,
                'gender' => $item->gender,
            ];
        }, self::$clothingItems), JSON_PRETTY_PRINT);

        file_put_contents($file, $jsonData);
    }
}
