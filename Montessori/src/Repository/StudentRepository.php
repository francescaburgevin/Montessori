<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Student.php";


class StudentRepository extends AbstractRepository
{
    
    
     public function getByParentId(int $id)
    {
        
        $sql = "SELECT student.* 
                 FROM student 
                 INNER JOIN parent_child 
                 ON student.id = parent_child.pk_student_id 
                 WHERE parent_child.pk_user_id = :id; ";
                 
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
    
    
    public function getStudentsByClassId(int $id)
    {
        
        $sql = "SELECT student.id, student.firstname, student.lastname, student.fk_classroom_id
                 FROM student 
                 WHERE student.fk_classroom_id = :id; ";
                 
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
    
    
    public function getStudentsInFeed(int $id)
    {
        $sql = "SELECT student.id 
                 FROM student 
                 INNER JOIN student_class_feed 
                 ON student.id = student_class_feed.pk_student_id 
                 WHERE student_class_feed.pk_class_feed_id = :id; ";
                 
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
    
}

