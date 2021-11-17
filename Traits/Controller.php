<?php

namespace App\Traits;

//Class pour contrôler ce que rentre l'utilisateur
Trait Controller
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

    //Méthode strict pour limiter l'utilsateur dans l'ajout de caractères spéciaux
    public function htmlControl($value)
    {
        if (empty($value)) 
        {          
            return false;
        }
        else
        {
            if (!preg_match('/^[a-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\'A-Z0-9_]+$/', $value))
            {
                $oups2=2;
                return $oups2;
            }
            else
            {
                $valid = true;
                $post = htmlentities($value);
                return $post;
            }  
        }
    }

    //Méthode plus souple dans le limitation de l'utilisateurs dans l'ajout de caractères spéciaux
    public function htmlControlForm($value)
    {
        if (empty($value)) 
        {   
            return false;
        }
        else
        {
            if (!preg_match('/^[^&"_$*<>€£`+=\/#]+$/', $value))
            { 
                $oups=1;
                return $oups;               
            }
            else
            {
                $valid = true;
                $post = htmlentities($value);
                return $post;
            }  
        }
    }

    public function htmlControlForm1($value)
    {
        if (empty($value)) 
        {   
            return false;
        }
        else
        {
            if (!preg_match('/^[^&"_$*<>€£`+=\/#]+$/', $value))
            { 
                $oups=1;
                return $oups;               
            }
            else
            {
                $valid = true;
                $post = $value;
                return $post;
            }  
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
            $valid = true;
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
                $valid = true;
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
            $valid = true;
            return $passwordHash;
        }
    }

    public function setErrorNotification(String $key, String $message): void
    {
        $_SESSION['errors'][$key] = $message;
    }

    public function setSuccessNotification(String $key, String $message): void
    {
        $_SESSION['success'][$key] = $message;
    }

    private function getErrorNotification(String $key): string
    {
        $message = $_SESSION['errors'][$key];
        unset($_SESSION['errors'][$key]);
        return $message;
    }

    private function getSuccessNotification(String $key): string
    {
        $message = $_SESSION['success'][$key];
        unset($_SESSION['success'][$key]);
        return $message;
    }

    public function checkErrorsNotification(String $key): bool
    {
        if (!empty($_SESSION['errors'][$key])) {
            return true;
        }
        return false;
    }

    public function checkSuccessNotification(String $key): bool
    {
        if (!empty($_SESSION['success'][$key])) {
            return true;
        }
        return false;
    }

    public function getInvalidFeedback(String $key): string
    {
        $content = self::checkErrorsNotification($key) ? self::getErrorNotification($key) : '';
        return '<small class="text-danger">'.$content.'</small>';
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