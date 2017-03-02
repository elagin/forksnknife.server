<?php
//header('HTTP/1.0 200 OK');
//header('Status: 200 Ok');
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name) {
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($_GET);

//if($_GET['recipe_id'])
$recipe = new Recipe($_GET);
echo '<h2>recipe</h2>';
//print_r($recipe);
//print_r($recipe->ingredients);
//print_r($recipe->steps);

/*
foreach ($_GET as $key => $value) {
    echo "$key = " . urldecode($value) . "<br />\n";
}
*/
