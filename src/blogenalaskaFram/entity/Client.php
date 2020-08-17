<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Client
 * Client class role represent a client who exist into database. But it doesnt manage them
 * @author constancelaloux
 */
class Client extends Model
{
      protected $id,
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
     * Here, the builder requests the initial strength and damage for the character you just created.
     * It will therefore be necessary to specify it as a parameter in pdoConnection.
     * It only remains to implement the constructor so that we can directly hydrate our object when instantiating the class.
     * To do this, add a parameter: $data. Then call the hydrate() method directly.
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
