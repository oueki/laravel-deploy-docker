<?php

namespace App\Services\ExampleDependency;

interface TaxCalculatorInterface
{
    public function calculateTax(array $order): float;

}
