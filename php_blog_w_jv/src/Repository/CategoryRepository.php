<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/CategoryRepository.php";
//require_once dirname(__DIR__, 2) . "/src/Repository/ArticleRepository.php";
require_once dirname(__DIR__, 2) . "/src/model/Category.php";
//require_once dirname(__DIR__, 2) . "/src/model/Article.php";

class CategoryRepository extends AbstractRepository
{

    /*
    * @return array[null]
    */
    public function findByArticle($article)
    {
        $query = "
            SELECT id, name FROM category INNER JOIN article_category ON category.id = article_category.category_id WHERE article_category.article_id = 1 ;
            SELECT * FROM article WHERE id = :id;
            SELECT * FROM user WHERE id = :id ;
            ";
            
        $params = [":article_id" => $article];
        $class = "Category";
        return ($this->executeQuery($query, $class));
    }//end function joinCat
    
    /*
    * @return array[null]
    */
    public function findAll()
    {
        $query = "SELECT * FROM category; ";
        $class = "Category";
        return ($this->executeQuery($query, $class));
    }//end function findAll
    
    public function findCategory($key)
    {
        $query = "SELECT id FROM category WHERE id = :key; ";
        $params = [":key"=>$key];
        $class = "Category";
        return ($this->executeQuery($query, $class, $params));
        
    }

}




