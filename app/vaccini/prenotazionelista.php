<?php
namespace App\Vaccini;

class PrenotazioneLista
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
