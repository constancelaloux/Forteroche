<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Client
 * La class client a pour rôle de représenter un client
 * présent en BDD. Elle n'a en aucun cas pour rôle de les gérer.
 * @author constancelaloux
 */
class Client extends Model
{
      public $id,
            $password,
            $username,
            $firstname,
            $surname;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    //protected $id;
    
    /**
     * @ORM\Column(name="password", type="string", length=255)
    */
    //protected $password;
    
    /**
     * @ORM\Column(name="username", type="string", length=255)
    */
    //protected $username;
    
    /**
     * @ORM\Column(name="surname", type="string", length=255)
    */
    //protected $surname;
    
    /**
     * @ORM\Column(name="firstname", type="string", length=255)
    */
    //protected $firstname;

    const PASSWORD_INVALIDE = 1;
    const USERNAME_INVALIDE = 2;
    const FIRSTNAME_INVALIDE = 3;
    const SURNAME_INVALIDE = 4;
    /**
     *Ici, le constructeur demande la force et les dégâts initiaux du personnage que l'on vient de créer. 
     * Il faudra donc lui spécifier en paramétre dans pdoConnection.
     * Il ne manque plus qu'à implémenter le constructeur pour qu'on puisse directement hydrater notre objet lors de l'instanciation de la classe.
     * Pour cela, ajoutez un paramètre :$donnees. Appelez ensuite directement la méthodehydrate().
    */

    public function isValid()
    {
        return !(empty($this->password) || empty($this->username) || empty($this->surname)|| empty($this->firstname));
    }
    
    public static function metadata()
    {
        return [
            "table"             => "client",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "surname"            => [
                    "type"      => "string",
                    "property"  => "surname"
                ],
                "firstname"            => [
                    "type"      => "string",
                    "property"  => "firstname"
                ],
                "username"            => [
                    "type"      => "string",
                    "property"  => "username"
                ],
                "password"    => [
                    "type"      => "string",
                    "property"  => "password"
                ],
            ]
        ];
    }
    
    /**
     * Getters
     * Actuellement, les attributs de nos objets sont inaccessibles. 
     * Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir modifier leurs valeurs.
     * Liste des getters. Je pourrais réutiliser les fonctions par la suite. 
     * un getter est une méthode chargée de renvoyer la valeur d'un attribut
    */
    
    /**
     * @return type
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return type
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return type
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return type
     */
    public function surname()
    {
        return $this->surname;
    }

    /**
     * @return type
     */
    public function firstname()
    {
        return $this->firstname;
    }

    /**
     * Setters
     * un setter est une méthode chargée d'assigner une valeur à un 
     * attribut en vérifiant son intégrité (si vous assignez la valeur 
     * sans aucun contrôle, vous perdez tout l'intérêt qu'apporte le 
     * principe d'encapsulation).
    */
    
    /**
     * @param type $id
     */
    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    /**
     * @param type $surname
     */
    public function setSurname($surname)
    {
        if(!is_string($surname) || empty($surname))
        {
            $this->erreurs[] = self::SURNAME_INVALIDE;
        }
        $this->surname = $surname;
    }

    /**
     * @param type $password
     */
    public function setPassword($password)
    {
        if (!is_string($password) || empty($password))
        {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }
        $this->password = $password;
    }

    /**
     * @param type $username
     */
    public function setUsername($username)
    {
        if(!is_string($username) || empty($username))
        {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }
        $this->username = $username;
    }

    /**
     * @param type $firstname
     */
    public function setFirstname($firstname)
    {
        if(!is_string($firstname) || empty($firstname))
        {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }
        $this->firstname = $firstname;
    }
}
