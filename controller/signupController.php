<?php

session_start();

$prenomcontrol = '';
$nomcontrol = '';

if(!empty($_SESSION)){
    header('Location: ../index.php');
     exit();
}

if (empty($_POST)) 
{
    $template = '../view/signupView';
    include '../view/layoutView.phtml';
} 
else 
{   
    // On inclue les class Controller et Database pour utiliser leurs méthodes
    require_once '../model/Database.php';
    require_once 'Controller.php';
    $db = new Database();
    $control = new Controller();

    // Vérifier si l'email existe déjà en bdd
    $query =
    'SELECT id, email
    FROM authors
    WHERE email = :email';
    $user = $db->findOne($query, [
        ':email' => $_POST['email']
    ]);

    // Si il y a déjà un email dans la bdd
    if(!empty($user))
    {
        $error = "Il y a déjà un compte associé à cette adresse email";
        $template = '../view/signupView';
        include '../view/layoutView.phtml';
        return $error;
    }

     // Vérifier si le pseudo existe déjà en bdd
     $query =
     'SELECT id, firstname, lastname, pseudo, email, password
     FROM authors
     WHERE pseudo = :pseudo';

    $user1 = $db->findOne($query, [
        ':pseudo' => $_POST['pseudo']
    ]);

    //Si il y a déjà ce pseudo dans la bdd
    if(!empty($user1))
    {
        $error1 = "Il y a déjà un compte associé à ce pseudo";
        $template = '../view/signupView';
        include '../view/layoutView.phtml';
        return $error1;
    }

    //Vérif  de l'envoi de l'utilisateur
    $passcontrol = $control->passwordControl($_POST['password']);
    $mailcontrol = $control->mailControl($_POST['email']);
    $pseudocontrol = $control->htmlControl($_POST['pseudo']);
    $prenomcontrol = $control->htmlControlForm($_POST['first_name']);
    $nomcontrol = $control->htmlControlForm($_POST['last_name']);
    
    if($passcontrol != false && $mailcontrol != 3 && $mailcontrol != false && $pseudocontrol != 2 && $pseudocontrol != false && $prenomcontrol != 1 && $nomcontrol != 1 && $prenomcontrol != false && $nomcontrol != false)
    {

    //Insertion d'un Utilsateur dans la bdd
    $query =
        'INSERT INTO
			authors
			(firstname, lastname, pseudo, email, password, is_admin, created_at)
		VALUES
			(:first_name, :last_name, :pseudo, :email, :password, 0, NOW())
        ';
    // On instencie la class Controller pour vérifier ce que rentre l'utilsateur
    $db->executeSql($query, [
        ':first_name' => $control->htmlControlForm($_POST['first_name']),
        ':last_name' => $control->htmlControlForm($_POST['last_name']),
        ':pseudo' => $control->htmlControl($_POST['pseudo']),
        ':email' => $control->mailControl($_POST['email']),
        ':password' => $control->passwordControl($_POST['password'])
    ]);
        header('Location: loginController.php');
        exit();
    }

    // Si la vérif de l'envoi de l'utilisateur est fausse: insertion des messages d'erreurs
    else
    {
        if($passcontrol == false)
        $er_mdp = "Mot de passe trop court: 6 caractères minimum";

        if($mailcontrol == false)
         $er_mail = "Le mail ne peut pas être vide";

        if($mailcontrol == 3)
        $er_mail1 = "Le mail n'est pas valide";

        if($pseudocontrol == false)
        $er_nom = "Le pseudo ne peut pas être vide";

        if($pseudocontrol == 2)
        $er_nom1 = "Rentrer un pseudo correct";
      
        if($prenomcontrol == false)
        $er_nomform = "Le prénom ne peut pas être vide";

        if($nomcontrol == false)
        $er_nomform2 = "Le nom ne peut pas être vide";

        if($prenomcontrol == 1)
        $er_nomform4 = "Ne pas utiliser de caractères spéciaux";

        if($nomcontrol == 1)
        $er_nomform5 = "Ne pas utiliser de caractères spéciaux";

        $template = '../view/signupView';
        include '../view/layoutView.phtml';
    }
}

