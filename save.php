<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name) {
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
}

$recipe = new Recipe($_GET);
print_r($recipe->steps);
$recipe->insert_update();
//header('Location: list.php');
//die();
