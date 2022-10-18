<?php

abstract class AbstractController 
{
    /*   renderView
     *   @param string $path => template to send
     *   @param array $params parameters => array to send in the template
     *   @return string retour html code relative to path
     */
    public function renderView(string $path , array $params = []):string
    {
        //Checks each key to see whether it has a valid variable name. 
        //It also checks for collisions with existing variables in the symbol table. 
        extract($params);
        
        return require_once( dirname(__DIR__, 2) . $path);
    }

}
