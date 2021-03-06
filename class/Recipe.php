<?php

class Recipe {

    private $id;

    //private $description;
    /** @var Step[] $steps */
    //private $steps = array();
    //$ingredients = array();
    /*
      /** @var Volunteer[] $volunteers */
    //private $volunteers = array();

    /**
     * Accident constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];

        if (isset($data['ingredient'])) {
            foreach ($data['ingredient'] as $ingredient) {
                $this->ingredients[] = new Ingredient($ingredient);
            }
        } else {
            $this->requestIngredients();
        }

        if (isset($data['step'])) {
            foreach ($data['step'] as $step) {
                $step = new Step($step);
                $step->setRecipleId($this->id);
                $this->steps[] = $step;
            }
        } else {
            $this->requestSteps();
        }
    }

    public function get() {
        $out = array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            's' => array(),
            'i' => array()
        );
        if (isset($this->steps)) {
            foreach ($this->steps as $step) {
                $out['s'][] = $step->get();
            }
        }
        if (isset($this->ingredients)) {
            foreach ($this->ingredients as $ingredient) {
                $out['i'][] = $ingredient->get();
            }
        }
        return $out;
    }

    private function requestSteps() {
        $query = 'SELECT id, recipe_id, photo, description, time
				FROM steps a
				WHERE recipe_id = :recipe_id
				ORDER BY id';
        $stmt = ApkDB::getInstance()->prepare($query);
        $stmt->execute(array('recipe_id' => $this->id));
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            //echo $row[0] . "\n";
            $this->steps[] = new Step($row);
        }
    }

    private function requestIngredients() {
        $query = 'SELECT id, name, count, unit 
				FROM ingredients
				WHERE recipe_id = :recipe_id
				ORDER BY id';
        $stmt = ApkDB::getInstance()->prepare($query);
        $stmt->execute(array('recipe_id' => $this->id));
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $this->ingredients[] = new Ingredient($row);
        }
    }

    /*
      public function update() {
      $query = "UPDATE recipes SET name = :name, description = :description WHERE id = :id";
      $stmt = ApkDB::getInstance()->prepare($query);
      $values["id"] = $this->id;
      $values["name"] = $this->name;
      $values["description"] = $this->description;
      $stmt->execute($values);
      }
     */

//http://phpfaq.ru/pdo#insert
//    public function insert() {
//        $query = 'SELECT id, name, description FROM recipes WHERE id = :id';
//        $stmt  = ApkDB::getInstance()->prepare($query);
//        $stmt->execute(array('id' => $data));
//        $row = $stmt->fetch(PDO::FETCH_LAZY);
//        $recipe = new Recipe($row);
//        return $recipe->get();
//                    'name' => $this->name,
//            'description' => $this->description,
//        $allowed = array("name", "description"); // allowed fields
//        $sql = "INSERT INTO recipes SET " . pdoSet($allowed, $values);
//        $stm = $dbh->prepare($sql);
//        $stm->execute($values);
//    }

    /*
      public function pdoSet($allowed, &$values, $source = array()) {
      $set = '';
      $values = array();
      if (!$source)
      $source = &$_POST;
      foreach ($allowed as $field) {
      if (isset($source[$field])) {
      $set .= "`" . str_replace("`", "``", $field) . "`" . "=:$field, ";
      $values[$field] = $source[$field];
      }
      }
      return substr($set, 0, -2);
      }
     */


    public function insert() {
        if ($this->id != 0) {
            $this->insert_update();
        } else {
            $fields = array("name", "description");
            $query = "INSERT INTO recipes (" . ApkDB::getFields($fields) . ") " .
                    " VALUES (" . ApkDB::getPlaceHolders($fields) . ")" .
                    " ON DUPLICATE KEY UPDATE " .
                    ApkDB::getFieldPlace($fields);
            $stmt = ApkDB::getInstance()->prepare($query);
            $values["name"] = $this->name;
            $values["description"] = $this->description;
            $stmt->execute($values);
            $last_id = ApkDB::lastInsertId();
            echo 'Insert by id: ' + $last_id;
            $this->ingredients_steps_save($last_id);
        }
    }

    public function insert_update() {
        $fields = array("id", "name", "description");
        $query = "INSERT INTO recipes (" . ApkDB::getFields($fields) . ") " .
                " VALUES (" . ApkDB::getPlaceHolders($fields) . ")" .
                " ON DUPLICATE KEY UPDATE " .
                ApkDB::getFieldPlace($fields);
        $stmt = ApkDB::getInstance()->prepare($query);
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["description"] = $this->description;
        $stmt->execute($values);
        $this->delete_childs($this->id);
        $this->ingredients_steps_save($this->id);
    }

    private function ingredients_steps_save($recipe_id) {
        foreach ($this->ingredients as $ingredient) {
            $ingredient->insert_update($recipe_id);
        }
        foreach ($this->steps as $step) {
            $step->insert_update($recipe_id);
        }
    }

    public function delete_childs($recipe_id) {
        $this->delete_ingredients($recipe_id);
        $this->delete_steps($recipe_id);
/*
        $query = "DELETE FROM recipes WHERE id =  :recipe_id";
        $stmt = $pdo->prepare($sql);
        $values["recipe_id"] = $recipe_id;
        $stmt->execute($values);
 */
    }

    private function delete_ingredients($recipe_id) {
        $query = "DELETE FROM ingredients WHERE recipe_id =  :recipe_id";
        $stmt = ApkDB::getInstance()->prepare($query);
        $values["recipe_id"] = $recipe_id;
        $stmt->execute($values);
    }

    private function delete_steps($recipe_id) {
        $query = "DELETE FROM steps WHERE recipe_id =  :recipe_id";
        $stmt = ApkDB::getInstance()->prepare($query);
        $values["recipe_id"] = $recipe_id;
        $stmt->execute($values);
    }

}
