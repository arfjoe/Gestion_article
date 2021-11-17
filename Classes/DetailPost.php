<?php
namespace App\Classes;
/* use App\Traits\Controller; */

/* use App\Classes\Database; */

class DetailPost{

    /* use Controller; */
    protected $bdd;
    protected $control;

    public function __construct()
    {
        $this->bdd = new Database();
        $this->control = new Controller();
    }

    public function showOnePost(){

        // Récupération d'article'
        $query = 'SELECT posts.id, title, content, name, DATE_FORMAT(posts.created_at, \'%W %e %M %Y à %Hh%imin%ss\') AS created_at_fr, firstname, lastname  
        FROM posts
        INNER JOIN categories ON categories.id = posts.category_id
        INNER JOIN authors ON authors.id = posts.author_id
        WHERE posts.id = :id';

        $post = [':id' => $_GET['id']];

        return  $this->bdd->findOne($query,$post);
    }

    public function showComment(){

        // Récupération des commentaires
        $query1 = 'SELECT id, content, nickname, DATE_FORMAT(created_at, \'%d/%m/%Y à %Hh%imin%ss\') AS created_at_com, post_id
        FROM comments
        WHERE post_id = :id 
        ORDER BY created_at_com DESC
        LIMIT 10';

        $comment = [':id' => $_GET['id']];
        
        return $this->bdd->findAll($query1,$comment);
    }

    public function addComment(){
        $subjectId = $_GET['id'];
        //Insertion d'un commentaire sur le sujet en question
        //Vérif  de l'envoi de l'utilisateur
    $commentcontrol = $this->control->htmlControlForm($_POST['content']);

    if($commentcontrol != false)
    {
        $query =
        'INSERT INTO
                comments
                (content, nickname, created_at, post_id)
        VALUES
            (:content, :nickname, NOW(), :post_id)';

        // On instencie la class Controller pour vérifier ce que rentre l'utilsateur
        $posts =[
            ':content' => $this->control->htmlControlForm($_POST['content']),
            ':nickname' =>$_SESSION['user']['pseudo'],
            ':post_id' => $subjectId
        ];

        return $this->bdd->executeSql($query,$posts);
        }

        // Si la vérif de l'envoi de l'utilisateur est false: insertion des messages d'erreurs
        else
        {
             return $commentcontrol;
        }
    } 
}
