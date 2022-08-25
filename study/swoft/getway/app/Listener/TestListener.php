<?php


namespace App\Listener;


use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Server\ServerEvent;

/**
 * Class TestListener
 *
 * @since 2.0
 *
 * @Listener("test.event")
 */
class TestListener implements EventHandlerInterface
{

    public function handle(EventInterface $event): void
    {
        $pos = __METHOD__;
        echo "handle the event '{$event->getName()}' on the: $pos\n";
    }
}
