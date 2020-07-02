<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Author
 *  La class auteur a pour rôle de représenter un auteur
 * présent en BDD. Elle n'a en aucun cas pour rôle de les gérer.
 */
class Author extends Model
{
    
    /**
     * On utilise le trait Hydrator afin que notre objet Author puisse être hydraté
     * Hydratation = assigner des valeurs aux attributs passées en paramétres. 
     * Un tableau de données doit etre passé à la fonction(d'ou le préfixe "array")
     * celle-ci doit permettre d'assigner aux attributs de l'objet les valeurs correspondantes, passées en paramètre dans un tableau
     */

      public $id,
            $password,
            $username,
            $firstname,
            $surname,
            $status,
            $image,
            $slugimage;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    //protected $id;
    
    /**
     * @ORM\Column(name="password", type="string", length=255)
    */
    //private $password;
    //protected $password;
    
    /**
     * @ORM\Column(name="username", type="string", length=255)
    */
    //private $username;
    //protected $username;
    
    /**
     * @ORM\Column(name="surname", type="string", length=255)
    */
    //private $surname;
    //protected $surname;
    
    /**
     * @ORM\Column(name="firstname", type="string", length=255)
    */
    //private $firstname;
    //protected $firstname;

    const PASSWORD_INVALIDE = 1;
    const USERNAME_INVALIDE = 2;
    const FIRSTNAME_INVALIDE = 3;
    const SURNAME_INVALIDE = 4;
    const STATUS_INVALIDE = 5;
    const IMAGE_INVALIDE = 6;
    
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
            "table"             => "author",
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
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
                "image"    => [
                    "type"      => "string",
                    "property"  => "image"
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
     * @return type
     */
    public function status()
    {
        return $this->status;
    }
    
    /**
     * 
     * @return type
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @return type
     */
    public function slugimage()
    {
        return $this->slugimage;
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
        /**
         * On vérifie qu'il s'agit bien d'une chaine de caractéres
         */
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
     * @param type $username
     */
    public function setImage($image)
    {
        if(!is_string($image) || empty($image))
        {
            $this->erreurs[] = self::IMAGE_INVALIDE;
        }
        $this->image = $image;
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
    
    /**
     * @param type $status
     */
    public function setStatus($status)
    {
        if(!is_string($status) || empty($status))
        {
            $this->erreurs[] = self::STATUS_INVALIDE;
        }
        $this->status = $status;
    }
    
    /**
     * @param type $slugimage
     */
    public function setSlugimage($slugimage)
    {
        if(is_string($slugimage))
        {
            $this->slugimage = $slugimage;
        }
    }
}
