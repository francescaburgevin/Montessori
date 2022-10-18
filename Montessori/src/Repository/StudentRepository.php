<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Student.php";

class StudentRepository extends AbstractRepository
{
    /* getAll
     * @return Student[]
     */     
    public function getAll()
    {
        $query = "SELECT * FROM student
                  ORDER BY lastname ASC; ";
        $class = "Student";
        $params = [];
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* getByParentId
     * @params int $id
     * @return Student[]
     */      
    public function getByParentId(int $id)
    {
        $sql = "SELECT student.* 
                 FROM student 
                 INNER JOIN parent_child 
                 ON student.id = parent_child.pk_student_id 
                 WHERE parent_child.pk_user_id = :id
                 ORDER BY lastname ASC ; ";
                 
        $class = "Student";
        $params = 
            [
                ":id"=>$id
            ];
        
        //recuperate info, transform array to object
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
    
    /* getStudentsByClassId
     * @params int $id
     * @return Student[]
     */      
    public function getStudentsByClassId(int $id)
    {
        $sql = "SELECT student.id, student.firstname, student.lastname, student.fk_classroom_id
                 FROM student 
                 WHERE student.fk_classroom_id = :id
                 ORDER BY lastname ASC; ";
                 
        $class = "Student";
        $params = 
            [
                ":id"=>$id
            ];
        
        //recuperate info, transform array to object
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
    
    /* getStudentById
     * @params int $id
     * @return Student
     */  
    public function getStudentById(int $id)
    {
        $query = "SELECT student.firstname, student.lastname, student.fk_classroom_id
                  FROM student 
                  WHERE student.id = :id; ";
                 
        $class = "Student";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* getStudentsInFeed
     * @params int $id
     * @return Student[]
     */      
    public function getStudentsInFeed(int $id)
    {
        $sql = "SELECT *
                 FROM student 
                 INNER JOIN student_class_feed 
                    ON student.id = student_class_feed.pk_student_id 
                    WHERE student_class_feed.pk_class_feed_id = :id; ";
                 
        $class = "Student";
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
    
    /* deleteStudents
     * @params int $id
     * @return Student[]
     */       
    public function deleteStudents(int $id)
    {
        $query = "DELETE FROM student_class_feed 
                  WHERE pk_class_feed_id = :id; ";
        $class = "Student";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
}