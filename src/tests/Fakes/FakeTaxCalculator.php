<?php

namespace Tests\Fakes;

use App\Services\ExampleDependency\TaxCalculatorInterface;

class FakeTaxCalculator implements TaxCalculatorInterface
{

    public function calculateTax(array $order): float
    {
        return 10;
    }
}
