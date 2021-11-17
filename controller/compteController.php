<?php
    session_start();

    // On inclue les class Controller et Database pour utiliser leurs méthodes
    require_once '../model/Database.php';
    require_once 'Controller.php';
    $db = new Database();
    $control = new Controller();

    // Récupération d'un compte.
    $query = 'SELECT id, firstname, lastname, pseudo, email
    FROM authors
    WHERE id = :id';
    $donnees = $db->findOne($query, [':id' => $_GET['id']]);

// On vérifie que le user a bien le droit d'aller sur la page du compte
if (!empty($_SESSION) and array_key_exists('user', $_SESSION) and $_SESSION['user']['pseudo']==$donnees["pseudo"])
{
    if(empty($_POST))
    {
        $template = '../view/compteView';
        include '../view/layoutView.phtml';
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            header('Location: ../index.php');
            exit();
        }
    }
    
    else
    {
        // Vérifier si l'email existe déjà en bdd
        $query =
        'SELECT id, firstname, lastname, pseudo, birth_date, email, password
        FROM authors
        WHERE email = :email';
        $user = $db->findOne($query, [
            ':email' => $_POST['email']
        ]);
        if($_SESSION['user']['email']==$_POST["email"])
        {
            
        }  
        // Si il y a déjà un email dans la bdd 
        elseif(!empty($user))
        {
            $error = "Il y a déjà un compte associé à cette adresse email";
            $template = '../view/compteView';
            include '../view/layoutView.phtml';
            return $error;
        }

        // Vérifier si le pseudo existe déjà en bdd
        $query =
        'SELECT id, firstname, lastname, pseudo, birth_date, email, password
        FROM authors
        WHERE pseudo = :pseudo';

        $user1 = $db->findOne($query, [
            ':pseudo' => $_POST['pseudo']
        ]);
        if($_SESSION['user']['pseudo']==$_POST["pseudo"])
        {
            
        }  
        //Si il y a déjà ce pseudo dans la bdd  
        elseif(!empty($user1))
        {
            $error1 = "Il y a déjà un compte associé à ce pseudo";
            $template = '../view/compteView';
            include '../view/layoutView.phtml';
            return $error1;
        }

        //Vérif  de l'envoi de l'utilisateur
        $mailcontrol = $control->mailControl($_POST['email']);
        $pseudocontrol = $control->htmlControl($_POST['pseudo']);
        $prenomcontrol = $control->htmlControlForm($_POST['first_name']);
        $nomcontrol = $control->htmlControlForm($_POST['last_name']);

        if($mailcontrol != 3 && $mailcontrol != false && $pseudocontrol != 2 && $pseudocontrol != false &&  $prenomcontrol != 1 && $nomcontrol != 1 && $prenomcontrol != false && $nomcontrol != false)
        {
            // Edition d'un compte.
            $query ='UPDATE authors
            SET firstname = :first_name,
            lastname = :last_name,
            pseudo = :pseudo,
            email = :email           
            WHERE id = :userId';

            // On instencie la class Controller pour vérifier ce que rentre l'utilsateur
            $db->executeSql($query, [
                ':first_name' =>$control->htmlControlForm($_POST['first_name']),
                ':last_name' => $control->htmlControlForm($_POST['last_name']),
                ':pseudo' =>  $control->htmlControl($_POST['pseudo']),
                ':email' =>  $control->mailControl($_POST['email']),
                ':userId' => $_POST['userId']
            ]);

         
            $_SESSION['user']['firstname'] = $prenomcontrol;
            $_SESSION['user']['lastname'] = $nomcontrol;
            $_SESSION['user']['pseudo'] = $pseudocontrol;
            $_SESSION['user']['email'] =  $mailcontrol;

            $header= $_SESSION['user']['id'];
            header("Location: compteController.php?id=$header");
            exit;
        }

        // Si la vérif de l'envoi de l'utilisateur est fausse: insertion des messages d'erreurs
        else
        {
            if($mailcontrol == false)
            $er_mail = "Le mail ne peut pas être vide";

            if($mailcontrol == 3)
            $er_mail1 = "Le mail n'est pas valide";

            if($pseudocontrol == false)
            $er_nom = "Le pseudo ne peut pas être vide";
       
            if($pseudocontrol == 2)
            $er_nom1 = "Ne pas utiliser de caractères spéciaux";
            
            if($prenomcontrol == false)
            $er_nomform = "Le prénom ne peut pas être vide";

            if($nomcontrol == false)
            $er_nomform2 = "Le nom ne peut pas être vide";

            if($prenomcontrol == 1)
            $er_nomform4 = "Ne pas utiliser de caractères spéciaux";

            if($nomcontrol == 1)
            $er_nomform5 = "Ne pas utiliser de caractères spéciaux";

            $template = '../view/compteView';
            include '../view/layoutView.phtml';
        }
    }    
} 
else
{
    header('Location: ../index.php');
}  