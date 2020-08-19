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
    protected $id,
      $idauthor,
      $idpost,
      $createdate,
      $updatedate,
      $subject,
      $commentContent,
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
                "id_author"     => [
                    "type"      => "integer",
                    "property"  => "idauthor"
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
                    "property"  => "commentContent"
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
    public function idpost()
    {
        return $this->idpost;
    }

    /**
     * @return type
     */
    public function commentContent()
    {
        return $this->commentContent;
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
    public function setIdauthor($idauthor)
    {
        $idauthor = (int)$idauthor;
        if ($idauthor > 0)
        {
            $this->idauthor = $idauthor;
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
    public function setCommentContent($commentContent)
    {
        if(is_string($commentContent))
        {
            $this->commentContent = $commentContent;
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
