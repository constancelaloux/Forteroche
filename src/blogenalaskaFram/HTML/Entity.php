<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

/**
 * Description of Entity
 *
 * @author constancelaloux
 */
class Entity 
{
  // Utilisation du trait Hydrator pour que nos entités puissent être hydratées
  use Hydrator;
  
  // La méthode hydrate() n'est ainsi plus implémentée dans notre classe
}
