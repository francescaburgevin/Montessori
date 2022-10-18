<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";

class HomeController extends AbstractController
{

    /*  index
     *  @return string => template 
     */
    public function index(): string
    {
        return $this->renderView("/template/home/home_base.phtml");
    }
}
