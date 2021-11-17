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

$titlecontrol ='';
$subjectcontrol ='';
$category ='';


 //Affichage des catégories

 $query = 
 'SELECT id, name
 FROM categories
 ORDER BY id';

 $donnees3 = $bdd->findAll($query,[]);


    // Ajout d'un Article du Blog.
    if (empty($_POST)) 
    {
        $template = '../view/addArticleView';
        include '../view/layoutView.phtml';
    }
    else 
    {

    $userId = $_SESSION['user']['id'];

    //Vérif  de l'envoi de l'admin
    $category = $_POST['category'];
    $titlecontrol = $control->htmlControlForm($_POST['title']);
    $subjectcontrol = $control->htmlControlForm($_POST['content']);

    // Vérifier si l'id category existe en bdd
    $query =
    'SELECT id
    FROM categories
    WHERE id = :category_id';
     $id = $bdd->findOne($query, [
         ':category_id' => $category
     ]);
     if(empty($id))
      {
          $error_id = "Il n'y a pas d'identifiant associé à cette catégorie";
          $template = '../view/addArticleView';
          include '../view/layoutView.phtml';
          return $error_id;        
      }

        if($titlecontrol != false && $titlecontrol != 1 && $subjectcontrol != false && $subjectcontrol != 1)
        {

            //Insertion d'un nouveau sujet
            $query =
                'INSERT INTO
                        posts
                        (title, content, created_at, author_id, category_id)
                VALUES
                    (:title, :content, NOW(), :author_id, :category_id)';

                // On instencie la class Controller pour vérifier ce que rentre l'admin
                $bdd->executeSql($query, [
                    ':title' => $control->htmlControlForm($_POST['title']),
                    ':content' => $control->htmlControlForm($_POST['content']),
                    ':author_id' => $userId,
                    ':category_id' => $category
                ]);

        header('Location: ../index.php');
        exit();
        }

        // Si la vérif de l'envoi de l'admin est fausse: insertion des messages d'erreurs
        else
        {
            if($titlecontrol == false)
            $er_nomform1 = "Le titre ne peut pas être vide";
        
            if($titlecontrol == 1)
            $er_nomform = "Ne pas utiliser de caractères spéciaux";

            if($subjectcontrol == false)
            $er_nomform2 = "Le sujet ne peut pas être vide";
        
            if($subjectcontrol == 1)
            $er_nomform3 = "Ne pas utiliser de caractères spéciaux";

            $template = '../view/addArticleView';
            include '../view/layoutView.phtml';
        }
    }
}
else 
{
    header('Location: ../index.php');
}