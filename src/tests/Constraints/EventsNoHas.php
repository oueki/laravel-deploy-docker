<?php

namespace Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

class EventsNoHas extends Constraint
{

    /**
     * @var string
     */
    private string $eventClass;

    public function __construct(string $eventClass)
    {
        $this->eventClass = $eventClass;
    }

    /**
     * Returns a string representation of the object.
     */
    public function toString(): string
    {
        return \sprintf(
            'no contains event "%s"',
            $this->eventClass
        );
    }

    protected function matches($events): bool
    {
        foreach ($events as $event)
        {
            if($event instanceof $this->eventClass){
                return false;
            }
        }

        return true;

    }

    protected function failureDescription($other): string
    {
        return 'events ' . $this->toString();
    }
}
