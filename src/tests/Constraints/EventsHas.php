<?php

namespace Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

class EventsHas extends Constraint
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
            'contains event "%s"',
            $this->eventClass
        );
    }

    protected function matches($events): bool
    {
        return count(array_filter($events, function($event){
                return $event instanceof $this->eventClass;
            })) > 0;
    }

    protected function failureDescription($other): string
    {
        return 'events ' . $this->toString();
    }
}
