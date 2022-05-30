<?php

namespace App\Services\ExampleDependency;

class TaxCalculator
{
    public function calculateTax(array $order): float
    {
        return $order['sum'] * .4;
    }
}
