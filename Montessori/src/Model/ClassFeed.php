<?php

require_once dirname(__DIR__, 2) . "/src/Repository/CommentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Comment.php";

class ClassFeed {
    
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $edit_date
     */
    private string $edit_date;

    /**
     * @var ?string $publish_date
     */
    private ?string $publish_date;

    /**
     * @var string $file_path_image
     */
    private ?string $file_path_image;
    
    /**
     * @var string $image_description
     */
    private ?string $image_description;
    
    /**
     * @var string $content
     */
    private ?string $content;

    /**
     * @var int $fk_classroom_id
     */
     private int $fk_classroom_id;
     
    /**
     * @var ?Comment $comment
     */
     private ?Comment $comment;
    
    /**
     * @var ?Student $linked_students
     */
     private ?Student $linked_students;
    
    /**
     * @var ?Array $students_linked
     */
      private ?Array $students_linked;
    
    
    
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
     * Get $edit_date
     *
     * @return  string
     */
    public function getEditDate(): string
    {
        $date = new DateTime($this->edit_date);        
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Set $edit_date
     *
     * @param  string  $edit_date
     *
     * @return  self
     */
    public function setEditDate(string $edit_date): void
    {
        $this->edit_date = $edit_date;
    }


    /**
     * Get $publish_date
     *
     * @return  ?string
     */
    public function getPublishDate(): ?string
    {
        if(is_null($this->publish_date)){
            return $this->publish_date;
        } else {
            $date = new DateTime($this->publish_date);        
            return $date->format('Y-m-d');
        }
    }

    /**
     * Set $publish_date
     *
     * @param  ?string  $publish_date
     *
     * @return  self
     */
    public function setPublishDate(?string $publish_date)
    {
        if(is_null($publish_date)){
            $this->publish_date = NULL;
        } else 
            {
                $this->publish_date = $publish_date;
            }
    }
    
    
    /**
     * Get $file_path_image
     *
     * @return  string
     */
    public function getFilePathImage(): ?string
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
    public function setFilePathImage(?string $file_path_image): void
    {
        $this->file_path_image = $file_path_image;

    }

    
     /**
     * Get $image_description
     *
     * @return  ?string
     */
    public function getImageDescription(): ?string
    {
        return $this->image_description;
    }

    /**
     * Set $image_description
     *
     * @param  ?string  $image_description  
     *
     * @return  self
     */
    public function setImageDescription(?string $image_description): void
    {
        $this->image_description = $image_description;

    }


   /**
     * Get $content
     *
     * @return  string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    
   /**
     * Set $content
     *
     * @param  string  $content  
     *
     * @return  self
     */
    public function setContent(string $content): void
    {
       $this->content = $content;
    }
   
   
  /**
     * Get $fk_classroom_id
     *
     * @return  int
     */
    public function getClassroomId(): int
    {
        return $this->fk_classroom_id;
    }
    
   /**
     * Set $fk_classroom_id
     *
     * @param  int  $fk_classroom_id  
     *
     * @return  self
     */
    public function setClassroomId(int $fk_classroom_id): void
    {
       $this->fk_classroom_id = $fk_classroom_id;
    }
   
   
    /**
     * Get $relatedComments
     *
     * @return  Comment
     */
    public function getCommentsOfFeed()
    {
        $commentRepository= new CommentRepository();
        $relatedComments = $commentRepository->getCommentsOfFeed($this->id);
        return $relatedComments;
    }
   
   
   /**
    * Get $comment
    *
    * @return  Comment
    */
    public function getComment(): Comment
    {
       return $this->comment;
    }
   
    /**
    * Set $comment
    *
    * @param  Comment  $comment
    *
    * @return  self
    */
    public function setComment(Comment $comment): void
    {
       $this->comment = $comment;
    }


   /**
    * Get $students_linked
    *
    * @return  array
    */
    public function getLinkedStudents()
    {
        $studentRepository= new StudentRepository();
        $linked_students = $studentRepository->getStudentsInFeed($this->id);
        $this->students_linked = [];

        foreach($linked_students as $key => $student)
        {
            array_push($this->students_linked, $student);
        }
        
        return $this->students_linked;
    }
    
    
   /**
    * Get $students_linked
    *
    * @return  array
    */    
    public function getStudentsLinked()
    {
        return $this->students_linked;
    }
 
 
    /**
     * Pour convertir un objet en Json 
     */
    public function jsonSerialize()
    {
        $objectArray = [];
        foreach($this as $key => $value) {
            $objectArray[$key] = $value;
        }
    
        array_push($objectArray, $this->getLinkedStudents());
        
        return json_encode($objectArray);
    }   
}