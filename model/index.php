<?php

require_once 'model/Database.php';
$bdd = new Database();

$query = 
    'SELECT posts.id, title, SUBSTRING(content, 1, 100) AS content, name, DATE_FORMAT(posts.created_at, \'%W %e %M %Y à %Hh%imin%ss\') AS created_at_fr, firstname, lastname  
    FROM posts
    INNER JOIN categories ON categories.id = posts.category_id
    INNER JOIN authors ON authors.id = posts.author_id
    ORDER BY created_at_fr DESC
    LIMIT 10';

    $donnees = $bdd->findAll($query,[]);

$template = 'view/indexView';
include 'view/layoutView.phtml';