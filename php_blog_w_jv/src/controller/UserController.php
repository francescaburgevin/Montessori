<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";
require_once dirname(__DIR__, 2) . "/src/model/User.php";

class UserController extends AbstractController
{

    /**
     * @return string utilise la methode add()
     */
    public function add(): string
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

    public function connexion()
    {
        if (!empty($_POST)) {
            
            //if input fields completed
            if (
                isset($_POST["username"])
                && isset($_POST["password"])
            ){
                $username = trim($_POST["username"]);
                $password = trim($_POST["password"]);

                //initiate a UserRepository object
                $userRepository = new UserRepository();
                
                //check if user exists
                $user = $userRepository->userExists($username);
                
                if($user){
                    
                    var_dump("user is valid");
                    
                    if($userRepository->verifyPassword($username, $password))
                    {
                        header("Location: ?page=home");
                    } else {
                        var_dump ("Password incorrect.");
                    }
                }
                
                if(!$user){
                    var_dump("Username n'existe pas.");
                }
            }
        }
        //show user_connexion page
        return $this->renderView("/template/user/user_connexion.phtml");
        
    }//end function connexion
    
    public function deconnexion()
    {
            unset($_SESSION["login"]);
            header("Location: ?page=home");            
    }//end function deconnexion


}//end class UserController