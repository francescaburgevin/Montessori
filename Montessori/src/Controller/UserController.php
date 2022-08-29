<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/UserRepository.php";
require_once dirname(__DIR__) . "/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/User.php";



class UserController extends AbstractController
{


    /**
     * @return string utilise la methode add()
      no add method for the moment*/
/*    public function add(): string
    {
        //$notError=null;
        //$message = "";
        

        if (
            !empty($_POST)
            && isset($_POST["user_lastname"])
            && isset($_POST["user_firstname"])
            && isset($_POST["user_username"])
            && isset($_POST["user_password"])
        ) {
            //$notError=false;
            //$message="Les informations fournies ne sont pas valables.";

            $lastname = trim($_POST["user_lastname"]);
            $firstname = trim($_POST["user_firstname"]);
            $username = trim($_POST["user_username"]);
            $password = trim($_POST["user_password"]);

            $userRepository= new UserRepository();
            
            if(!$userRepository->userExists($username)){

                $user = new User();
                $user->setLastname($lastname);
                $user->setFirstname($firstname);
                $user->setUsername($username);
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT,["cost" => 12] ));
                $userRepository->add($user);
            }
        }

        //show user_add page with list of users.
        return $this->renderView("/template/user/user_add.phtml");
        //"error"=>$notError,
        //"message"=>$message
    }//end function add
*/
    public function connection()
    {
        //if input fields empty
        if (!empty($_POST)) {
            
            //if input fields completed
            if (
                isset($_POST["username"])
                && isset($_POST["password"])
            ){
                $username = htmlspecialchars(trim($_POST["username"]));
                $password = htmlspecialchars(trim($_POST["password"]));

                //initiate a UserRepository object
                $userRepository = new UserRepository();
                $user = $userRepository->userExists($username);
                
                if($user==null){
                    $message= "Username n'existe pas.";
                    return $this->renderView("/template/user/user_connection.phtml", [
                        "message"=>$message
                    ]);
                }


                //if user exists
                if($user){
 
                    if($user->getAccountActive())
                    
                        if($userRepository->verifyPassword($username, $password))
                        {
                            header("Location: ?page=".$_SESSION['user_role']);  
                        } else {
                            $message= "Mot de passe incorrecte.";
                            return $this->renderView("/template/user/user_connection.phtml", [
                                "message"=>$message
                            ]);
                        }
                    } else {
                        $message= "Le compte n'est pas actif.";
                        return $this->renderView("/template/user/user_connection.phtml", [
                            "message"=>$message
                        ]);
                    }
                }
                
            }
        
        
        //if input empty, show user_connection page
        return $this->renderView("/template/user/user_connection.phtml", [
            "message"=>""
            ]);
        
    }//end function connection
    
    
    public function deconnection()
    {
            unset($_SESSION["login"]);
            unset($_SESSION['firstname']);
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['user_permission']);
            unset($_SESSION['user_role']);
            
            header("Location: ?page=home");            
    }//end function deconnexion


}//end class UserController