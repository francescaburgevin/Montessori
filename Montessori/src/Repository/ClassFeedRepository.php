<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/ClassFeed.php";
require_once dirname(__DIR__, 2) . "/src/Model/Comment.php";

class ClassFeedRepository extends AbstractRepository
{
    /* findOne
     * @params int $id
     * @return ClassFeed
     */
    public function findOne(int $id)
    {
        $query = "SELECT * FROM class_feed WHERE id = :id; ";
        $params = [ ":id" => $id];
        $class = "ClassFeed";
        return ($this->executeQuery($query, $class, $params));
    }

    /* findLast
     * @return ClassFeed
     */
    public function findLast()
    {
        $query = "SELECT class_feed.id 
                  FROM class_feed 
                  ORDER BY id DESC LIMIT 1;" ;
        $class = "ClassFeed";
        return ($this->executeQuery($query, $class));
    }
    
    /* add
     * @params ClassFeed $feed
     * @return boolean
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
       
    }
   
    /* update
     * @params ClassFeed $feed
     * @return boolean
     */       
    public function update(ClassFeed $feed)
    {
        $query = "UPDATE class_feed 
                  SET  
                    edit_date = :edit_date, 
                    publish_date = :publish_date,
                    file_path_image = :file_path_image,
                    image_description = :image_description,
                    content = :content 
                  WHERE id = :id ;";
        $params = [
            ":id"=>$feed->getId(),
            ":edit_date"=>$feed->getEditDate(),
            ":publish_date"=>$feed->getPublishDate(),
            ":file_path_image"=>$feed->getFilePathImage(),
            ":image_description"=>$feed->getImageDescription(),
            ":content"=>$feed->getContent()
        ];
        
        return $this->executeQuery($query, "ClassFeed", $params);
    }
     
    /* delete
     * @params ClassFeed $feed
     * @return boolean
     */    
    public function delete(ClassFeed $feed)
    {
        $query = "DELETE FROM class_feed WHERE id = :id ;";
        $params = [ ":id"=>$feed->getId() ];
        $class = "ClassFeed";
        $this->executeQuery($query, $class, $params);
        return true;
    }
    
    /* getStudentFeeds (published feeds concerning student and student's classroom)
     * @params int $studentId
     * @params int $classroomId
     * @return ClassFeed
     */   
    public function getStudentFeeds(int $studentId, int $classroomId)
    {
        $query = "SELECT class_feed.id, class_feed.edit_date, class_feed.publish_date, 
                  class_feed.file_path_image, class_feed.image_description, class_feed.content, 
                  class_feed.fk_classroom_id 
                 FROM class_feed 
                 INNER JOIN student_class_feed 
                     ON class_feed.id = student_class_feed.pk_class_feed_id 
                     WHERE student_class_feed.pk_student_id = :studentId
                     OR student_class_feed.pk_student_id = :classroomId
                     AND class_feed.publish_date IS NOT NULL
                 ORDER BY class_feed.publish_date DESC ; ";
                 
        $class = "ClassFeed";
        
        $params = 
            [
                ":studentId"=>$studentId,
                ":classroomId"=>$classroomId
            ];

        return ($this->executeQuery($query, $class, $params));
    }
    
    /* getStudentsInFeed (full listing of students in a feed)
     * @params int $id
     * @return student list
     */  
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
    
    /* getFeedByClassId (all published feeds of one classroom)
     * @params int $id
     * @return ClassFeed
     */      
    public function getFeedByClassId(int $id)
    {
        $query = "SELECT *
                 FROM class_feed 
                 WHERE fk_classroom_id = :id
                 ORDER BY class_feed.publish_date DESC ; ";
                 
        $class = "ClassFeed";
        
        $params = 
            [
                ":id"=>$id
            ];

        return ($this->executeQuery($query, $class, $params));
    }
    
    /* insertStudentFeed (update student_class_feed table)
     * @params int $classFeed
     * @params int $student
     * @return ClassFeed
     */
    public function insertStudentFeed(int $classFeed, int $student)
    {
        $query = "INSERT INTO student_class_feed(pk_student_id, pk_class_feed_id) 
                  VALUES(:student_id, :class_feed_id);" ;
        $params = [
            ":student_id"=>$student,
            ":class_feed_id"=>$classFeed
            ];
        $class = "ClassFeed";
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* deleteStudentFeed (update student_class_feed table)
     * @params int $classFeed
     * @params int $student
     * @return ClassFeed
     */
    public function deleteStudentFeed(int $classFeed, int $student)
    {
        $query = "DELETE FROM student_class_feed
                  WHERE pk_class_feed_id = :class_feed_id 
                  AND pk_student_id = :student_id ;" ;
        $params = [
            ":student_id"=>$student,
            ":class_feed_id"=>$classFeed
            ];
        $class = "ClassFeed";
        return ($this->executeQuery($query, $class, $params));
    }
    
}
    