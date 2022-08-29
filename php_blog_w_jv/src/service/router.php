<?php

//require_once dirname(__DIR__) . "../lib/controller/HomeController.php";

require_once dirname(__DIR__) . "/controller/HomeController.php";
require_once dirname(__DIR__) . "/controller/ContactController.php";
require_once dirname(__DIR__) . "/controller/ArticlesController.php";
require_once dirname(__DIR__) . "/controller/UserController.php";


/**
 * Constant stockant le routing de l'application, si on veut rajouter une url c'est ici
 */
const ROUTING = [
    "home" => [
        "controller" => "HomeController",
        "action" => "index"
    ],

    "contact" => [
        "controller" => "ContactController",
        "action" => "index"
    ],

    "articles" => [
        "controller" => "ArticlesController",
        "action" => "index"
    ],
    
    "article_show" => [
        "controller" => "ArticlesController",
        "action" => "show"
    ],

    "article_add" => [
        "controller" => "ArticlesController",
        "action" => "add"
    ],

    "article_deleted" => [
        "controller" => "ArticlesController",
        "action" => "delete"
    ],

    "user_add" => [
        "controller" => "UserController",
        "action" => "add"
    ],
    
    "user_connexion" => [
        "controller" => "UserController",
        "action" => "connexion"
    ],
    
    "user_deconnexion" => [
        "controller" => "UserController",
        "action" => "deconnexion"
    ]

];

/**
 * function vérifiant l'existence d'une page avant d'instancier le bon controleur définie dans ROUTING
 */
function getRouteFromUrl():void
{
    $path = ROUTING["home"];
    if (isset($_GET["page"]) && isset(ROUTING[$_GET["page"]])) {
        $path =   ROUTING[$_GET["page"]];
    }

    $controller = new $path['controller'];
    $controller->{$path['action']}();
}
