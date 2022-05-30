<?php

namespace Tests\Unit\ExampleDependency;

use App\Services\ExampleDependency\OrderService1;

class OrderService1Test
{
    public function test()
    {
        $order = ['id' => 1, 'type' => 'product', 'sum' => 500];
        $service = new OrderService1();
        $service->create($order);
    }
}
