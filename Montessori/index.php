<?php
require_once  dirname(__DIR__) . "/Montessori/src/service/router.php";

if(!isset($_GET['page']))
{
    header("Location: ?page=home");
}

// reload whole page or partial
if( isset($_GET['page']) && ( $_GET['page'] === 'xml_username' || $_GET['page'] === 'xml_edit' ) )
{
    require_once  dirname(__DIR__) . "/Montessori/template/feed/xml/edit.php";
} else {
        require_once  dirname(__DIR__) . "/Montessori/template/base.phtml";
}