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
$ingredientList = $recipe['i'];
$stepList = $recipe['s'];
?>

<?php
    function insertTextInput($name, $value) {
        return ('<INPUT type="text" required name="'. $name .'" maxlength="35" size="50" value="'. $value .'"/>');
}
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
    <p>Описание: <INPUT type="text" required name="description" maxlength="35" size="50" value="<?php echo ($recipe['description']); ?>"/></p>
    <?php
        if(count($ingredientList > 0))
        {
            echo('<h3>Ингредиенты:</h3>');
            echo('<table cellspacing="0" border="1" cellpadding="5" >');
            for($i = 0; $i < count($ingredientList); ++$i)
            {
                $rec = $ingredientList[$i];
                echo("<tr>");
                echo('<td>'. insertTextInput("ingredient_name".$i, $rec['name']) . '</td>');
                echo('<td>'. insertTextInput("ingredient_count".$i, $rec['count']) . '</td>');
                echo('<td>'. insertTextInput("ingredient_unit".$i, $rec['unit']) . '</td>');
                echo("</tr>");
            }
            echo("</table>");
        }
        if(count($stepList > 0))
        {
            echo('<h3>Шаги:</h3>');
            echo('<table cellspacing="0" border="1" cellpadding="5" >');
            for($i = 0; $i < count($stepList); ++$i)
            {
                $rec = $stepList[$i];
                echo("<tr>");
                echo('<td>'. insertTextInput("step_desc".$i, $rec['desc']) . '</td>');
                echo('<td>'. insertTextInput("step_time".$i, $rec['time']) . '</td>');
                echo('<td>'. insertTextInput("step_photo".$i, $rec['photo']) . '</td>');
                echo("</tr>");
            }
            echo("</table>");
        }
    ?>
 <p><input type="submit" /></p>
</form>
</body>
</html>
