<?php
require_once  dirname(__DIR__) . "/Montessori/src/service/router.php";

//if page xml edit, call controller only, not the whole page (footer, header)
if (isset($_GET["page"]) && $_GET['page'] != 'xml_edit'){
    require_once  dirname(__DIR__) . "/Montessori/template/base.phtml";
}else{

    require_once  dirname(__DIR__) . "/Montessori/template/feed/xml/edit.php";
}