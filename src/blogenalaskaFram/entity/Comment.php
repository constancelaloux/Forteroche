<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Comment
 *
 * @author constancelaloux
 */
class Comment extends Model
{
    /**
     * @var array
     */
    public $id,
      $idclient,
      $idpost,
      $createdate,
      $updatedate,
      $subject,
      $content,
      $status,
      $countclicks
     ;

    /**
     * Database architecture
     * @return type
     */
    public static function metadata()
    {
        return [
            "table"             => "comment",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "id_client"     => [
                    "type"      => "integer",
                    "property"  => "idclient"
                ],
                "id_post"     => [
                    "type"      => "integer",
                    "property"  => "idpost"
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
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
                "countclicks"    => [
                    "type"      => "integer",
                    "property"  => "countclicks"
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
    public function idclient()
    {
        return $this->idclient;
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
    public function idpost()
    {
        return $this->idpost;
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
     * @return type
     */
    public function countclicks()
    {
        //print_r($this->countclicks);
        return $this->countclicks;
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
     * @param type $idclient
     */
    public function setIdclient($idclient)
    {
        $idclient = (int)$idclient;
        if ($idclient > 0)
        {
            $this->idclient = $idclient;
        }
    }
    
    /**
     * @param type $idpost
     */
    public function setIdpost($idpost)
    {
        $idpost = (int)$idpost;
        if ($idpost > 0)
        {
            $this->idpost = $idpost;
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
     * @param type $countclicks
     */
    public function setCountclicks($countclicks)
    {
        $countclick = (int)$countclicks;
        $this->countclicks = $countclick;
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
