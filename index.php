<?php

session_start(); //Local save start
$_SESSION["STATUS"] = "INACTIEF";
include("DBconfig.php");
include("header.html");
$db = new DB('Exmane_restaurant', 'root', '');//naam database
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}else{
    $page = "home";
}
if ($page) {
    include("pages/" . $page . ".php");
}
include("footer.html");
?>