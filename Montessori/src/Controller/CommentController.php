<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/src/Repository/CommentRepository.php";

class CommentController extends AbstractController
{

    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function comment(): string
    {
        //controler si student id = parent id 
       
        
        //$feedComments="";
        //$commentRepository = new CommentRepository;
        $feedComments = $commentRepository->getChildByParent($_GET['feed-id']);
        
        
        
        return $this->renderView("/template/feed/template_part/__feed_comment.phtml", [
            "feedComments"=>$feedComments
            ]);
    }
}
