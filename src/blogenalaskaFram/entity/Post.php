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
     * @var type 
     */
    public $id,
      $idauthor,
      $subject,
      $image,
      $content,
      $createdate,
      $updatedate
     ;

    /**
     * Architecture de la base de données
     * @return type
     */
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
                "id_author"            => [
                    "type"      => "integer",
                    "property"  => "idauthor"
                ],
                "create_date"    => [
                    "type"      => "datetime",
                    "property"  => "createdate"
                ],
                "update_date"    => [
                    "type"      => "datetime",
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
     * //Actuellement, les attributs de nos objets sont inaccessibles. 
     * //Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir modifier leurs valeurs.
     * Liste des getters. Je pourrais réutiliser les fonctions par la suite. 
     * un getter est une méthode chargée de renvoyer la valeur d'un attribut
    */
    
    /**
     * 
     * @return type
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return type
     */
    public function idauthor()
    {
        return $this->idauthor;
    }
    
    /**
     * @return type
     */
    public function subject()
    {
        return $this->subject;
    }
        
    /**
     * @return type
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @return type
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return type
     */
    public function createdate()
    {
        return $this->createdate;
    }

    /**
     * @return type
     */
    public function updatedate()
    {
        return $this->updatedate;
    }

    /**
     * @return type
     */
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
     * @param type $idauthor
     */
    public function setIdauthor($idauthor)
    {
        $idauthor = (int)$idauthor;
        if ($idauthor > 0)
        {
            $this->idauthor = $idauthor;
        }
    }

    /**
     * @param type $subject
     */
    public function setSubject($subject)
    {
        if(is_string($subject))
        {
            $this->subject = $subject;
        }
    }

    /**
     * @param type $image
     */
    public function setImage($image)
    {
        if(is_string($image))
        {
            $this->image = $image;
        }
    }

    /**
     * @param type $content
     */
    public function setContent($content)
    {
        if(is_string($content))
        {
            $this->content = $content;
        }
    }

    /**
     * @param type $createdate
     */
    public function setCreatedate($createdate)
    {   
        if(is_string($createdate))
        {
            $this->createdate = new \DateTime($createdate);
        }
    }

    /**
     * @param type $updatedate
     */
    public function setUpdatedate($updatedate)
    {
        if(is_string($updatedate))
        {
            $this->updatedate = new \DateTime($updatedate);
        }
    }

    /**
     * @param type $status
     */
    public function setStatus($status)
    {
        if(is_string($status))
        {
            $this->status = $status;
        }
    }
}
