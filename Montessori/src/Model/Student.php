<?php
require_once dirname(__DIR__) . "/Model/Classroom.php";

class Student {
    
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
     * @var string $file_path_image
     */
    private string $file_path_image;

    /**
     * @var int $fk_classroom_id
     */
     private int $fk_classroom_id;
     
    /**
     * @var Classroom $classroom
     */
     private Classroom $classroom;


    /**
     * Constructeur $Student
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
     * Get $file_path_image
     *
     * @return  string
     */
    public function getFilePathImage(): string
    {
        return $this->file_path_image;
    }
    
    /**
     * Set $file_path_image
     *
     * @param  string  $file_path_image  
     *
     * @return  self
     */
    public function setFilePathImage(): void
    {
        $this->file_path_image = $file_path_image;
    }

    
   /**
     * Get $fk_classroom_id
     *
     * @return  string
     */
    public function getClassroomId(): int
    {
        return $this->fk_classroom_id;
    }
   
   
    /**
    * Get $classroom
    *
    * @return  string
    */
    public function getClassroom(): Classroom
    {
    return $this->classroom;
    }

    /**
    * Set $role
    *
    * @param  Classroom  $classroom
    *
    * @return  self
    */
    public function setClassroom(Classroom $classroom): void
    {
       $this->classroom = $classroom;
    }
    
    
}