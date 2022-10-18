<?php
require_once dirname(__DIR__, 2) . "/src/Model/Role.php";

class User {
    
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $firstname
     */
    private string $firstname;

    /**
     * @var string $lastname
     */
    private string $lastname;
    
    /**
     * @var string $username
     */
    private string $username;

    /**
     * @var string $password The hashed password
     */
    private string $password;

    /**
     * @var string $email1
     */
    private string $email1;

    /**
     * @var string $telephone1
     */
    private string $telephone1;
    
    /**
     * @var ?int $write_delete_able
     */
    private ?int $write_delete_able;
    
    /**
     * @var ?int $account_active
     */
    private ?int $account_active;

    /**
     * @var int $fk_role_id
     */
     private int $fk_role_id;
     
    /**
     * @var Role $role
     */
     private Role $role;


    /**
     * Constructeur $User
     */
    public function __construct(){}


    /**
     * Get $id
     *
     * @return  int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set $id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Get $firstname
     *
     * @return  string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set $firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    
    
    /**
     * Get $lastname
     *
     * @return  string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set $lastname
     *
     * @param  string  $lastname  
     *
     * @return  self
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }


   /**
     * Get $username
     *
     * @return  string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set $username
     *
     * @param  string  $username
     *
     * @return  self
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }


    /**
     * Get $password
     *
     * @return  string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set $password
     *
     * @param  string  $password
     *
     * @return  self
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    
    /**
     * Get $email1
     *
     * @return  string
     */
    public function getEmail1(): string
    {
        return $this->email1;
    }
    
    /**
     * Set $email1
     *
     * @param  string  $email1
     *
     * @return  self
     */
    public function setEmail1(string $email1): void
    {
        $this->email1 = $email1;
    }
   
   
    /**
     * Get $telephone1
     *
     * @return  string
     */
    public function getTelephone1(): string
    {
        return $this->telephone1;
    }
    
    /**
     * Set $telephone1
     *
     * @param  string  $telephone1
     *
     * @return  self
     */
    public function setTelephone1(string $telephone1): void
    {
        $this->telephone1 = $telephone1;
    }
   
     
   /**
     * Get $write_delete_able
     *
     * @return  ?int
     */
    public function getWriteDeleteAble(): ?int
    {
        return $this->write_delete_able;
    }
    
    /**
     * Set $write_delete_able
     *
     * @param  ?int  $write_delete_able
     *
     * @return  self
     */
    public function setWriteDeleteAble(?int $write_delete_able): void
    {
        $this->write_delete_able = $write_delete_able;
    }
    
    
    /**
     * Get $account_active
     *
     * @return  ?int
     */
    public function getAccountActive(): ?int
    {
        return $this->account_active;
    }
    
     /**
     * Set $account_active
     *
     * @param  ?int  $account_active
     *
     * @return  self
     */
    public function setAccountActive(?int $account_active): void
    {
        $this->account_active = $account_active;
    }
    
   
    /**
     * Get $fk_role_id
     *
     * @return  int
     */
    public function getRoleId(): int
    {
        return $this->fk_role_id;
    }
    
     /**
     * Set $fk_role_id
     *
     * @param  int  $fk_role_id
     *
     * @return  self
     */
    public function setRoleId(int $fk_role_id): void
    {
        $this->fk_role_id = $fk_role_id;
    }
   
   
    /**
    * Get $role
    *
    * @return  Role
    */
    public function getRole(): Role
    {
       return $this->role;
    }
   
    /**
    * Set $role
    *
    * @param  Role  $role
    *
    * @return  self
    */
    public function setRole(Role $role): void
    {
       $this->role = $role;
    }
   
   
    /*
     * Pour convertir un objet en Json 
     */
    public function jsonSerialize()
    {
        $objectArray = [];
        
        foreach($this as $key => $value) {
            $objectArray[$key] = $value;
            
        }
        return json_encode($objectArray);
    }   
    
}