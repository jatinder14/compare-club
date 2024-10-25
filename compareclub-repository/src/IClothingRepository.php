<?php

namespace CompareClub\Repository\Clothing;

interface IClothingRepository
{
    public function getAllClothes();

    public function add(Clothing $clothing);

    public function update(Clothing $clothing);

    public function calculateDiscountedTotal(array $clothing);
}