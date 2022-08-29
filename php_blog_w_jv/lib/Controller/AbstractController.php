<?php

abstract class AbstractController 
{
    /**
     * @param string $path chemin du template à renvoyer
     * @param array $params tableau avec les paramètres renvoyer dans le template
     * 
     * @return string retour le code html correspond au chemin
     */
    public function renderView(string $path , array $params = []):string
    {
        
        return require_once( dirname(__DIR__, 2) . $path);
        
    }

}
