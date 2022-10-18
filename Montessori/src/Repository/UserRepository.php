<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/User.php";
require_once dirname(__DIR__, 2) . "/src/Repository/RoleRepository.php";

class UserRepository extends AbstractRepository
{
    /* userExists
     * @param string $username 
     * @return User
     */
    public function userExists(string $username) 
    {
        $query = "SELECT * FROM user WHERE username = :username ; ";
        $class = "User";
        $params = [ ":username"=>$username ];
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* retrieve
     * @param int $id
     * @return User
     */  
    public function retrieve(int $id)
    {
        $query = "SELECT * FROM user WHERE id = :id; ";
        $class = "User";
        $params = [ ":id"=>$id ];
        return ($this->executeQuery($query, $class, $params));
    }
    
    /* verifyPassword
     * @param string $username 
     * @param string $password 
     * @return boolean
     */    
    public function verifyPassword(string $username, string $password) :bool
    {
        $query = "SELECT * FROM user WHERE username = :username; ";
        $class = "User";
        $params = [ ":username"=>$username ];
        
        $user = $this->executeQuery($query, $class, $params);
        
        $roleRepository = new RoleRepository();
        $user->setRole($roleRepository->getById($user->getRoleId()));
        
        $hash = $user->getPassword();

        if(password_verify($password, $hash))
        {
            $_SESSION["login"] = true;
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_permission'] = $user->getWriteDeleteAble();
            $_SESSION['user_role'] = $user->getRole()->getName();
            return true;
        } else {
            return false;
        }
    }

    /* add
     * @param User $user 
     * @return User
     */
    public function add(User $user)
    {
        $query = "INSERT INTO user(lastname, firstname, username, password, email1, telephone1, account_active, fk_role_id, write_delete_able) 
                  VALUES(:lastname, :firstname, :username, :password, :email1, :telephone1, :account_active, :fk_role_id, :write_delete_able);" ;
        
        $class = "User" ;
        
        // use variables for protection and security
        $params = 
        [
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":firstname" => $user->getFirstname(),
            ":lastname" => $user->getLastname(),
            ":email1" => $user->getEmail1(),
            ":telephone1" => $user->getTelephone1(),
            ":account_active" => $user->getAccountActive(),
            ":fk_role_id" => $user->getRoleId(),
            ":write_delete_able" => $user->getWriteDeleteAble()
        ];

        return ($this->executeQuery($query, $class, $params));
    }
    
    /* findLast
     * @return User
     */   
    public function findLast()
    {
        $query = "SELECT * 
                  FROM user 
                  ORDER BY id DESC LIMIT 1;" ;
        $class = "user";
        return ($this->executeQuery($query, $class));
    }
   
    /* related
     * @params int $parentId
     * @params int $childId
     * @return boolean
     */       
    public function related(int $parentId, int $childId)
    {
        $query = "SELECT * 
                  FROM parent_child 
                  WHERE pk_user_id = :parentId AND pk_student_id = :childId ; ";
        $params = 
            [
                ":parentId"=>$parentId,
                ":childId"=>$childId
            ];
        $class = "User";
        $request = $this->executeQuery($query, $class, $params);
        if($request)
        { 
            return true;
            
        } else {
            return false;
        }
    }
    
    /* createRelation
     * @params int $parentId
     * @params int $childId
     * @return 
     */      
    public function createRelation(int $parentId, int $childId)
    {
        $query = "INSERT INTO parent_child (pk_user_id, pk_student_id)
                  VALUES (:parentId, :childId); ";
        $params = 
            [
                ":parentId"=>$parentId,
                ":childId"=>$childId
            ];
        $class = "User";
        $this->executeQuery($query, $class, $params);
    }

}