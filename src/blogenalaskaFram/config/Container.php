<?php

namespace blog\config;
use blog\config\ContainerInterface;
use blog\exceptions\ServiceNotFoundException;
use Exception;

/**
 * Description of Container
 *
 * @author constancelaloux
 */
class Container implements ContainerInterface
{
    private $services;
    private $parameters;
    private $serviceStore;

    public function __construct(array $services = [])
    {
        $this->services = $services;
        $this->serviceStore = [];
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function get($name)
    {
        if (!$this->has($name)) 
        {
            //throw new ServiceNotFoundException('Service not found: '.$name);
        }

        /**
         * If we haven't created it, create it and save to store
         */
        if (!isset($this->serviceStore[$name])) 
        {
            $this->serviceStore[$name] = $this->createService($name);
        }

        /**
         * Return service from store
         */
        return $this->serviceStore[$name];
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    /**
     * 
     * @param type $name
     * @return type
     * @throws ParameterNotFoundException
     */
    public function getParameter($name)
    {
        $tokens  = explode('.', $name);
        $context = $this->parameters;

        while (null !== ($token = array_shift($tokens))) 
        {
            if (!isset($context[$token])) 
            {
                throw new ParameterNotFoundException('Parameter not found: '.$name);
            }

            $context = $context[$token];
        }

        return $context;
    }

    /**
     * 
     * @param type $name
     * @return boolean
     */
    public function hasParameter($name)
    {
        try 
        {
            $this->getParameter($name);
        } 
        catch (ParameterNotFoundException $exception) 
        {
            return false;
        }

        return true;
    }

    /**
     * Attempt to create a service.
     * @param type $name
     * @return type
     */
    private function createService($name)
    {
        $entry = &$this->services[$name];
        if (!is_array($entry) || !isset($entry['class'])) 
        {
            //throw new ContainerException($name.' service entry must be an array containing a \'class\' key');
        } 
        elseif (!class_exists($entry['class'])) 
        {
            //throw new ContainerException($name.' service class does not exist: '.$entry['class']);
        } 
        elseif (isset($entry['lock'])) 
        {
            //throw new ContainerException($name.' contains circular reference');
        }

        $entry['lock'] = true;

        $arguments = isset($entry['arguments']) ? $this->resolveArguments($entry['arguments']) : [];
        $reflector = new \ReflectionClass($entry['class']);
        $service = $reflector->newInstanceArgs($arguments);
        if (isset($entry['calls'])) 
        {
            $this->initializeService($service, $name, $entry['calls']);
        }
        return $service;
    }

    /**
     * Resolve argument definitions into an array of arguments.
     * @param array $argumentDefinitions
     * @return \blog\config\ParameterReference
     */
    private function resolveArguments(array $argumentDefinitions)
    {
        $arguments = [];

        foreach ($argumentDefinitions as $argumentDefinition) 
        {
            if ($argumentDefinition instanceof ServiceReference) 
            {
                $argumentServiceName = $argumentDefinition->getName();

                $arguments[] = $this->get($argumentServiceName);
            } 
            elseif ($argumentDefinition instanceof ParameterReference) 
            {
                $argumentParameterName = $argumentDefinition->getName();

                $arguments[] = $this->getParameter($argumentParameterName);
            } 
            else 
            {
                $arguments[] = $argumentDefinition;
            }
        }

        return $arguments;
    }

    /**
     * nitialize a service using the call definitions.
     * @param type $service
     * @param type $name
     * @param array $callDefinitions
     * @throws ContainerException
     */
    private function initializeService($service, $name, array $callDefinitions)
    {
        foreach ($callDefinitions as $callDefinition) 
        {
            if (!is_array($callDefinition) || !isset($callDefinition['method'])) 
            {
                throw new ContainerException($name.' service calls must be arrays containing a \'method\' key');
            } 
            elseif (!is_callable([$service, $callDefinition['method']])) 
            {
                throw new ContainerException($name.' service asks for call to uncallable method: '.$callDefinition['method']);
            }

            $arguments = isset($callDefinition['arguments']) ? $this->resolveArguments($callDefinition['arguments']) : [];

            call_user_func_array([$service, $callDefinition['method']], $arguments);
        }
    }
}

