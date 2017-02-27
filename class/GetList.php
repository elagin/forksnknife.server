<?php

class GetList
    extends Core
{
    private $recipes;

    /**
     * GetList constructor.
     * @param array $data
     *
     * l - login
     * p - passHash
     * h - hours ago
     */
    public function __construct($data)
    {
	$this->requestList();
        $this->setResult($this->recipes);
    }
/*    
    private function requestSteps()
    {
    
    $query = 'SELECT id, photo, desc, time
    
				FROM steps a, users b
				WHERE reciple_id = ?';
        $stmt  = ApkDB::getInstance()->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->messages[] = new Message($row);
        }
    }
*/    
    public function requestRecipe($data)
    {
        $query = 'SELECT id, name, description FROM recipes WHERE id = :id';
        $stmt  = ApkDB::getInstance()->prepare($query);
        $stmt->execute(array('id' => $data));
        $row = $stmt->fetch(PDO::FETCH_LAZY);
        $recipe = new Recipe($row);
        return $recipe->get();
    }

    private function requestList()
    {
	$query = 'SELECT id, name FROM recipes';
        $stmt = ApkDB::getInstance()->query($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_LAZY))
        {
            $recipe = new Recipe($row);
            $this->recipes[] = $recipe->get();
        }
    }
}