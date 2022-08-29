<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";

class ContactController extends AbstractController
{

    protected const ARR = [
        "message" => "hello world from array."
    ];
    

    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function index(): string
    {
        return $this->renderView("/template/contact_base.phtml", self::ARR);
    }

   

}

