<?php
namespace App;

class ListaAppuntamenti
{
    public $appuntamenti;

    public function __construct()
    {
        $this->appuntamenti = [];
    }

    public function Add($appuntamento)
    {
        $this->appuntamenti[] = $appuntamento;
    }

    public function ToArray()
    {
        $risultato = [];
        foreach ($this->appuntamenti as $appuntamento) {
            $risultato[] = $appuntamento->ToArray();
        }
        return $risultato;
    }

    public function GetLista()
    {
        return $this->appuntamenti;
    }
}
