<?php
session_start();
use App\Autoloader;
use App\Classes\DetailPost;

require_once '../Autoloader.php';
Autoloader::register();


// Validation de la query string dans l'URL.
if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
{
    header('Location: ../index.php');
    exit();
}

    // On inclue les class DetailPost pour utiliser ses méthodes
    
    $comment = new DetailPost();

    $donnees = $comment->showOnePost();

    $donnees2 = $comment->showComment();
   
    // Ajout d'un Commentaire 

    if (empty($_POST)) 
    {
        $template = '../view/commentView';
        include '../view/layoutView.phtml';
    }
    else 
    {
    //Vérif  de l'envoi de l'utilisateur
        $commentcontrol = $comment->addComment();

        if($commentcontrol==false){
        
            $er_nomform1 = "Le commentaire ne peut pas être vide";

            $template = '../view/commentView';
            include '../view/layoutView.phtml';
        }
        else{
            $header= $_GET['id'];
            header("Location: commentController.php?id=$header");
            exit();
        }
    } 
       

