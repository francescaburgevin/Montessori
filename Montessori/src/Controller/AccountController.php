<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassroomRepository.php";

class AccountController extends AbstractController
{
    
    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function parent(): string
    {
        $studentRepository = new StudentRepository();
        $children = $studentRepository->getByParentId($_SESSION['user_id']);                       

        foreach($children as $key=>$child)
        {
            $classroomRepository = new ClassroomRepository();
            $child->setClassroom($classroomRepository->getById($child->getClassroomId()));
        }
      
        return $this->renderView("/template/account/account_parent.phtml", [
        "children" => $children
        ]);
    }

    
    
    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function faculty(): string
    {
        $userId = $_SESSION['user_id'];
        $classroomRepository = new ClassroomRepository();
        $classes = $classroomRepository->getClassByUser($userId);
        
        return $this->renderView("/template/account/account_faculty.phtml", [
                "classes" => $classes
                ]);
    }
    
    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function admin(): string
    {
        return $this->renderView("/template/account/account_admin.phtml");
    }


}//end class AccountController