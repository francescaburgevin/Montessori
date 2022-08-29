<?php


class Classroom {
    
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var string $file_path_image
     */
    private string $file_path_image;
    
    /**
     * @var string $email
     */
    private string $email;

    /**
     * @var ?string $school_year
     */
     private ?string $school_year;
     
    
    
    /**
     * Constructeur $Classroom
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
     * Get $name
     *
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name): void
    {
        $this->name = $name;

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
    public function setFilePathImage(string $file_path_image): void
    {
        $this->file_path_image = $file_path_image;

    }


   /**
     * Get $email
     *
     * @return  string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
   /**
     * Set $email
     *
     * @param  string  $email  
     *
     * @return  self
     */
    public function setEmail(string $email): void
   {
       $this->email = $email;
   }
   

   /**
     * Get $school_year
     * 
     * @return string
     */
    public function getSchoolYear(): ?string
    {
        $date = new DateTime($this->school_year);  
        $nextYear= intval($date->format("Y"))+1;
        return $date->format("Y-".$nextYear);
    }
    
    
    
    /**
     * SET $school_year
     * 
     * @param string $school_year
     */
    public function setSchoolYear(string $school_year): void
    {
        $this->school_year = $school_year;
    }


   
}