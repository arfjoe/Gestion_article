<?php

namespace App\Classes;

//Class pour contrôler ce que rentre l'utilisateur
class Controller
{

    //Méthode pour vérifier si la date de naissance est dans le bon format
    public function birthDate($value1)
    {
        if (!empty($value1))
        { 
            if(isset($value1))
            {
                //Ici on convertie le format entré(Français) en format de la bdd (Américains)
                $date = implode('-',array_reverse  (explode('/',$value1)));
                return $date;
            }
        }
        else
        {
            return false;
        }
    }

    //Méthode de contrôle
    public function htmlControlForm($value)
    {
        if (empty($value)) 
        {   
            return false;
        }
        else
        {
            $post = htmlentities($value);
            return $post;
        }
    }

    //Méthode de vérif pour l'édition de commentaire et sujet qui utilise déjà du JS 
    public function htmlControlEdit($value)
    {
        if (!preg_match('/^[^&"_$*<>€£`+=\/#]+$/', $value))
        { 
            return false;               
        }
        else
        {
            $post = htmlentities($value);
            return $post;
        }  
    }

    //Méthode pour vérifier si l'adresse mail est dans le bon format
    public function mailControl($value2)
    {
        if (empty($value2)) 
        {
            return false;
        }
        else 
        {
            // On vérifit que le mail est dans le bon format
            if (!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $value2)) 
            {
                $oups3=3;
                return $oups3;
            }
            else
            {
                $mail = htmlentities(strtolower(trim($value2)));
            }
            return $mail;
        } 
        
    }

    //Méthode pour vérifier et hasher le password
    public function passwordControl($value3)
    {
        // Contrôle de la longueur du password
        if (strlen($value3) < 6) 
        {
            return false;
        }
        else
        {
            // Hash du password
            $passwordHash = password_hash($value3, PASSWORD_DEFAULT);
            return $passwordHash;
        }
    }

        //Méthode Var_dump()

        // DD function
        public function dd($data) {
            echo "<pre style='
                font-size: 1.6rem; 
                padding: 1rem; 
                color: #333;
                background: HoneyDew'>";
            var_dump($data);
            echo "</pre>";
            die;
        }
}