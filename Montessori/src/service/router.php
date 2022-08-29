<?php

require_once dirname(__DIR__) . "/Controller/HomeController.php";
require_once dirname(__DIR__) . "/Controller/UserController.php";
require_once dirname(__DIR__) . "/Controller/AccountController.php";
require_once dirname(__DIR__) . "/Controller/ClassFeedController.php";


/**
 * Constant stockant le routing de l'application, si on veut rajouter une url c'est ici
 */
const ROUTING = [
    "home" => [
        "controller" => "HomeController",
        "action" => "index"
    ],

    "user_connection" => [
        "controller" => "UserController",
        "action" => "connection"
    ],
    
    "user_deconnection" => [
        "controller" => "UserController",
        "action" => "deconnection"
    ],
    
    "parent" => [
        "controller" => "AccountController",
        "action" => "parent"
    ],
    
    "faculty" => [
        "controller" => "AccountController",
        "action" => "faculty"
    ],
    
    "admin" => [
        "controller" => "AccountController",
        "action" => "admin"
    ],
    
    "class_feed" => [
        "controller" => "ClassFeedController",
        "action" => "feed"
    ],
    
    "faculty_class_feed" => [
        "controller" => "ClassFeedController",
        "action" => "facultyFeed"
    ],
    
    "feed_add" => [
        "controller" => "ClassFeedController",
        "action" => "addFeed"
    ],
    
    "feed_retrieve" => [
        "controller" => "ClassFeedController",
        "action" => "retrieveFeed"
    ],
    
    "feed_edit" => [
        "controller" => "ClassFeedController",
        "action" => "editFeed"
    ],
    
    "feed_edit_publish" => [
        "controller" => "ClassFeedController",
        "action" => "editFeedPublish"
    ],
    
    "xml_edit" => [
        "controller" => "ClassFeedController",
        "action" => "xmlRetrieve"
    ],
    
    "feed_delete" => [
        "controller" => "ClassFeedController",
        "action" => "deleteFeed"
    ],
    
    "feed_comment" => [
        "controller" => "CommentController",
        "action" => "comment"
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
