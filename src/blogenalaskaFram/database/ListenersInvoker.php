<?php

declare(strict_types=1);
namespace blog\database;
use blog\database\Metadata;
use blog\database\EventManager;
/**
 * A method invoker based on entity lifecycle.
 */
class ListenersInvoker
{
    const INVOKE_NONE      = 0;
    const INVOKE_LISTENERS = 1;
    const INVOKE_CALLBACKS = 2;
    const INVOKE_MANAGER   = 4;
    /** @var EntityListenerResolver The Entity listener resolver. */
    private $resolver;
    /**
     * The EventManager used for dispatching events.
     *
     * @var EventManager
     */
    private $eventManager;
    /**
     * Initializes a new ListenersInvoker instance.
     */
    private $metadata;
    public function __construct(EntityManagerInterface $em)
    {
    
        $this->metadata = new Metadata;
        $this->eventManager = $em->getEventManager();
        $this->ev = new EventManager();
        //$this->resolver     = $em->getConfiguration()->getEntityListenerResolver();
    }
    /**
     * Get the subscribed event systems
     *
     * @param ClassMetadata $metadata  The entity metadata.
     * @param string        $eventName The entity lifecycle event.
     *
     * @return int Bitmask of subscribed event systems.
     */
    public function getSubscribedSystems($eventName)
    {
        //print_r($eventName);
        $invoke = self::INVOKE_NONE;
        if (isset($this->metadata->lifecycleCallbacks[$eventName])) {
            $invoke |= self::INVOKE_CALLBACKS;
        }
        if (isset($this->metadata->entityListeners[$eventName])) {
            $invoke |= self::INVOKE_LISTENERS;
        }
        if ($this->ev->hasListeners($eventName)) {
            $invoke |= self::INVOKE_MANAGER;
        }
        //print_r($invoke);
        return $invoke;
    }
    /**
     * Dispatches the lifecycle event of the given entity.
     *
     * @param ClassMetadata $metadata  The entity metadata.
     * @param string        $eventName The entity lifecycle event.
     * @param object        $entity    The Entity on which the event occurred.
     * @param EventArgs     $event     The Event args.
     * @param int           $invoke    Bitmask to invoke listeners.
     */
    public function invoke(ClassMetadata $metadata, $eventName, $entity, EventArgs $event, $invoke)
    {
        if ($invoke & self::INVOKE_CALLBACKS) {
            foreach ($metadata->lifecycleCallbacks[$eventName] as $callback) {
                $entity->{$callback}($event);
            }
        }
        if ($invoke & self::INVOKE_LISTENERS) {
            foreach ($metadata->entityListeners[$eventName] as $listener) {
                $class    = $listener['class'];
                $method   = $listener['method'];
                $instance = $this->resolver->resolve($class);
                $instance->{$method}($entity, $event);
            }
        }
        if ($invoke & self::INVOKE_MANAGER) {
            $this->eventManager->dispatchEvent($eventName, $event);
        }
    }
}