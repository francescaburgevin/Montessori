<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/UserRepository.php";
require_once dirname(__DIR__) . "/Repository/StudentRepository.php";
require_once dirname(__DIR__) . "/Repository/ClassroomRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/User.php";
require_once dirname(__DIR__, 2) . "/src/service/Service.php";

class UserController extends AbstractController
{
    /*  connection
     *  @return string => template + message
     */   
    public function connection()
    {
        $message="";
        //if input fields are not empty
        if (!empty($_POST))
        {
            $message="Error";
            
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
                
                if($user==null)
                {
                    $message= "Username n'existe pas.";
                    return $this->renderView("/template/user/user_connection.phtml", [
                        "message"=>$message
                    ]);
                }

                //if user exists
                if($user){
 
                    if($user->getAccountActive())
                    {
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
        
        //if error, show user_connection page
        return $this->renderView("/template/user/user_connection.phtml", [
            "message"=>$message
            ]);
        }
        //if empty, show user_connection page
        return $this->renderView("/template/user/user_connection.phtml", ["message"=>$message]);
    }
    
    /*  deconnection
     *  @return string => home page
     */ 
    public function deconnection()
    {
        unset($_SESSION["login"]);
        unset($_SESSION['firstname']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_permission']);
        unset($_SESSION['user_role']);
        header("Location: ?page=home");            
    }

    /*  add
     *  @return string => template
     */   
    public function add(): string
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        $classroomRepository = new ClassroomRepository();
        $classes = $classroomRepository->getAll();
                
        //check if username is unique
        if (!empty($_POST["user_username"]) && isset($_POST["user_username"]))
        {
            $userRepository= new UserRepository();
            if($userRepository->userExists($_POST["user_username"]))
            {
                unset($_POST);
                return $this->renderView("/template/account/account_administrator.phtml", [
                    "classes"=>$classes
                    ]);
            }
        }
        
        if (
            !empty($_POST)
            && isset($_POST["user_lastname"])
            && isset($_POST["user_firstname"])
            && isset($_POST["user_username"])
            && isset($_POST["user_password"])
        ) {

            $usernameChecked = Service::filterInput($_POST["user_username"]);
            
            if($usernameChecked[1]==="success")
            {
                $username = $usernameChecked[0];
            } else {
                unset($_POST);
                return $this->renderView("/template/account/account_administrator.phtml", [
                    "classes"=>$classes
                ]);
            }
            
            $userRepository= new UserRepository();
            if(!$userRepository->userExists($username))
            {
                if(isset($_POST["user_account_active"]))
                {
                    $active=1;
                } else {
                    $active=null;
                }
                
                if(isset($_POST["write_delete_able"]))
                {
                    $able=1;
                } else {
                    $able=null;
                }
    
                $role = $_POST["user_role"];
                
                $child=[];
                if(isset($_POST["user_child"]))
                {
                    $child=$_POST["user_child"];
                }

                $user = new User();
                $user->setLastname(trim($_POST["user_lastname"]));
                $user->setFirstname(trim($_POST["user_firstname"]));
                $user->setUsername($username);
                $user->setPassword(password_hash(trim($_POST["user_password"]), PASSWORD_BCRYPT,["cost" => 12] ));
                
                $user->setTelephone1(trim($_POST["user_telephone"]));
                $user->setEmail1(trim($_POST["user_email"]));
                $user->setAccountActive($active);
                $user->setRoleId(intval($role));
                $user->setWriteDeleteAble($able);
                
                $userRepository->add($user);
                $user = $userRepository->findLast();
                
                forEach($child as $key)
                {
                    $userRepository->createRelation($user->getId(), intval($key));
                }
                header("Location: ?page=admin");
            } else {
                unset($_POST);
                return $this->renderView("/template/account/account_administrator.phtml", [
                    "classes"=>$classes
                ]);
            }
        }
        
        $classroomRepository = new ClassroomRepository();
        $classes = $classroomRepository->getAll();
            
        $message = "Il manque des informations essentielles." ;
        
        return $this->renderView("/template/account/account_administrator.phtml", [
            "message"=>$message,
            "classes"=>$classes
            ]);
    }
    
    /*   xmlRetrieve
     *   @return database information with no page reload
     */
    public function xmlRetrieve()
    {
        $userRepository = new UserRepository();
        $user = $userRepository->userExists($_GET["username"]);
        print($user->jsonSerialize());
    }
    
}