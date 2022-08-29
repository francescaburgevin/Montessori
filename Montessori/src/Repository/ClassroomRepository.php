<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Classroom.php";


class ClassroomRepository extends AbstractRepository
{
    
    
     public function getById(int $id)
    {
        $query = "SELECT * FROM classroom WHERE id = :id; ";
        $class = "Classroom";
        $params = 
            [
                ":id"=>$id
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
      public function getClassByUser(int $id)
    {
        
        $sql = "SELECT classroom.* 
                 FROM classroom
                 INNER JOIN faculty_class 
                 ON classroom.id = faculty_class.pk_classroom_id 
                 WHERE faculty_class.pk_user_id = :id; ";
                 
        $class = "Classroom";
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

