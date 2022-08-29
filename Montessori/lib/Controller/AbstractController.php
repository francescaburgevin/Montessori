<?php

abstract class AbstractController 
{
    /**
     * @param string $path which template to send
     * @param array $params parameters array to send in the template
     * 
     * @return string retour html code relative to path
     */
    public function renderView(string $path , array $params = []):string
    {
        extract($params);
        
        return require_once( dirname(__DIR__, 2) . $path);
        
    }

}
