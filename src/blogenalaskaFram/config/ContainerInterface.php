<?php

namespace blog\config;

/**
 *
 * @author constancelaloux
 */
interface ContainerInterface 
{
    public function get($id);
    public function has($id);
}
