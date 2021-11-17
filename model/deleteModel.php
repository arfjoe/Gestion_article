<?php

// init session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!empty($_SESSION) and array_key_exists('user', $_SESSION) and $_SESSION['user']['admin']){
    // Validation de la query string dans l'URL.
/*     if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id'])
        AND !array_key_exists('table', $_GET) OR !ctype_alpha($_GET['table']))
    {
        header('Location: ../index.php');
        exit();
    } */
    
        /* die("article supprimé"); */
    
    
    // Dépendance : Connexion Bdd
    require_once 'Database.php';
    $bdd = new Database();
    
    $table = $_GET['table'];

    // Suppression d'un article du blog.
    try {
        $query =
        "DELETE FROM
                $table
            WHERE
                id = :id
        ";
        $ex = $bdd->executeSql($query, [
            ':id' => $_GET['id']
        ]);
    } catch (PDOException $e) {
        echo "Message d'erreur : $e->getMessage()";
    }
}

header('Location: ../index.php');
exit();