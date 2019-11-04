<?php

namespace blog\database;

class Metadata
{
   /**
     * READ-ONLY: The registered lifecycle callbacks for entities of this class.
     *
     * @var string[][]
     */
    public $lifecycleCallbacks = [];
    
        /**
     * READ-ONLY: The registered entity listeners.
     *
     * @var mixed[][]
     */
    public $entityListeners = [];
}
