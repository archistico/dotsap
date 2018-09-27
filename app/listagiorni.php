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

    public function CercaGiornoSettimana($data)
    {
        // cerca il giorno della settimana
        foreach($this->giorni as $giorno) {
            if($giorno->data == $data) {
                return $giorno->giorno;
            }
        }
    }
}
