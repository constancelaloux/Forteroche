<?php

namespace blog\entity;

use blog\database\Model;

use DateTime;

/**
 * Description of Post
 *
 * @author constancelaloux
 */
class Post extends Model
{

    /**
     * @var type 
     */
    protected $id,
      $idauthor,
      $subject,
      $image,
      $content,
      $createdate,
      $updatedate,
      $slugimage
     ;

    /**
     * Database architecture
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
     * Currently, the attributes of our objects are inaccessible.
     * We have to create getters to be able to read them, and setters to be able to modify their values.
     * List of getters. I could reuse the functions later.
     * A getter is a method responsible for returning the value of an attribute
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
    public function slugimage()
    {
        return $this->slugimage;
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
     * A setter is a method responsible for assigning a value to an attribute by checking its integrity 
     * (if you assign the value without any control, you lose all the interest brought by the encapsulation 
     * principle).
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
     * @param type $slugimage
     */
    public function setSlugimage($slugimage)
    {
        if(is_string($slugimage))
        {
            $this->slugimage = $slugimage;
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
