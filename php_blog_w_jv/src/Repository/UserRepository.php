<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/model/User.php";
//require_once dirname(__DIR__, 2) . "/template/base.phtml";

class UserRepository extends AbstractRepository
{
    //check if username exists
    public function userExists(string $username)
    {
        var_dump("function userExists started");
        
        $question = "SELECT * FROM user WHERE username = :username ; ";
        $params = [":username"=>$username];
        $class = "User";
        
        var_dump($this->executeQuery($question, $class, $params));
        return ($this->executeQuery($question, $class, $params));
    }
    
    //check password
    public function verifyPassword(string $username, string $password) :bool
    {
        $query = "SELECT * FROM user WHERE username = :username; ";
        $params = 
        [
            ":username"=>$username
        ];
        
        $class = "User";
        $user = $this->executeQuery($query, $class, $params);
        $hash = $user->getPassword();
        
        if(password_verify($password, $hash))
        {
            $_SESSION["login"] = true;
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['user_id'] = $user->getId();
            return true;
        } else 
        {
            return false;
        }
    }

    // add user object/model to database "user"
    public function add(User $user)
    {
        $query = "INSERT INTO user(lastname, firstname, username, password) 
                  VALUES(:lastname, :firstname, :username, :password);" ;
        
        $class = "User" ;
        
        // use variables for protection and security
        $params = 
        [
            ":lastname" => $user->getLastname(),
            ":firstname" => $user->getFirstname(),
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword()
        ];
        
        echo "user added successfully";
        
        return ($this->executeQuery($query, $class, $params));
    }
    
    // retrieve user information from database "user"
     public function retrieve(int $id)
    {

        $query = "SELECT * FROM user WHERE id = $id; ";
        $class = "User";

        return ($this->executeQuery($query, $class));
    }
    
 
}

