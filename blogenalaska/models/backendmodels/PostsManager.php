<?php

namespace Forteroche\blogenalaska\models\backendmodels;

require_once("Manager.php");

class PostsManager extends Manager {
    
    public function sendPostsBlog()
    {
        $bdd = $this->dbConnect();
        $posts=$bdd->query('SELECT p.id AS id, p.create_date AS create_date, p.subject AS subject, p.content AS content, a.firstname AS firstname, a.surname AS surname FROM articles_author AS a, articles AS p WHERE p.id_author = a.id');
        return $posts;
    }
}

