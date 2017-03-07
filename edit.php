<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

function __autoload($class_name) {
    /** @noinspection PhpIncludeInspection */
    require_once 'class/' . $class_name . '.php';
}

$isOK = true;

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $method = new GetList();
    $recipe = $method->requestRecipe($recipe_id);
    if (!is_null($recipe)) {
        $ingredientList = $recipe['i'];
        //echo count($ingredientList);
        $stepList = $recipe['s'];
        //print_r($stepList);
        $isOK = true;
    }
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
        <?php if ($isOK) { ?>
            <!--<form action="edit.php" method="get" id="auth" >-->
            <?php
            $recipe_id = 0;
            $recipe_name = "";
            $recipe_description = "";
            if (isset($recipe['id']))
                $recipe_id = $recipe['id'];
            if (isset($recipe['name']))
                $recipe_name = $recipe['name'];
            if (isset($recipe['description']))
                $recipe_description = $recipe['description'];
            ?>    

            <form action="save.php" method="get" id="<?php echo $recipe_id; ?>">
                <p><INPUT type="text" name="id" hidden value="<?php echo $recipe_id; ?>"/></p>
                <p>Название: <INPUT type="text" required name="name" maxlength="35" size="50" value="<?php echo ($recipe_name); ?>"/></p>
                <p>Описание: <INPUT type="text" required name="description" maxlength="35" size="50" value="<?php echo ($recipe_description); ?>"/></p>
                <script>
                    data = JSON.parse('<?php echo json_encode($recipe); ?>');
                </script>
                <table>
                    <tr>
                        <td valign="top">
                            <h3>Ингредиенты:</h3>
                            <table id="ingredientsTable" cellspacing="0" border="1" cellpadding="5">
                                <tbody data-max_index="0"><tr><td>Название</td><td>Сколько</td><td>Объем</td><td>Действие</td></tr></tbody>
                <!--                    <tbody data-max_index="<?php echo (count($ingredientList)); ?>"><tr><td>Название</td><td>Сколько</td><td>Объем</td><td>Действие</td></tr></tbody>-->
                            </table>
                            <button type="button" onclick="addIngredient()">Добавить</button>
                            <!--<button type="button" onclick="addIngredient(this)">Добавить</button>-->
                        </td>
                        <td valign="top">
                            <h3>Шаги:</h3>
                            <!--<div style="max-height: 300px; overflow-y: auto; inline-box-align:  ">-->
                            <table id="stepsTable" cellspacing="0" border="1" cellpadding="5">
                                <tbody data-max_index="0">
                                    <tr><td>Описание</td><td>Время</td><td>Фото</td><td>Действие</td></tr>
                                </tbody>
                            </table>
                            <!--</div>-->
                            <button type="button" onclick="addStep(this)">Добавить</button>
                        </td>                    
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <hr>
                            <p><input type="submit" value="Сохранить рецепт"/> <input type="reset" value="Сброс"></p>        
                        </td>
                    </tr>
                </table>

            </div>       
        </form>
        <script>
            printIngredients();
            printSteps();
        </script>

    <?php } else { ?>
        <p>Рецепт не найден</p>
    <?php } ?>
    <hr>
<button onclick="location.href = 'list.php'" id="toList">В список рецептов</button>
</body>
</html>
