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
                
                $newFeed = new ClassFeed();
                $newFeed->setClassroomId($classId);
                
                if($imagePath)
                {
                    $newFeed->setFilePathImage($imagePath);
                    $newFeed->setImageDescription($uploadImageDescription);
                }
                
                if($_POST["content"])
                {
                    $newFeed->setContent($_POST["content"]);
                }
                
             
                
                if(isset($_POST["publish_date"]) && ($_POST["publish-date"])!=null)
                {
                    $publishDate = new DateTime($_POST["publish-date"]);
                    $newFeed->setPublishDate($publishDate->format("Y-m-d"));
                } else {
                    $newFeed->setPublishDate(null);
                }
                    
                
                
                $editDate = "";
                $editDate = new DateTime("now");
                $editDate = $editDate->format("Y-m-d H:i:s");
                $newFeed->setEditDate($editDate);
            
                $classFeedRepository = new ClassFeedRepository();
                $classFeedRepository->add($newFeed);
                
                $feedId = $classFeedRepository->findLast();
                
                foreach($studentList as $key=>$studentId)
                {
                    $classFeedRepository->insertStudentFeed($feedId->getId(), intval($studentId));
                }
            
            }
            
           header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
        }
    
        return $this->renderView("/template/feed/faculty_class_feed.phtml");
    }//end function addFeed
    
    /*
    public funtion editFeedPublish()
    {
        
    }
    */
    
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
                isset($_POST["feed-id"])
                && $feed = $classFeedRepository->findOne(intval($_POST["feed-id"]))
            ){
                if(
                    (
                        (strlen($uploadImageDescription=trim($_POST["edit-upload-image-description"])))
                        && (count($studentList=($_POST["edit-feed-list-students"])))
                        && ($classId = ($_POST["class-id"]))
                    ) 
                    || 
                    (
                        (strlen($content=trim($_POST["edit-content"])))
                        &&  count($studentList=($_POST["edit-feed-list-students"]))
                        && ($classId = ($_POST["class-id"]))
                    )
                ){
                    
                    if($_POST["edit-content"])
                    {
                        $feed->setContent(trim($_POST["edit-content"]));
                    } else {
                        $feed->setContent("");
                    }

                    if($_POST["edit-upload-image-description"])
                    {
                        $feed->setImageDescription(trim($_POST["edit-upload-image-description"]));
                    } else 
                        {
                            $feed->setImageDescription("");
                        }
        
        
                    if(!empty($_POST["edit-publish-date"]))
                    {
                        $publishDate = new DateTime($_POST["publish-date"]);
                        $feed->setPublishDate($publishDate->format("Y-m-d"));
                    } 
                    
                    if($_FILES["edit-upload-image"]["size"] > 0)
                    {
                        $deleteImage = $feed->getFilePathImage();
                        unlink($deleteImage);
                        //unlink(dirname(__DIR__, 3) . $feed->getFilePathImage());
                        $newImage = Service::moveFile($_FILES["edit-upload-image"]);
                        $feed->setFilePathImage($newImage);
                    }
                            
                    $editDate = "";
                    $editDate = new DateTime("now");
                    $editDate = $editDate->format("Y-m-d H:i:s");
                    $feed->setEditDate($editDate);
    
                    $classFeedRepository = new ClassFeedRepository();
                    $classFeedRepository->update($feed);
                    
                    
                    //$feed = $classFeedRepository->findLast();
                    
                    $newStudentList = $_POST["edit-feed-list-students"];
                    $oldStudentList = $feed->getLinkedStudents();
                    
                    var_dump($oldStudentList);
                    
                    if(is_null($oldStudentList)){ $oldStudentList=[]; };
                    
                    var_dump($oldStudentList);
                    
                    
                    foreach($newStudentList as $key=>$studentId)
                    {   
                        if(!in_array(intval($studentId), $oldStudentList))
                        {
                            $classFeedRepository->insertStudentFeed($feed->getId(), intval($studentId));
                        }
                    }
                    
                    foreach($oldStudentList as $key=>$studentId)
                    {
                        if(!in_array($studentId, $newStudentList))
                        {
                            $classFeedRepository->deleteStudentFeed($feed->getId(), intval($studentId));
                        }
                    }
                    
                    
                }
                header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
            }
            return $this->renderView("/template/feed/faculty_class_feed.phtml");
        }

    }// end function editFeed


    public function deleteFeed()
    {
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne(intval($_GET["feed-id"]));
        if (
            Service::checkIfUserIsConnected()
            && isset($_GET["feed-id"])
            && $feed
        ) {
            if(!empty($feed->getFilePathImage())){
                //supprime l'image lié à l'article 
                //$deleteImage = $feed->getFilePathImage();
                //unlink($deleteImage);
                unlink(dirname(__DIR__, 3) . $feed->getFilePathImage());
            }
            
            //delete comments
            $commentsRepository = new CommentRepository();
            $commentsRepository->deleteComments($feed->getId());
            
            //delete student classfeed
            $studentRepository = new StudentRepository();
            $studentRepository->deleteStudents($feed->getId());
            
            // supprime le feed
            $classFeedRepository->delete($feed);
            // Redirect vers la page listant les articles 
             header("Location: ?page=faculty_class_feed&class-id=".$feed->getClassroomId());
        }
        
          return $this->renderView("/template/feed/faculty_class_feed.phtml");
           
    }//end function deleteFeed
    

// simply retreive info, no page load
    public function xmlRetrieve()
    {
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne($_GET["feed_id"]);
        print($feed->jsonSerialize());
    }
}
