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

    if(empty($_POST))
    {
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            header('Location: forumController.php');
            exit();
        }

        // Récupération d'un Sujet.
        $query = 'SELECT posts.id, content, title, created_at, author_id, category_id, name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        WHERE posts.id = :id';
        $donnees = $bdd->findOne($query, [':id' => $_GET['id']]);

        //Affichage des catégories
        $query = 
        'SELECT id, name
        FROM categories
        ORDER BY id';

        $donnees3 = $bdd->findAll($query,[]);

        $template = '../view/editSubjectView';
        include '../view/layoutView.phtml';
    }
    else
    {
        // Edition d'un Sujet.
        $query ='UPDATE posts
        SET content = :content,
            title = :title,
            category_id = :category
        WHERE id = :subjectId';

        // On instencie la class Controller pour vérifier ce que rentre l'utilsateur
        $bdd->executeSql($query, [
            ':content' => htmlentities($_POST['contentSubj']),
            ':title' => htmlentities($_POST['titleSubj']),
            ':category' => $_POST['category'],
            ':subjectId' => $_GET['id']
        ]);
        
        header("Location: ../index.php");
        exit();

        //Ici messages d'erreurs fait en JS
    }
}