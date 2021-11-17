<?php
    session_start();

    // On inclue les class Controller et Database pour utiliser leurs méthodes
    require_once '../model/Database.php';
    require_once 'Controller.php';
    $control = new Controller();
    $bdd = new Database();
    
    if(empty($_POST))
    {
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            header('Location: commentController.php');
            exit();
        }
    
        // Récupération d'un commentaire.
        $query = 'SELECT posts.id, comments.id, comments.content, comments.created_at, post_id, author_id, category_id, nickname
        FROM posts
        INNER JOIN authors ON posts.author_id = authors.id
        INNER JOIN comments ON comments.post_id = posts.id
        WHERE comments.id = :id';
        $donnees = $bdd->findOne($query, [':id' => $_GET['id']]);
    }
    /* $control->dd($donnees["id"]); */
    // On vérifie que le user a bien le droit d'aller sur la page de SON commentaire
    if (!empty($_SESSION) and array_key_exists('user', $_SESSION) and $_SESSION['user']['pseudo']==$donnees["nickname"])
    {
        $template = '../view/editCommentView';
        include '../view/layoutView.phtml';
    }    
    else
    {
       
        // Edition d'un commentaire.
        $query ='UPDATE comments
        SET content = :content,
            created_at = NOW()
        WHERE id = :commentId';

        // On instencie la class Controller pour vérifier ce que rentre l'utilsateur
        $bdd->executeSql($query, [
            ':content' =>  htmlentities($_POST['editcomcontent']),
            ':commentId' => $_GET['id']
        ]);

        header("Location: ../index.php");
        exit();

        //Ici messages d'erreurs fait en JS
    }