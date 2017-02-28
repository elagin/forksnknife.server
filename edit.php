<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
}

$method = new GetList($_GET);
$recipe = $method->requestRecipe(1);
$ingredientList = $recipe['i'];
$stepList = $recipe['s'];

//print_r($_POST);

?>

<?php
    function insertTextInput($name, $value) {
        return ('<INPUT type="text" name="'. $name .'" maxlength="35" size="50" value="'. $value .'"/>');
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Рецепт</title>
  <script src="index.js"></script>
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
                echo("<tr data-index='$i'>");
                echo('<td>'. insertTextInput("ingredient[$i][name]", $rec['name']) . '</td>');
                echo('<td>'. insertTextInput("ingredient[$i][count]", $rec['count']) . '</td>');
                echo('<td>'. insertTextInput("ingredient[$i][unit]", $rec['unit']) . '</td>');
                echo('<td onclick="removeIngredient(this)">test</td>');
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
                echo("<tr data-index='$i'>");
                echo('<td>'. insertTextInput("step[$i][desc]", $rec['desc']) . '</td>');
                echo('<td>'. insertTextInput("step[$i][time]", $rec['time']) . '</td>');
                echo('<td>'. insertTextInput("step[$i][photo]", $rec['photo']) . '</td>');
                echo('<td onclick="removeStep(this)">test</td>');
                echo("</tr>");
            }
            echo("</table>");
        }
    ?>
 <p><input type="submit" /></p>
</form>
</body>
</html>
