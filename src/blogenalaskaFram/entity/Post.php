<?php

namespace blog\entity;

use blog\database\Model;
/**
 * Description of Posts
 *
 * @author constancelaloux
 */
class Post extends Model
{
    /**
     * @var array
     */
    public $id,
      $author,
      $subject,
      $image,
      $content,
      $createdate,
      $updatedate
     ;

    public static function metadata()
    {
        return [
            "table"             => "post",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                /*"id_author"            => [
                    "type"      => "integer",
                    "property"  => "author"
                ],*/
                "create_date"    => [
                    "type"      => "string",
                    "property"  => "createdate"
                ],
                "update_date"    => [
                    "type"      => "string",
                    "property"  => "updatedate"
                ],
                "subject"    => [
                    "type"      => "string",
                    "property"  => "subject"
                ],
                "content"    => [
                    "type"      => "string",
                    "property"  => "content"
                ],
                "image"    => [
                    "type"      => "string",
                    "property"  => "image"
                ],
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
            ]
        ];
    }
    
    /**
     * Getters
    */
    //Actuellement, les attributs de nos objets sont inaccessibles. 
    //Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir modifier leurs valeurs.
    // Liste des getters. Je pourrais réutiliser les fonctions par la suite. 
    // un getter est une méthode chargée de renvoyer la valeur d'un attribut
    public function id()
        {
            return $this->id;
        }


    public function author()
        {
            return $this->author;
        }

    public function subject()
        {
            return $this->subject;
        }

    public function image()
        {
            return $this->image;
        }

    public function content()
        {
            return $this->content;
        }

    public function createdate()
        {
        print_r($this->createdate);
        //print_r("je pars");
            return $this->createdate;
        }

    public function updatedate()
        {
            return $this->updatedate;
        }

    public function status()
        {
            return $this->status;
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

    public function setAuthor($author)
        {
            //On vérifie qu'il s'agit bien d'une chaine de caractéres
            if(is_string($author))
            {
                $this->author = $author;
            }
        }

    public function setSubject($subject)
        {
            if(is_string($subject))
            {
                $this->subject = $subject;
            }
        }

    public function setImage($image)
        {
            if(is_string($image))
            {
                $this->image = $image;
            }
        }

    public function setContent($content)
        {
            if(is_string($content))
            {
                $this->content = $content;
            }
        }

    //public function setCreatedate(DateTime $createdate)
    public function setCreatedate($createdate)
        {   
            print_r($createdate);
            //die("meurs");
            
            if(is_string($createdate))
            {
                $this->createdate = $createdate;
                //print_r($this->createdate);
            }
        }

    public function setUpdatedate($updatedate)
        {
            if(is_string($updatedate))
            {
                $this->updatedate = $updatedate;
            }
        }

    public function setStatus($status)
        {
            if(is_string($status))
            {
                $this->status = $status;
            }
        }
}
