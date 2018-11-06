<?php
session_start();

if (empty($_SESSION['user']['id'])){
    //header('LOCATION:index.php');
}
$_SESSION['user']= [];
$_SESSION['user']['id'] = 1;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');