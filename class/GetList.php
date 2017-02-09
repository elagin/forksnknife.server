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
//        $this->test = TEST;
//        $this->user = new Auth($data);
//        $this->age = isset($data['h']) ? $data['h'] : 24;
//        if ($this->user->isModerator()) $this->test = 1;
        $this->requestList();
        $this->setResult($this->recipes);

        //var_dump($this->result);
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
    private function requestList()
    {
	$query = 'SELECT id, name FROM recipes';

        $stmt = ApkDB::getInstance()->query($query);
        while ($row = $stmt->fetch())
	{
	  $recipe = new Recipe($row);
	  $this->recipes[] = $recipe->get();
	}
        
        
        //$stmt->bind_param('ii', $this->age, $this->test);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $recipe = new Recipe($row);
            $this->recipes[] = $recipe->get();
        }
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
}