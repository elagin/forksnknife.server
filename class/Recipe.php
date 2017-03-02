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
            //echo 'Ingredients from GET<br>';
            for ($i = 0; $i < count($data['ingredient']); $i++) {
                $this->ingredients[] = new Ingredient($data['ingredient'][$i]);
            }
        } else {
            //echo 'Ingredients DB<br>';
            $this->requestIngredients();
        }

        if (isset($data['step'])) {
            //echo 'Steps from GET<br>';
            for ($i = 0; $i < count($data['step']); $i++) {
                $step = new Step($data['step'][$i]);
                $step->setRecipleId($this->id);
                $this->steps[] = $step;
            }
        } else {
            //echo 'Steps from DB<br>';
            $this->requestSteps();
        }
        //$this->status      = self::statusWith($data['status']);
        //$this->type        = Cast::accType($data['type']);
        //$this->medicine    = Cast::medicineType($data['med']);
        //$this->test        = $data['test'] == 1 ? true : false;
        //$this->requestHistory();
        //$this->requestIngredients();
        //$this->requestVolunteers();
    }

    /*
     * id - accident id
     * time - unix timestamp
     * a - address
     * d - description
     * s - status
     * o - owner
     * oid - owner Id
     * lat - latitude
     * lon - longitude
     * t - type
     * med - medicine
     * m - messages array
     * v - volunteers array
     * h - history array
     */
    /*
      public function getIngredients()
      {
      return $this->ingredients;
      }
     */

    public function get() {
        $out = array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            /*
              'time' => $this->timestamp,
              'a' => $this->address,
              'd' => $this->description,
              's' => $this->status,
              'o' => $this->owner,
              'oid' => $this->ownerId,
              'lat' => $this->lat,
              'lon' => $this->lon,
              't' => $this->type,
              'med' => $this->medicine,
             */
            's' => array(),
            'i' => array()
//            'h' => array()
        );
        foreach ($this->steps as $step) {
            $out['s'][] = $step->get();
        }

        foreach ($this->ingredients as $ingredient) {
            $out['i'][] = $ingredient->get();
        }
        return $out;
    }

    /*
      private function requestRecipes()
      {

      $query = 'SELECT id, name
      FROM recipes
      WHERE 1 = 1';
      $stmt  = ApkDB::getInstance()->prepare($query);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
      $this->steps[] = new Message($row);
      }
      }
     */

    private function requestSteps() {
        $query = 'SELECT id, photo, description, time
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
    public function update() {
        $query = "UPDATE recipes SET name = :name, description = :description WHERE id = :id";
        $stmt  = ApkDB::getInstance()->prepare($query);
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["description"] = $this->description;
        $stmt->execute($values);
    }
//http://phpfaq.ru/pdo#insert
    public function insert() {
//        $query = 'SELECT id, name, description FROM recipes WHERE id = :id';
//        $stmt  = ApkDB::getInstance()->prepare($query);
//        $stmt->execute(array('id' => $data));
//        $row = $stmt->fetch(PDO::FETCH_LAZY);
//        $recipe = new Recipe($row);
//        return $recipe->get();
//                    'name' => $this->name,
//            'description' => $this->description,

        $allowed = array("name", "description"); // allowed fields
        $sql = "INSERT INTO recipes SET " . pdoSet($allowed, $values);
        $stm = $dbh->prepare($sql);
        $stm->execute($values);
    }

    /*
      private function requestMessages()
      {
      $query = 'SELECT
      a.id,
      a.id_user,
      b.login,
      UNIX_TIMESTAMP(a.modified) AS uxtime,
      a.text
      FROM messages a, users b
      WHERE 1=1
      AND a.id_user=b.id
      AND a.id_ent = ?';
      $stmt  = ApkDB::getInstance()->prepare($query);
      $stmt->bind_param('i', $this->id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
      $this->messages[] = new Message($row);
      }
      }

      private function requestVolunteers()
      {
      $query = 'SELECT
      a.id_user,
      b.login,
      a.status,
      a.timest,
      UNIX_TIMESTAMP(a.timest) AS uxtime
      FROM
      onway a, users b
      WHERE 1=1
      AND a.id = ?
      AND a.id_user = b.id';
      $stmt  = ApkDB::getInstance()->prepare($query);
      $stmt->bind_param('i', $this->id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
      $this->volunteers[] = new Volunteer($row);
      }
      }

      private function requestHistory()
      {
      $query = 'SELECT
      MAX(a.id) AS id,
      a.id_user,
      b.login,
      MAX(UNIX_TIMESTAMP(a.timest)) AS uxtime,
      a.action
      FROM history a, users b
      WHERE 1=1
      AND a.id_user=b.id
      AND a.id_ent = ?';
      $stmt  = ApkDB::getInstance()->prepare($query);
      $stmt->bind_param('i', $this->id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
      $this->history[] = new History($row);
      }
      }

      /*
     * a - active
     * e - ended
     * d - double
     * h - hidden
     * c - conflict
      //

      private static function statusWith($status)
      {
      switch ($status) {
      case "acc_status_act":
      return "a";
      case "acc_status_end":
      return "e";
      case "acc_status_dbl":
      return "d";
      case "acc_status_hide":
      return "h";
      case "acc_status_war":
      return "c";
      default:
      return "a";
      }
      }

      public static function medicineString($medicine)
      {
      switch ($medicine) {
      case "d":
      return "минус";
      case "h":
      return "тяжелый";
      case "l":
      case "wo":
      case "na":
      default:
      return "";
      }
      }

      public static function typeString($type)
      {
      switch ($type) {
      case "b":
      return "Поломка";
      case "1":
      return "Один";
      case "a":
      return "Мот/авто";
      case "m":
      return "Мот/мот";
      case "p":
      return "Мот/пешеход";
      case "o":
      return "Прочее";
      case "s":
      return "Угон";
      default:
      return "Прочее";
      }
      }
     */
}
