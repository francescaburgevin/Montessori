<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/CommentRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassFeedRepository.php";

class CommentController extends AbstractController
{
    /*   comment
     *   @return string => template + class feed's comments
     */
    public function comment(): string
    {
        $feedComments = $commentRepository->getChildByParent($_GET['feed-id']);

        return $this->renderView("/template/feed/template_part/__feed_comment.phtml", [
            "feedComments"=>$feedComments
            ]);
    }
    
    /*   addComment
     *   @return string => update feed with comment (faculy or parent class feed)
     */
    public function addComment(): string
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        if (Service::checkIfUserIsConnected())
        {
            $classId=intval($_POST['class-id']);
            
            if(strlen($newCommentContent=trim($_POST["add-comment-content"]))) 
            {
                $newComment = new Comment();
           
                $newComment->setContent($_POST["add-comment-content"]);

                $editDate = "";
                $editDate = new DateTime("now");
                $editDate = $editDate->format("Y-m-d H:i:s");
                $newComment->setEditDate($editDate);
                
                $newComment->setPublishDate(null);
                if($_SESSION['user_permission'])
                {
                    $publishDate = new DateTime();
                    $newComment->setPublishDate($publishDate->format("Y-m-d"));
                }
            
                $newComment->setUserId($_POST["user-id"]);
                $newComment->setClassFeedId($_POST["feed-id"]);
                
                if(isset($_POST['parent_comment_id']))
                {
                    $newComment->setParentCommentId($_POST['parent_comment_id']);
                } else {
                    $newComment->setParentCommentId(null);
                }
                
                $commentRepository = new CommentRepository();
                $commentRepository->add($newComment);
                
                if(isset($_POST['student-id']))
                {
                    $studentId= intval($_POST['student-id']);
                    $page="parent_class_feed&student-id=$studentId&class-id=$classId";
                }

            }
   
            if($_SESSION['user_role']!="parent") 
            {
               $page="faculty_class_feed&class-id=$classId";
            }
            
            header("Location:?page=".$page);
        }
    }
    
    /*   editCommentPublish
    /*   editFeedPublish
     *   @return string => update feed publish status (visible or not)
     */
    public function editCommentPublish()
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->getById(intval($_POST["comment_id"]));
        
        if($_POST["publish-checkbox"]=="on")
        {
            $publishDate = new DateTime();
            $comment->setPublishDate($publishDate->format("Y-m-d"));
        } 
        
        if(empty($_POST["publish-checkbox"]))
        {
            $comment->setPublishDate(null);
        }
        
        $commentRepository->updatePublish($comment);
        header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
    }
    
}