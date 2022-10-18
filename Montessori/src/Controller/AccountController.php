<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassroomRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";

class AccountController extends AbstractController
{
    /*   parent
     *   @return string => template + user's children + user information
     */
    public function parent(): string
    {
        if($_SESSION['user_role']!=="parent")
        {
            header("Location: ?page=user_connection");  
        }
        
        $studentRepository = new StudentRepository();
        $children = $studentRepository->getByParentId($_SESSION['user_id']);   
        
        $user = new UserRepository();
        $user = $user->retrieve($_SESSION['user_id']);

        foreach($children as $key=>$child)
        {
            $classroomRepository = new ClassroomRepository();
            $child->setClassroom($classroomRepository->getById($child->getClassroomId()));
        }
      
        return $this->renderView("/template/account/account_parent.phtml", [
        "children" => $children,
        "user" => $user
        ]);
    }

    /*   faculty
     *   @return string => template + user's classroom(s)
     */
    public function faculty(): string
    {
        if($_SESSION['user_role']!=="faculty")
        {
            header("Location: ?page=user_connection");  
        }
        
        $userId = $_SESSION['user_id'];
        $classroomRepository = new ClassroomRepository();
        $classes = $classroomRepository->getClassByUser($userId);
        
        return $this->renderView("/template/account/account_faculty.phtml", [
                "classes" => $classes
                ]);
    }
    
    /*   admin
     *   @return string => template + all classrooms + full student listing
     */
    public function admin(): string
    {
        if($_SESSION['user_role']!=="admin")
        {
            header("Location: ?page=user_connection");  
        }
        
        if($_SESSION['user_role']==="admin")
        {
            $classroomRepository = new ClassroomRepository();
            $classes = $classroomRepository->getAll();
            
            $studentRepository = new StudentRepository();
            $studentList = $studentRepository->getAll();
            foreach($studentList as $key => $value)
            {
                if($value->getFirstname()=="Ambiance"||$value->getFirstname()=="ambiance")
                {
                    unset($studentList[$key]);
                }
            }
        }
        return $this->renderView("/template/account/account_administrator.phtml", [
                "classes" => $classes,
                "studentList" => $studentList
                ]);
    }

}