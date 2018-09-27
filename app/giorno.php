<?php
namespace App;

class Giorno {
    
    public $data;
    public $giorno;
    
    public function __construct($data, $giorno) {
        $this->data = $data;
        $this->giorno = $giorno;
    }

    public function ToArray()
    {
        return ['data'=> $this->data, 'giorno'=> $this->giorno];
    }
}