<?php

class Step {

    private $id;
    private $recipeId;
    private $description;
    private $time;
    private $photo;

    /**
     * Message constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->recipeId = $data['recipe_id'];
        $this->description = $data['description'];
        $this->time = $data['time'];
        $this->photo = $data['photo'];
    }

    public function get() {
        return array(
            'id' => $this->id,
            'recipeId' => $this->recipeId,
            'description' => $this->description,
            'time' => $this->time,
            'photo' => $this->photo
        );
    }

    public function setRecipleId($value) {
        $this->recipeId = $value;
    }

    public function insert_update($recipe_id) {
        $fields = array("id", "description", "time", "photo", "recipe_id");
        $query = "INSERT INTO steps (" . ApkDB::getFields($fields) . ") " .
                " VALUES (" . ApkDB::getPlaceHolders($fields) . ")" .
                " ON DUPLICATE KEY UPDATE " .
                ApkDB::getFieldPlace($fields);
        $stmt = ApkDB::getInstance()->prepare($query);
        $values["id"] = $this->id;
        $values["recipe_id"] = $recipe_id;
        $values["description"] = $this->description;
        $values["time"] = $this->time;
        $values["photo"] = $this->photo;
        //echo $query;
        //print_r($values);
        $stmt->execute($values);
    }
}
