<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/User.php";
require_once dirname(__DIR__, 2) . "/src/Repository/RoleRepository.php";


class UserRepository extends AbstractRepository
{
    
    /*  
        check if the username exists
        @param string $username 
        @return query result
    */
    
    public function userExists(string $username) 
    {
        $query = "SELECT * FROM user WHERE username = :username ; ";
        $class = "User";
        $params = 
            [
                ":username"=>$username
            ];
        
        return ($this->executeQuery($query, $class, $params));
    }
    
    /*  
        check if the password is correct
        @param string $username 
        @param string $password
        @return boolean
    */
    
    public function verifyPassword(string $username, string $password) :bool
    {
        $query = "SELECT * FROM user WHERE username = :username; ";
        $params = 
            [
                ":username"=>$username
            ];
        
        $class = "User";
        
        $user = $this->executeQuery($query, $class, $params);
        $roleRepository = new RoleRepository();
        $user->setRole($roleRepository->getById($user->getRoleId()));
        $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        if(password_verify($password, $hash))
        {
            $_SESSION["login"] = true;
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_permission'] = $user->getWriteDeleteAble();
            $_SESSION['user_role'] = $user->getRole()->getName();
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

