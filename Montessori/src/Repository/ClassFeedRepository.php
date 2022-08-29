<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/ClassFeed.php";
require_once dirname(__DIR__, 2) . "/src/Model/Comment.php";

class ClassFeedRepository extends AbstractRepository
{
    
    
        /*
    * @return one feed
    */
    public function findOne(int $id)
    {
        $query = "SELECT * FROM class_feed WHERE id = :id; ";
        $params = [ ":id" => $id];
        $class = "ClassFeed";
        return ($this->executeQuery($query, $class, $params));
    }//end function findOne
   
   

    // get all feeds by student id
    
    public function getFeedByStudent(int $id)
    {
        $query = "SELECT class_feed.id, class_feed.edit_date, class_feed.publish_date, class_feed.file_path_image, class_feed.image_description, class_feed.content, class_feed.fk_classroom_id 
                 FROM class_feed 
                 INNER JOIN student_class_feed 
                 ON class_feed.id = student_class_feed.pk_class_feed_id 
                 WHERE student_class_feed.pk_student_id = :id
                 AND class_feed.publish_date IS NOT NULL
                 ORDER BY class_feed.publish_date DESC ; ";
                 
        $class = "ClassFeed";
        
        $params = 
            [
                ":id"=>$id
            ];

        return ($this->executeQuery($query, $class, $params));
    }
    
    public function getStudentsInFeed(int $id)
    {
        $query = "SELECT pk_student_id
                 FROM student_class_feed
                 WHERE student_class_feed.pk_class_feed_id = :id";
                 
        $class = "ClassFeed";
        
        $params =
            [
                ":id"=>$id
            ];
        return ($this->executeQuery($query, $class, $params));
    }
    
    
     public function getFeedByClassId(int $id)
    {
        $query = "SELECT *
                 FROM class_feed 
                 WHERE fk_classroom_id = :id
                 AND class_feed.publish_date IS NOT NULL
                 ORDER BY class_feed.publish_date DESC ; ";
                 
        $class = "ClassFeed";
        
        $params = 
            [
                ":id"=>$id
            ];

        return ($this->executeQuery($query, $class, $params));
    }
    
    
       /*
   * add feed to database
   */
   public function add(ClassFeed $feed)
   {
        $query = "INSERT INTO class_feed(edit_date, publish_date, file_path_image, image_description, content, fk_classroom_id) 
                VALUES(:edit_date, :publish_date, :file_path_image, :image_description, :content, :fk_classroom_id);" ;
        $params = [
            ":edit_date"=>$feed->getEditDate(),
            ":publish_date"=>$feed->getPublishDate(), 
            ":file_path_image"=>$feed->getFilePathImage(),
            ":image_description"=>$feed->getImageDescription(),
            ":content"=>$feed->getContent(),
            ":fk_classroom_id"=>$feed->getClassroomId()
            ];
        $class = "ClassFeed";
        
        $this->executeQuery($query, $class, $params);
        
        return true;
       
   }//end function add
   
       
    /*
   * delete feed in database
   */
   public function delete(ClassFeed $feed)
   {
        $query = "DELETE FROM class_feed WHERE id = :id ;";
        $params = [
            ":id"=>$feed->getId(),
            ];
        $class = "ClassFeed";
        
        $this->executeQuery($query, $class, $params);
        
        return true;
       
   }//end function delete
   
   
   /*
   * @params ClassFeed $feed
   */
   
   public function update(ClassFeed $feed){
       
        $query = "UPDATE class_feed 
                  SET  
                    edit_date = :edit_date, 
                    publish_date = :publish_date,
                    file_path_image = :file_path_image,
                    image_description = :image_description,
                    content = :content, 
                  WHERE id = :id;";
        $params = [
            ":id"=>$feed->getId(),
            ":edit_date"=>$feed->getEditDate(),
            ":publish_date"=>$feed->getPublishDate(),
            ":file_path_image"=>$feed->getFilePathImage(),
            ":image_description"=>$feed->getImageDescription(),
            ":content"=>$feed->getContent()
        ];
        return $this->executeQuery($query, "ClassFeed", $params);
    }// end function update
   
   
}
    