<?php

class Ingredient
{
    private $id;
    private $name;
    private $count;
    private $unit;

    /**
     * Ingredient constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id        = $data['id'];
        $this->name = $data['name'];
        $this->count      = $data['count'];
        $this->unit      = $data['unit'];
    }

    public function get()
    {
        return array(
            'id'  => $this->id,
            'name'   => $this->name,
            'count' => $this->count,
            'unit'   => $this->unit
        );
    }
}
