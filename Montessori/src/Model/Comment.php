<?php
require_once dirname(__DIR__, 2) . "/src/Repository/CommentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";

class Comment {
    
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var datetime $edit_date
     */
    private string $edit_date;

    /**
     * @var ?string $publish_date
     */
    private ?string $publish_date;
    
    /**
     * @var string $content
     */
    private string $content;

    /**
     * @var int $fk_userId
     */
     private int $fk_user_id;
     
     /**
     * @var int $fk_classFeedId
     */
     private int $fk_class_feed_id;
     
     /**
     * @var ?int $fk_comment_id
     */
     private ?int $fk_comment_id;
     

    
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
        } else {
            $this->publish_date = $publish_date;
        }
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
    * Get $fk_user_id
    *
    * @return  int
    */
    public function getUserId(): int
    {
        return $this->fk_user_id;
    }
    
    /**
    * Set $fk_user_id
    *
    * @param  int  $fk_user_id  
    *
    * @return  self
    */
    public function setUserId(int $fk_user_id): void
    {
        $this->fk_user_id = $fk_user_id;
    }
   
   
    /**
    * Get $fk_class_feed_id
    *
    * @return int
    */
    public function getClassFeedId(): int
    {
        return $this->fk_class_feed_id;
    }
    
    /**
    * Set $fk_class_feed_id
    *
    * @param int $fk_class_feed_id  
    *
    * @return  self
    */
    public function setClassFeedId(int $fk_class_feed_id): void
    {
        $this->fk_class_feed_id = $fk_class_feed_id;
    }
    
   
    /**
    * Get $fk_comment_id
    *
    * @return  self
    */
    public function getParentCommentId(): ?int
    {
        return $this->fk_comment_id;
    }
   
    /**
     * Set $fk_comment_id
     *
     * @param  ?int  $fk_comment_id  
     *
     * @return  self
     */
    public function setParentCommentId(?int $fk_comment_id): void
    {
       $this->fk_comment_id = $fk_comment_id;
    }
   
   
    /**
     * Get $relatedComments
     *
     * @return  Comment
     */
    public function getRelatedComments()
    {
        $relatedComments=[];
        
        $commentRepository = new CommentRepository();
        $relatedComments = $commentRepository->getChildByParent($this->id);
        
        if(!$relatedComments)
        { 
            return $relatedComments=[]; 
        };
        
        return $relatedComments;
    }
    

    /**
     * Get count of children comments
     * @return  bool 
     */
    public function hasChildren(): bool
    {
        $hasChildren = $this->getRelatedComments();
        if(!$hasChildren){return false; }
        
        $objectArray = [];
        
        foreach($this as $key => $value) 
        {
            $objectArray[$key] = $value;
        }
        return count($objectArray);
    }
    
    
    /**
     * Get all comments of child comment
     * @return  Comment and page location 
     */
    public function displayChild(int $childComment)
    {
        $commentRepository = new CommentRepository();
        $allRelatedComments = $commentRepository->getById($childComment);
        include_once dirname(__DIR__,2).'/template/feed/template_part/__feed_comment.phtml';
    }
    
    
    /**
     * Get comment's User
     * @return  User 
     */
    public function getCommentUser()
    {
        $userRepository = new UserRepository;
        $user = $userRepository->retrieve($this->fk_user_id);
        return $user;
    }

}