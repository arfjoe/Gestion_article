<?php
// Validation de la query string dans l'URL.
if (array_key_exists('id', $_GET) or ctype_digit($_GET['id'])) {
    // Détruire la session qui contient les infos user
    // On la récupère
    session_start();
	session_destroy();
}

header('Location: ../index.php');
exit();