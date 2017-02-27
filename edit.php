<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
}
//const TEST = 1;
$method = new GetList($_GET);
$recipe = $method->requestRecipe(1);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Рецепт</title>
 </head>
 <body>
<form action="edit.php" method="post">
    <p>Название: <INPUT type="text" required name="name" maxlength="35" size="50" value="<?php echo ($recipe['name']); ?>"/></p>
    <p>Описание: <INPUT type="text" required name="name" maxlength="35" size="50" value="<?php echo ($recipe['description']); ?>"/></p>
    <?php
        if(count($recipe['i'] > 0))
        {
            echo("<table>");
            foreach ($recipe['i'] as $rec)
            {
                echo("<tr>");
                echo('<td>'. $rec['name'] .'</td><td>'. $rec['count'] .'</td><td>'. $rec['unit'] .'</td>');
                echo("</tr>");
            }
            echo("</table>");
        }
        if(count($recipe['s'] > 0))
        {
            echo("<table>");
            foreach ($recipe['s'] as $rec)
            {
                echo("<tr>");
                echo('<td>'. $rec['desc'] .'</td><td>'. $rec['time'] .'</td><td>'. $rec['photo'] .'</td>');
                echo("</tr>");
            }
            echo("</table>");
        }
        
    ?>
 <p><input type="submit" /></p>
</form>
</body>
</html>
