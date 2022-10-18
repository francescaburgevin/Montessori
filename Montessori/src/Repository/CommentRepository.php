<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Comment.php";


class CommentRepository extends AbstractRepository
{
    /*  add
     *  @params Comment $comment
     *  @return boolean
     */
    public function add(Comment $comment)
    {
        $query = "INSERT INTO comment(content, edit_date, publish_date, fk_user_id, fk_class_feed_id, fk_comment_id) 
                  VALUES(:content, :edit_date, :publish_date, :fk_user_id, :fk_class_feed_id, :fk_comment_id);" ;
        
        $params = [
            ":content"=>$comment->getContent(),
            ":publish_date"=>$comment->getPublishDate(),
            ":edit_date"=>$comment->getEditDate(),
            ":fk_user_id"=>$comment->getUserId(),
            ":fk_class_feed_id"=>$comment->getClassFeedId(),
            ":fk_comment_id"=>$comment->getParentCommentId()
            ];
        $class = "Comment";
    
        $this->executeQuery($query, $class, $params);
        
        return true;
    }
    
    /*  getById
     *  @params int $id
     *  @return Comment
     */
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
    
    /*  getCommentsOfFeed (return all parent comments of feed )
     *  @params int $id
     *  @return Comment[]
     */
    public function getCommentsOfFeed(int $id)
    {
        $sql = "SELECT * 
                 FROM comment 
                 WHERE fk_class_feed_id = :id AND fk_comment_id IS NULL; ";
                 
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
    
    /*  getChildByParent (return all child comments of parent comment)
     *  @params int $id
     *  @return Comment[]
     */
    public function getChildByParent(int $id)
    {
        $sql = "SELECT * FROM comment WHERE fk_comment_id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        //recuperate info, transform object to array of objects
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
 
    /*  updatePublish
     *  @params Comment $comment
     *  @return  
     */
    public function updatePublish(Comment $comment)
    {
        $query = "UPDATE comment
                  SET publish_date = :publish_date
                  WHERE id = :id ;";
        $params = 
            [
                ":id"=>$comment->getId(),
                ":publish_date"=>$comment->getPublishDate()
            ];
        
        $this->executeQuery($query, "Comment", $params);
    }      
   
    /*  deleteComments
     *  @params int $id
     */
    public function deleteComments(int $id)
    {
        $query = "DELETE FROM comment 
                  WHERE fk_class_feed_id = :id; ";
        $class = "Comment";
        $params = 
            [
                ":id"=>$id
            ];
        
        $this->executeQuery($query, $class, $params);
    }
    
}