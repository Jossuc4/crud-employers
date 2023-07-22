<?php
    header('Access-Control-Allow-Origin: *');

    // Allow specific HTTP methods
    header('Access-Control-Allow-Methods: GET, POST');
    
    // Allow specific HTTP headers
    header('Access-Control-Allow-Headers: Content-Type');
    
    // Set response content type
    header('Content-Type: application/json');
    
    $connexion=new PDO("mysql:dbname=GESTION_EMPLOYER;port=3308","root","");
if($_GET["type"]){
    $page=$_GET['type'];
    if(is_file("fonctionnalites/".$page.".php")){
        require "fonctionnalites/".$page.".php";
    }else{
        require "fonctionnalites/404.php";
    }
}