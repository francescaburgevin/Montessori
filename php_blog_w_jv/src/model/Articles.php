<?php

//model = une ligne dans un tableau. 
//les colonnes

    class Article {

    /** 
     * @var int $id 
     */
    private int $id;

    /** 
     * @var string|null $title 
     */
    private string $title;

    /**
     * @var string $content
     */
    private ?string $content;

    /**
     * @var string|null $published_date
     */
    private ?string $published_date;

    /**
     * @var string|null $published_date
     */
    private string $user_id;

     
    private ?string $file_path_image;
 


    /**
     * Artcile constructor
     */
    public function __construct(){
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPublishedDate(): ?string
    {
        $date = new DateTime($this->published_date);        
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param string $published_date
     */
    public function setPublishedDate(string $published_date): void
    {
        $this->published_date = $published_date;
    }

        
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }
    
    /**
     * @return string
     */
    public function getFile_path_image(): ?string
    {
        return $this->file_path_image;
    }
 
    /**
     * @param string $user_image
     */
    public function setFile_path_image($file_path_image): void
    {
        $this->file_path_image = $file_path_image;
    }
 
 
}
