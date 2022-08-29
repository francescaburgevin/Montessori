<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassFeedRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/service/Service.php";
require_once dirname(__DIR__, 2) . "/src/Model/ClassFeed.php";

class ClassFeedController extends AbstractController
{
    

    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function feed(): string
    {
        //controler si student id = parent id 
        //$allChildFeeds = "";
        $classFeedRepository = new ClassFeedRepository();
        $allRelatedFeeds = $classFeedRepository->getFeedByStudent($_GET['student-id']);
        
        return $this->renderView("/template/feed/class_feed.phtml", [
            'allRelatedFeeds'=>$allRelatedFeeds
            ]);
    }
    
    
     /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function facultyFeed(): string
    {
        $classFeedRepository = new ClassFeedRepository();
        $allRelatedFeeds = $classFeedRepository->getFeedByClassId($_GET['class-id']);
        
        $studentRepository = new StudentRepository;
        $studentList = $studentRepository->getStudentsByClassId($_GET['class-id']);
        
        foreach($allRelatedFeeds as $key => $feed){
            $feed->getLinkedStudents(); 
        }
        
        return $this->renderView("/template/feed/faculty_class_feed.phtml", [
            'studentList'=>$studentList,
            'allRelatedFeeds'=>$allRelatedFeeds,
            ]);
    }
    
    
    public function addFeed()
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        if (Service::checkIfUserIsConnected())
        {
            if(
                    (
                        ($imagePath = Service::moveFile($_FILES["upload-image"]))
                        && (strlen($uploadImageDescription=trim($_POST["upload-image-description"])))
                        && (count($studentList=($_POST["add-feed-list-students"])))
                        && ($classId = ($_POST["class-id"]))
                    ) 
                    || 
                    (
                        (strlen($content=trim($_POST["content"])))
                        &&  count($studentList=($_POST["add-feed-list-students"]))
                        && ($classId = ($_POST["class-id"]))
                    )
            ){
                $publishDate = $_POST["publish-date"];
                
                $newFeed = new ClassFeed();
                $newFeed->setClassroomId($classId);
                
                if($imagePath)
                {
                    $newFeed->setFilePathImage($imagePath);
                    $newFeed->setImageDescription($uploadImageDescription);
                }
                
                if($content)
                {
                    $newFeed->setContent($content);
                }
                
                
                if($publishDate)
                {
                    $publishDate = new DateTime();
                    $publishDate = $publishDate->format("Y-m-d");
                    
                    $newFeed->setPublishDate($publishDate);
                }
                
                $editDate = "";
                $editDate = new DateTime("now");
                $editDate = $editDate->format("Y-m-d H:i:s");
                $newFeed->setEditDate($editDate);
            
                $classFeedRepository->add($newFeed);
            }
            
           header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
            
        }
    
        return $this->renderView("/template/feed/faculty_class_feed.phtml");
    }//end function addFeed
    
    
    public function editFeed()
    {
        $classFeedRepository = new ClassFeedRepository();

        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        if (Service::checkIfUserIsConnected())
        {
            if(
                isset($_GET["feed_id"])
                && $feed = $classFeedRepository->findOne(intval($_GET["feed_id"]))
            ){
                if(
                    (
                        ($imagePath = Service::moveFile($_FILES["upload-image"]))
                        && (strlen($uploadImageDescription=trim($_POST["upload-image-description"])))
                        && (count($studentList=($_POST["add-feed-list-students"])))
                        && ($classId = ($_POST["class-id"]))
                    ) 
                    || 
                    (
                        (strlen($content=trim($_POST["content"])))
                        &&  count($studentList=($_POST["add-feed-list-students"]))
                        && ($classId = ($_POST["class-id"]))
                    )
                ){
                    
                    if($content)
                    {
                        $feed->setContent($content);
                    }
    
                    if($uploadImageDescription)
                    {
                        $feed->setImageDescription($uploadImageDescription);
                    }
    
                    if($_POST["publish_date"])
                    {
                        $feed->setPublishDate($_POST["publish-date"]);
                    }
                    
                    if($imagePath)
                    {
                        $file_deleted = $feed->getFilePathImage();
                        if (file_exists($file_deleted)) unlink($file_deleted);
                        $feed->setFilePathImage($imagePath);        
                    }
    
                    $editDate = "";
                    $editDate = new DateTime("now");
                    $editDate = $editDate->format("Y-m-d H:i:s");
                    $feed->setEditDate($editDate);
    
                    $this->classFeedRepository->update($feed);
                }
        
                header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
            }
            
        return $this->renderView("/template/feed/faculty_class_feed.phtml");
        }

    }// end function editFeed


    public function deleteFeed()
    {
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne(intval($_GET["class-feed-id"]));
                
        if (
            Service::checkIfUserIsConnected()
            && isset($_GET["class-feed-id"])
            && $feed
        ) {
            var_dump($feed->getFilePathImage());
            //supprime l'image lié à l'article 
            unlink(dirname(__DIR__, 3) . $feed->getFilePathImage());
            // supprime le feed
            $this->classFeedRepository->delete($feed);
            // Redirect vers la page listant les articles 
             header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
        }
           
    }//end function deleteFeed
    

    public function retrieveFeed(int $id)
    {
        var_dump("in retrieve feed");
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne($id);
    
        return $this->renderView("/template/feed/xml/edit.php", [
            'feed'=>$feed
            ]);
    }
}
