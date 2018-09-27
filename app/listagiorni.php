<?php
namespace App;

class ListaGiorni
{
    public $giorni;

    public function __construct()
    {
        $this->giorni = [];
    }

    public function Add($giorno)
    {
        $this->giorni[] = $giorno;
    }

    public function ToArray()
    {
        $risultato = [];
        foreach ($this->giorni as $giorno) {
            $risultato[] = $giorno->ToArray();
        }
        return $risultato;
    }

    public function GetLista()
    {
        return $this->giorni;
    }
}
