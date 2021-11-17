<?php
use App\Autoloader;
use App\Classes\Post;

require_once './Autoloader.php';
Autoloader::register();

$post = new Post();

/* $query1 =
'INSERT INTO
        posts
        (title, content, created_at, author_id, category_id)
VALUES
    (:title, :content, NOW(), :author_id, :category_id)';

$posts = [':title' => "Bou",
    ':content' =>'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quaerat hic magni, molestiae rem sint possimus ex, corrupti soluta quod placeat delectus necessitatibus ducimus accusamus. Cupiditate sapiente neque sit ut?', 
    ':author_id' => "2",
    ':category_id' => "2"]; */

/* $post->addPost($query1,$posts);   */  

$query = 
'SELECT posts.id, title, SUBSTRING(content, 1, 100) AS content, name, DATE_FORMAT(posts.created_at, \'%W %e %M %Y à %Hh%imin%ss\') AS created_at_fr, firstname, lastname  
    FROM posts
    INNER JOIN categories ON categories.id = posts.category_id
    INNER JOIN authors ON authors.id = posts.author_id
    ORDER BY created_at_fr DESC
    LIMIT 10';

$donnees = $post->showPost($query);

$template = 'view/indexView';
include 'view/layoutView.phtml';

//plop