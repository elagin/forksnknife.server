<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name)
{

  print_r($class_name);
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
    print_r($class_name);
}
//const TEST = 1;

$_GET['test'] = 1;
switch ($_GET['m']) {
    case 'list':
        $method = new GetList($_GET);
        break;
    default:
        $method = new WrongMethod();
}

print_r(json_encode($method->getResult()));
