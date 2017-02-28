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
print_r($_POST);

?>

<?php
    function insertTextInput($name, $value, $size) {
        //return ('<INPUT type="text" name="'. $name .'" maxlength="35" size="50" value="'. $value .'"/>');
        return ('<INPUT type="text" name="'. $name .'" maxlength="'. $size .'" size="'. $size .'" value="'. $value .'"/>');
}
?>

<?php
    function insertTextarea($name, $value) {
        return ('<textarea name="'. $name .'" cols="80" rows="5" >'. $value .'</textarea>');
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
    <script>
        data = JSON.parse('<?php echo json_encode($recipe);?>');
    </script>
    
    <h3>Ингредиенты:</h3>
    <table id="ingredientsTable" cellspacing="0" border="1" cellpadding="5" data-max_index=' .count($ingredientList). '>
        <tbody></tbody>
    </table>
    <button type="button" onclick="addIngredient(this)">Добавить</button>
    <?php
/*
        if(count($ingredientList > 0))
        {
            echo("\n");
            echo('<h3>Ингредиенты:</h3>');
            echo('<table id="ingredientsTable" cellspacing="0" border="1" cellpadding="5" data-max_index=' .count($ingredientList). '>');
            echo("<tr>");
            echo('<td>Название</td><td>Объем</td><td>Количество</td>');
            echo("</tr>");
            echo("\n");
            for($i = 0; $i < count($ingredientList); ++$i)
            {
                $rec = $ingredientList[$i];
                echo("<tr data-index='$i'>");
                //echo('<td>'. insertTextInput("ingredient[$i][name]", $rec['name'], 50) . '</td>');
                //var name = addInputIngredient(idx, 'name', "", 50);
                echo('<script type="text/javascript">addInputIngredient('.$i.', name, 50);</script>');
                echo('<td>'. insertTextInput("ingredient[$i][count]", $rec['count'], 5) . '</td>');
                echo('<td>'. insertTextInput("ingredient[$i][unit]", $rec['unit'], 10) . '</td>');
                echo('<td onclick="removeIngredient(this)">Удалить</td>');
                echo("</tr>");
                echo("\n");
            }
//            echo("<tr>");
//            echo('<td colspan="3" onclick="addIngredient(this)" align="center" >Добавить</td>');
//            echo("</tr>");
            echo("</table>");
            echo("\n");
            echo('<button type="button" onclick="addIngredient(this)">Добавить</button>');
        }
*/
        if(count($stepList > 0))
        {
            echo("\n");
            echo('<h3>Шаги:</h3>');
            echo('<table cellspacing="0" border="1" cellpadding="5" >');
            echo("<tr>");
            echo('<td>Описание</td><td>Время</td><td>Фото</td>');
            echo("</tr>");
            for($i = 0; $i < count($stepList); ++$i)
            {
                $rec = $stepList[$i];
                echo("<tr data-index='$i'>");
                echo('<td>'. insertTextarea("step[$i][desc]", $rec['desc']) . '</td>');
                echo('<td>'. insertTextInput("step[$i][time]", $rec['time'], 5) . '</td>');
                echo('<td>'. insertTextInput("step[$i][photo]", $rec['photo'], 10) . '</td>');
                echo('<td onclick="removeStep(this)">Удалить</td>');
                echo("</tr>");
                echo("\n");
            }
            echo("<tr>");
            echo('<td colspan="3" onclick="addIngredient(this)" align="center" >Добавить</td>');
            echo("</tr>");
            echo("</table>");
        }
    ?>
 <p><input type="submit" /></p>
</form>
     
    <script>
        printIngredients();
    </script>
</body>
</html>
