<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Constraints\EventsHas;
use Tests\Constraints\EventsNoHas;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertEventsHas(string $eventClass, array $events)
    {
        static::assertThat($events, new EventsHas($eventClass));
    }

    protected function assertEventsNoHas(string $eventClass, array $events)
    {
        static::assertThat($events, new EventsNoHas($eventClass));
    }
}
