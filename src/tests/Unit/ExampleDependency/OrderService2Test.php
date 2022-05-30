<?php

namespace Tests\Unit\ExampleDependency;

use App\Services\ExampleDependency\OrderService2;
use App\Services\ExampleDependency\TaxCalculatorInterface;
use Tests\Fakes\FakeTaxCalculator;
use Tests\TestCase;

class OrderService2Test extends TestCase
{
    public function test()
    {
        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $service = new OrderService2(new FakeTaxCalculator());
        $service->create($order);
    }

    public function test2()
    {

        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $stub = $this->createStub(TaxCalculatorInterface::class);

        $stub->method('calculateTax')
            ->willReturn(10);

        $service = new OrderService2($stub);
        $service->create($order);
    }

    public function test3()
    {

        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $mock = $this->createMock(TaxCalculatorInterface::class);
        $mock->expects($this->once()) // exactly
            ->method('calculateTax')
            ->willReturn(10);

        $service = new OrderService2($mock);
        $service->create($order);
    }
}
