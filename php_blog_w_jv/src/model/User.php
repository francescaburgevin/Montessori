<?php

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
     * Constructeur $User
     */
    public function __construct(){
    }

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
     * @param  int  $id  $id
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
     * @param  string  $firstname  $username
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
     * Set $username
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
     * @param  string  $username  $username
     *
     * @return  self
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;

    }

    /**
     * Get $password The hashed password
     *
     * @return  string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set $password The hashed password
     *
     * @param  string  $password  $password The hashed password
     *
     * @return  self
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
   
}