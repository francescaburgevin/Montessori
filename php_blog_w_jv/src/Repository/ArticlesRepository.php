<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/model/Articles.php";

class ArticlesRepository extends AbstractRepository
{
    /*
    * @return array[null]
    */
    public function findAll() : ?array
    {
        $query = "SELECT * FROM article; ";
        $class = "Article";
        return ($this->executeQuery($query, $class));
    }//end function findAll

    /*
    * @return one article
    */
    public function findOne(int $id)
    {
        $query = "SELECT * FROM article WHERE id = :id; ";
        $params = [ ":id" => $id];
        $class = "Article";
        return ($this->executeQuery($query, $class, $params));
    }//end function findOne
   
   /*
   * add article to database
   */
   public function add(Article $article)
   {
        $query = "INSERT INTO article(title, content, published_date, user_id, file_path_image) 
                VALUES(:title, :content, :published_date, :user_id, :file_path_image);" ;
        $params = [
            ":title"=>$article->getTitle(),
            ":content"=>$article->getContent(),
            ":published_date"=>$article->getPublishedDate(), 
            ":user_id"=>$article->getUserId(),
            ":file_path_image"=>$article->getImage()
            ];
        $class = "Article";
        
        $this->executeQuery($query, $class, $params);
        
        return true;
       
   }//end function addNewArticle
   
   public function findLast()
   {
        $query = "SELECT * FROM article ORDER BY id DESC LIMIT 1;" ;
        $class = "Article";
        return ($this->executeQuery($query, $class));
   }
   
   public function insertArticleCategories(Article $article, Category $category)
   {
        $query = "INSERT INTO article_category(article_id, category_id) VALUES(:article_id, :category_id);" ;
        $params = [
            ":article_id"=>$article->getId(),
            ":category_id"=>$category->getId()
            ];
        $class = "Article";
        return ($this->executeQuery($query, $class, $params));
   }
   
   public function joinArticleCategory($article, $category)
   {
        $query = "
            SELECT * FROM article ORDER BY id DESC LIMIT 1;
            INSERT INTO article_category(article_id, category_id) VALUES(:article_id, :category_id);
            SELECT * FROM category;
            SELECT * FROM category WHERE id = :id;
            ";
            
        $params = [
            ":article_id" => $article,
            ":category_id" => $category,
            ":id" => $id
            ];
        $class = "Category";
        return ($this->executeQuery($query, $class));
    }//end function joinArticleCategory
    
    
    /*
   * delete article in database
   */
   public function delete(Article $article)
   {
        $query = "DELETE FROM article WHERE user_id = :user_id ;";
        $params = [
            ":user_id"=>$article->getUserId(),
            ];
        $class = "Article";
        
        $this->executeQuery($query, $class, $params);
        
        return true;
       
   }//end function delete

    public function deleteArtCat(Article $article)
    {
        $query = "DELETE FROM article_category WHERE user_id = :user_id ;";
        $params = [
            ":user_id"=>$article->getUserId(),
            ];
        $class = "Article";
        
        $this->executeQuery($query, $class, $params);
        
        return true;
       
    }

}

