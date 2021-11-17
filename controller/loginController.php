<?php
session_start();
$email='';
if(!empty($_SESSION)){
    header('Location: ../index.php');
     exit();
}

 if (empty($_POST)) 
 {
    $template = '../view/loginView';
    include '../view/layoutView.phtml';
 } 
 else 
 {
    $email=$_POST['email'];
    // On inclue la Database pour utiliser ses méthodes
     require_once '../model/Database.php';
     $db = new Database();

     // Vérifier si l'email existe déjà en bdd
     $query =
    'SELECT id, firstname, lastname, pseudo, email, password, is_admin
    FROM authors
    WHERE email = :email';
     $user = $db->findOne($query, [
         ':email' => $_POST['email']
     ]);

      // Est-ce qu'on a bien trouvé un utilisateur ?
      if(empty($user))
      {
        $error = "Il n'y a pas de compte associé à cette adresse email";
        $template = '../view/loginView';
        include '../view/layoutView.phtml';
        return $error;        
      }
  
      // Est-ce que le mot de passe spécifié est correct par rapport à celui stocké ?
      if(!password_verify($_POST['password'], $user['password']))
      {
        $error1 = 'Le mot de passe spécifié est incorrect';
        $template = '../view/loginView';
        include '../view/layoutView.phtml';
        return $error1;
      }

     // Création de la session
     if(session_status() == PHP_SESSION_NONE)
     {
         session_start();
     }
 
     $_SESSION['user'] = [];
 
     $_SESSION['user']['id'] = $user['id'];
     $_SESSION['user']['firstname'] = $user['firstname'];
     $_SESSION['user']['lastname'] = $user['lastname'];
     $_SESSION['user']['pseudo'] = $user['pseudo'];
     $_SESSION['user']['email'] = $user['email'];
     $_SESSION['user']['admin'] = $user['is_admin'] ?? 0;
 
     header('Location: ../index.php');
     exit();
 }
 

