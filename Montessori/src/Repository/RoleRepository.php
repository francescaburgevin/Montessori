<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__, 2) . "/src/Model/Role.php";

class RoleRepository extends AbstractRepository
{
    /* getById
     * @params int $id
     * @return Role
     */ 
     public function getById(int $id)
    {
        $query = "SELECT * FROM role WHERE id = :id; ";
        $class = "Role";
        $params = [ ":id"=>$id ];
        return ($this->executeQuery($query, $class, $params));
    }
}

