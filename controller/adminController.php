<?php
session_start();

// On vérifie que le user est bien un admin
if (!empty($_SESSION) and array_key_exists('user', $_SESSION) and $_SESSION['user']['admin'])
{

    // On inclue les class Controller et Database pour utiliser leurs méthodes
    require_once '../model/Database.php';
    require_once 'Controller.php';
    $control = new Controller();
    $bdd = new Database();

    // Affichage des posts
    $query = 
        'SELECT posts.id, title, DATE_FORMAT(posts.created_at, \'%W %e %M %Y à %Hh%imin%ss\') AS created_at_fr, firstname, lastname, name
        FROM posts
        INNER JOIN categories ON categories.id = posts.category_id
        INNER JOIN authors ON authors.id = posts.author_id
        ORDER BY posts.id DESC';

        $donnees2 = $bdd->findAll($query,[]);

    //Afficahge des Utilisateurs
    $query = 
        'SELECT id, firstname, lastname, pseudo, email
        FROM authors 
        ORDER BY id';

        $donnees = $bdd->findAll($query,[]);

    //Affichage des catégories

    $query = 
        'SELECT id, name
        FROM categories
        ORDER BY id';

        $donnees3 = $bdd->findAll($query,[]);

        $template = '../view/adminView';
        include '../view/layoutView.phtml';
}
else 
{
    header('Location: ../index.php');
}





