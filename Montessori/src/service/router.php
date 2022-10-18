<?php

require_once dirname(__DIR__) . "/Controller/HomeController.php";
require_once dirname(__DIR__) . "/Controller/UserController.php";
require_once dirname(__DIR__) . "/Controller/AccountController.php";
require_once dirname(__DIR__) . "/Controller/ClassFeedController.php";
require_once dirname(__DIR__) . "/Controller/CommentController.php";


/*
 * Constant stockant le routing de l'application
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
    
    "user_add" => [
        "controller" => "UserController",
        "action" => "add"
    ],
    
    "xml_username" => [
        "controller" => "UserController",
        "action" => "xmlRetrieve"
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
    
    "parent_class_feed" => [
        "controller" => "ClassFeedController",
        "action" => "parentFeed"
    ],
    
    "faculty_class_feed" => [
        "controller" => "ClassFeedController",
        "action" => "facultyFeed"
    ],
    
    "feed_add" => [
        "controller" => "ClassFeedController",
        "action" => "addFeed"
    ],
    
    "feed_edit" => [
        "controller" => "ClassFeedController",
        "action" => "editFeed"
    ],
    
    "feed_delete" => [
        "controller" => "ClassFeedController",
        "action" => "deleteFeed"
    ],
    
    "xml_edit" => [
        "controller" => "ClassFeedController",
        "action" => "xmlRetrieve"
    ],
    
    "feed_comment" => [
        "controller" => "CommentController",
        "action" => "comment"
    ],
    
    "comment_add" => [
        "controller" => "CommentController",
        "action" => "addComment"
    ],
    
    "comment_edit_publish" => [
        "controller" => "CommentController",
        "action" => "editCommentPublish"
    ]

];

/**
 * function vérifiant l'existence d'une page avant d'instancier 
 * le bon controleur définie dans ROUTING
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
