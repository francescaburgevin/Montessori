<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";

class HomeController extends AbstractController
{

    /**
     * @return string utilise la methode renderView() définie dans la classe abstrait parent abstractController 
     */
    public function index(): string
    {
        return $this->renderView("/template/home/home_base.phtml");
    }
}
