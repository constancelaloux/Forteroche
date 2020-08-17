<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Author
 * The role of the author class is to represent an author present in BDD. It has no role to manage them.
 */
class Author extends Model
{
    
    /**
     * We use the Hydrator trait so that our Author object can be hydrated
     * Hydration = assign values ​​to attributes passed in parameters.
     * An array of data must be passed to the function (hence the prefix "array")
     * this must make it possible to assign the attributes of the object the corresponding values, passed in parameter in an array
     */

      protected $id,
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
     * Here, the builder requests the initial strength and damage for the character you just created.
     * It will therefore be necessary to specify it as a parameter in pdoConnection.
     * It only remains to implement the constructor so that we can directly hydrate our object when instantiating the class.
     * To do this, add a parameter: $ data. Then call the hydrate () method directly.
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
     * Currently, the attributes of our objects are inaccessible.
     * You have to create getters to be able to read them, and setters to be able to modify their values.
     * List of getters. I could reuse the functions later. a getter is a method responsible for returning 
     * the value of an attribute
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
