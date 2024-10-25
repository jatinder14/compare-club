<?php

namespace CompareClub\Repository\Clothing;

class Clothing {
    /**
     * @var int $id
     * The unique identifier for a clothing item.
     */
    public $id;

    /**
     * @var string $brand
     * The brand name of the clothing item.
     */
    public $brand;

    /**
     * @var string $type
     * The type of clothing item (e.g., T-Shirt, Jeans).
     */
    public $type;

    /**
     * @var string $size
     * The size of the clothing item (e.g., Small, Medium, Large).
     */
    public $size;

    /**
     * @var string $colour
     * The colour of the clothing item.
     */
    public $colour;

    /**
     * @var float $price
     * The price of the clothing item.
     */
    public $price;

    /**
     * @var string $gender
     * The gender for which the clothing item is intended (e.g., Men, Women, Unisex).
     */
    public $gender;

    public function __construct($id, $brand, $type, $size, $colour, $price, $gender) {
        $this->id = $id;
        $this->brand = $brand;
        $this->type = $type;
        $this->size = $size;
        $this->colour = $colour;
        $this->price = $price;
        $this->gender = $gender;
    }
}