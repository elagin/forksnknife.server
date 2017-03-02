<?php

class Step
{
    private $id;
    private $recipleId;
    private $desc;
    private $time;
    private $photo;

    /**
     * Message constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id        = $data['id'];
        $this->recipleId = $data['reciple_id'];
        $this->desc      = $data['description'];
        $this->time      = $data['time'];
        $this->photo     = $data['photo'];
    }

    public function get()
    {
        return array(
            'id'  => $this->id,
            'recipleId'   => $this->recipleId,
            'desc' => $this->desc,
            'time'   => $this->time,
	    'photo'   => $this->photo
        );
    }
    
    public function setRecipleId($value)
    {
        $this->recipleId = $value;
    }
}
