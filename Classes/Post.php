<?php 
namespace App\Classes;
/* use App\Classes\Database; */

class Post {

    protected $bdd;

    public function __construct()
    {
        $this->bdd = new Database();
    }

    public function showPost($query){

        $donnees2 = $this->bdd->findAll($query);
        return $donnees2;
    }

    public function addPost($query,array $posts){
        $this->bdd->executeSql($query,$posts);
    } 
}