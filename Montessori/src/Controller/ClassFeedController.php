<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassFeedRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/ClassroomRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/UserRepository.php";
require_once dirname(__DIR__, 2) . "/src/Repository/StudentRepository.php";
require_once dirname(__DIR__, 2) . "/src/service/Service.php";
require_once dirname(__DIR__, 2) . "/src/Model/ClassFeed.php";

class ClassFeedController extends AbstractController
{
    /*   parentFeed
     *   @return string => template + class feeds relative to student
     */
    public function parentFeed(): string
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        /* if parent (user) and child (student) are related, retrieve feeds */
        $userRepository = new UserRepository();
        
        if($userRepository->related($_SESSION['user_id'], intval($_GET['student-id'])))
        {
            /* parent and child are related, retrieve feeds relative to student */
            $classFeedRepository = new ClassFeedRepository();

            /* retrieve classroom id */
            $studentRepo = new StudentRepository();
            $student = $studentRepo->getStudentById($_GET['student-id']);

            /* retrieve all feeds related to class and to student*/
            $allRelatedFeeds = $classFeedRepository->getStudentFeeds($_GET['student-id'], $student->getClassroomId());
            
            /* if there are 0 feeds, create empty array */
            if($allRelatedFeeds === null) {$allRelatedFeeds=[]; };
            
            /* if class feed contains one object, create array */
            if(gettype($allRelatedFeeds) == "object")
            {
                $object=$allRelatedFeeds;
                $allRelatedFeeds=[];
                array_push($allRelatedFeeds, $object);
            }
            
            /* delete all recurring instances */
            $oldId = 0;
            foreach($allRelatedFeeds as $key => $feed)
            {
                $newId = $feed->getId();
                if($oldId === $newId)
                {
                    array_splice($allRelatedFeeds, $key, 1);
                } else {
                    $oldId=$newId;
                }
            }
            
            /* link student(s) to each feed */
            foreach($allRelatedFeeds as $key => $feed)
            {
                $feed->getLinkedStudents(); 
            }
        
            return $this->renderView("/template/feed/parent_class_feed.phtml", [
                'allRelatedFeeds'=>$allRelatedFeeds
            ]);
        } else {
                header("Location: ?page=home");
        }
        
    }
    
    /*   facultyFeed
     *   @return string => template + a class's feeds and its student list
     */
    public function facultyFeed(): string
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        if (isset($_SESSION['login']) && isset($_GET['class-id']) )
        {
            $classroomRepository = new ClassroomRepository();
            if(
                ($classroomRepository->confirmUserClass($_GET['class-id'], $_SESSION['user_id']))
                ||
                ($_SESSION['user_role']==="admin")
            )
            {
                /* retrieve related feeds by classroom id */
                $classFeedRepository = new ClassFeedRepository();
                $allRelatedFeeds = $classFeedRepository->getFeedByClassId($_GET['class-id']);
                
                /* retrieve list of students by classroom id */
                $studentRepository = new StudentRepository;
                $studentList = $studentRepository->getStudentsByClassId($_GET['class-id']);
                
                /* if class feed does not yet exist = empty */
                if($allRelatedFeeds === null) {$allRelatedFeeds=[]; };
                
                /* if class feed contains one object */
                if(gettype($allRelatedFeeds) == "object")
                {
                    $object=$allRelatedFeeds;
                    $allRelatedFeeds=[];
                    array_push($allRelatedFeeds, $object);
                }
            
                /* link student(s) to each feed */
                foreach($allRelatedFeeds as $key => $feed)
                {
                    $feed->getLinkedStudents(); 
                }
        
                return $this->renderView("/template/feed/faculty_class_feed.phtml", [
                    'studentList'=>$studentList,
                    'allRelatedFeeds'=>$allRelatedFeeds,
                    ]);
            } else {
                header("Location: ?page=home");
            }
        } else {
            header("Location: ?page=home");
        }
    }
    
    /*   addFeed
     *   @return string => update class feed
     */
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
                } else {
                    $newFeed->setFilePathImage(null);
                    $newFeed->setImageDescription(null);
                }
                
                if($_POST["content"])
                {
                    $newFeed->setContent($_POST["content"]);
                } else 
                    {
                        $newFeed->setContent("");
                    }
                
                if(isset($_POST["publish-date"]) && ($_POST["publish-date"])==="on")
                {
                    $publishDate = new DateTime("now");
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
    }
    
    /*   editFeed
     *   @return string => update feed
     */
    public function editFeed()
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }

        if (Service::checkIfUserIsConnected())
        {
            $classFeedRepository = new ClassFeedRepository();
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

                    if($_POST["edit-publish-date"])
                    {
                        $publishDate = new DateTime($_POST["publish-date"]);
                        $feed->setPublishDate($publishDate->format("Y-m-d"));
                    } else {
                        $feed->setPublishDate(null);
                    }
                    
                    if($_FILES["edit-upload-image"]["size"] > 0)
                    {
                        unlink(dirname(__DIR__, 3) . $feed->getFilePathImage());
                        $newImage = Service::moveFile($_FILES["edit-upload-image"]);
                        $feed->setFilePathImage($newImage);
                    }
                            
                    $editDate = "";
                    $editDate = new DateTime("now");
                    $editDate = $editDate->format("Y-m-d H:i:s");
                    $feed->setEditDate($editDate);
    
                    $classFeedRepository = new ClassFeedRepository();
                    $classFeedRepository->update($feed);
                    
                    //array of numbers in string form
                    $newStudentList = $_POST["edit-feed-list-students"];
                    //arra of objects
                    $oldStudentListObj = $feed->getLinkedStudents();
                    if(is_null($oldStudentListObj)){ $oldStudentListObj=[]; };
                    //array of numbers in int form
                    $oldStudentList = [];
                    
                    foreach($oldStudentListObj as $key){
                        array_push($oldStudentList, $key->getId());
                    };
                    
                    
                    foreach($newStudentList as $key)
                    {   
                        if(!in_array(intval($key), $oldStudentList ))
                        {
                            $classFeedRepository->insertStudentFeed($feed->getId(), intval($key));
                        }
                    }
                    
                    foreach($oldStudentList as $key)
                    {
                        if(!in_array($key, $newStudentList))
                        {
                            $classFeedRepository->deleteStudentFeed($feed->getId(), $key);
                        }
                    }
                    
                    
                }
                header("Location: ?page=faculty_class_feed&class-id=".$_POST['class-id']);
            }
            return $this->renderView("/template/feed/faculty_class_feed.phtml");
        }
    }

    /*   deleteFeed
     *   @return string => template
     */
    public function deleteFeed()
    {
        if (!isset($_SESSION['login']))
        {
            header("Location: ?page=user_connection");
        }
        
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne(intval($_GET["feed-id"]));
        if (
            Service::checkIfUserIsConnected()
            && isset($_GET["feed-id"])
            && $feed
        ) {
            if($feed->getFilePathImage()!=null){
                unlink(dirname(__DIR__, 3) . $feed->getFilePathImage());
            }
            //delete comments
            $commentsRepository = new CommentRepository();
            $commentsRepository->deleteComments($feed->getId());
            
            //delete student classfeed
            $studentRepository = new StudentRepository();
            $studentRepository->deleteStudents($feed->getId());
            
            // delete feed
            $classFeedRepository->delete($feed);
            // Redirect to feed listing 
             header("Location: ?page=faculty_class_feed&class-id=".$feed->getClassroomId());
        }
        return $this->renderView("/template/feed/faculty_class_feed.phtml");
    }
    
    /*   xmlRetrieve
     *   @return database information with no page reload
     */
    public function xmlRetrieve()
    {
        $classFeedRepository = new ClassFeedRepository();
        $feed = $classFeedRepository->findOne($_GET["feed_id"]);
        print($feed->jsonSerialize());
    }
}
