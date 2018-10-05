<?php
namespace App;

class ListaTodo
{
    public $todos;

    public function __construct()
    {
        $this->todos = [];
    }

    public function Add($todo)
    {
        $this->todos[] = $todo;
    }

    public function ToArray()
    {
        $risultato = [];
        foreach ($this->todos as $todo) {
            $risultato[] = $todo->ToArray();
        }
        return $risultato;
    }

    public function GetLista()
    {
        return $this->todos;
    }
}
