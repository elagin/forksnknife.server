<?php

class Ingredient {

    private $id;
    private $name;
    private $count;
    private $unit;

    /**
     * Ingredient constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->count = $data['count'];
        $this->unit = $data['unit'];
    }

    public function get() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'count' => $this->count,
            'unit' => $this->unit
        );
    }

    public function insert_update($recipe_id) {
        $fields = array("id", "name", "count", "unit", "recipe_id");
        $query = "INSERT INTO ingredients (" . ApkDB::getFields($fields) . ") " .
                " VALUES (" . ApkDB::getPlaceHolders($fields) . ")" .
                " ON DUPLICATE KEY UPDATE " .
                ApkDB::getFieldPlace($fields);
        $stmt = ApkDB::getInstance()->prepare($query);
        $values["id"] = $this->id;
        $values["recipe_id"] = $recipe_id;
        $values["name"] = $this->name;
        $values["count"] = $this->count;
        $values["unit"] = $this->unit;
//        echo $query;
//        print_r($values);
        $stmt->execute($values);
    }
}
