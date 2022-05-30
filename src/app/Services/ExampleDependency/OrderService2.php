<?php

namespace App\Services\ExampleDependency;

class OrderService2
{

    public function __construct(
        public readonly TaxCalculatorInterface $taxCalculatorInterface
    )
    {}

    public function create(array $order): void
    {
//        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $tax = $this->taxCalculatorInterface->calculateTax($order);

    }
}
