<?php

namespace App\Services\ExampleDependency;

class OrderService1
{
    private TaxCalculator $taxCalculator;

    public function __construct() {
        $this->taxCalculator = new TaxCalculator();
    }

    public function create(array $order): void
    {
//        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $tax = $this->taxCalculator->calculateTax($order);

    }
}
