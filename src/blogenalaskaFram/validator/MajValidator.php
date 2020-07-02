<?php

namespace blog\validator;

use blog\validator\Validator;

/**
 * Description of MajValidator
 *
 * @author constancelaloux
 */
class MajValidator extends Validator
{

    public function isValid($value)
    {
        /**
         * https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2917331-controlez-les-mots-de-passe
         * Je vérifie si mon mot de passe n'est pas trop court et conforme
         */
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,8}$#', $value))
        {
            return $value;
        }
    }
}
