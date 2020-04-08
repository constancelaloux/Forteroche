<?php

namespace blog\database;

use blog\database\Model;

/**
 * Description of Author
 *  La classePersonnagea pour rôle de représenter un personnage 
 * présent en BDD. Elle n'a en aucun cas pour rôle de les gérer.
 */
class Author  extends Model
{
    
    /**
     * On utilise le trait Hydrator afin que notre objet Author puisse être hydraté
     * Hydratation = assigner des valeurs aux attributs passées en paramétres. 
     * Un tableau de données doit etre passé à la fonction(d'ou le préfixe "array")
     * celle-ci doit permettre d'assigner aux attributs de l'objet les valeurs correspondantes, passées en paramètre dans un tableau
     */
    use \blog\Hydrator;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
    /**
     * @ORM\Column(name="password", type="string", length=255)
    */
    private $password;
    
    /**
     * @ORM\Column(name="username", type="string", length=255)
    */
    private $username;
    
    /**
     * @ORM\Column(name="surname", type="string", length=255)
    */
    private $surname;
    
    /**
     * @ORM\Column(name="firstname", type="string", length=255)
    */
    private $firstname;

    /**
     *Ici, le constructeur demande la force et les dégâts initiaux du personnage que l'on vient de créer. 
     * Il faudra donc lui spécifier en paramétre dans pdoConnection.
     * Il ne manque plus qu'à implémenter le constructeur pour qu'on puisse directement hydrater notre objet lors de l'instanciation de la classe.
     * Pour cela, ajoutez un paramètre :$donnees. Appelez ensuite directement la méthodehydrate().
    */
    public function __construct($donnees = [])
    {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);       
        }
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
            ]
        ];
    }
    /**
     * Actuellement, les attributs de nos objets sont inaccessibles. 
     * Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir modifier leurs valeurs.
     * Liste des getters. Je pourrais réutiliser les fonctions par la suite. 
     * un getter est une méthode chargée de renvoyer la valeur d'un attribut
     */
    
    /**
     * Getters
    */
    public function getId()
    {
        return $this->id;
    }


    public function getPassword()
    {
        return $this->password;

    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getFirstname()
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
    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    public function setSurname($surname)
    {
        //On vérifie qu'il s'agit bien d'une chaine de caractéres
        if(is_string($surname))
        {
            //L'attribut de l'admin manager sera = a $surname. 
            //Il aura la valeur de la variable $surname
            $this->surname = $surname;
        }
    }

    public function setPassword($password)
    {
        if(is_string($password))
        {
            $this->password = $password;
        }
    }

    public function setUsername($username)
    {
        if(is_string($username))
        {
            $this->username = $username;
        }
    }

    public function setFirstname($firstname)
    {
        if(is_string($firstname))
        {
            $this->firstname = $firstname;
        }
    }
}
