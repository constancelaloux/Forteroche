<?php

namespace blog\form;

/**
 * Description of Entity
 *
 * @author constancelaloux
 */
class Entity 
{
  // Utilisation du trait Hydrator pour que nos entités puissent être hydratées
  use \blog\Hydrator;
  
  // La méthode hydrate() n'est ainsi plus implémentée dans notre classe
}
