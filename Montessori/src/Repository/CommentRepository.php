<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Comment.php";


class CommentRepository extends AbstractRepository
{
    
    //get one comment by comment id
    
     public function getById(int $id)
    {
        $query = "SELECT * FROM comment WHERE id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
        
    // get all comments (parent comment) of one class feed 
    
     public function getCommentsOfFeed(int $id)
    {
        $sql = "SELECT * 
                 FROM comment 
                 WHERE fk_class_feed_id = :id 
                 AND fk_comment_id IS NULL ; ";
                 
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
    

    
    // get a comment's (parent comment) comments (child comment)
        public function getChildByParent(int $id)
    {
        $query = "SELECT * FROM comment WHERE fk_comment_id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }


}


        

/*
     public function getCommentsOfFeed(int $id)
    {
        $query = "SELECT * 
                 FROM comment 
                 WHERE class_feed_id = :id 
                 AND parent_comment_id IS NULL ; ";
                 
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
    
        public function getChildByParent(int $id)
    {
        $query = "SELECT * FROM comment WHERE parent_comment_id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
        
        
            public function getChildByParent(int $id)
    {
        $sql = "SELECT * FROM comment WHERE parent_comment_id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
    }*/