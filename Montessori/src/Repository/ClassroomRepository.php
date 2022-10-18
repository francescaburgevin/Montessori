<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Classroom.php";


class ClassroomRepository extends AbstractRepository
{
    /* getAll
     * @return Classroom[]
     */        
    public function getAll()
    {
        $query = "SELECT * FROM classroom; ";
        $class = "Classroom";
        $params = [];
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* getById
     * @params int $id
     * @return Classroom
     */     
    public function getById(int $id)
    {
        $query = "SELECT * FROM classroom WHERE id = :id; ";
        $class = "Classroom";
        $params = [ ":id"=>$id ];
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* getClassByUser
     * @params int $id
     * @return Classroom
     */ 
    public function getClassByUser(int $id)
    {
        $sql = "SELECT classroom.* 
                 FROM classroom
                 INNER JOIN faculty_class 
                 ON classroom.id = faculty_class.pk_classroom_id 
                 WHERE faculty_class.pk_user_id = :id; ";
                 
        $class = "Classroom";
        $params = [ ":id"=>$id ];
        
        //recuperate info, transform array to object
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        return ($query->fetchAll());
    }
    
    
    public function confirmUserClass($classroomId, $userId)
    {
        $query = "SELECT *
                 FROM faculty_class
                 WHERE pk_user_id = :pk_user_id AND pk_classroom_id = :pk_classroom_id; ";
                 
        $class = "Classroom";
        $params = [ 
            ":pk_user_id"=>$userId,
            ":pk_classroom_id"=>$classroomId
        ];
        
        $request = $this->executeQuery($query, $class, $params);
        
        if($request)
        { 
            return true;
            
        } else {
            return false;
        }
    }

}