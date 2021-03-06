<?php
namespace App\Vaccini;

class PrenotazioneOrari
{
    public $orari;

    public function __construct()
    {
        $this->orari = [];
    }

    public function Add($orario)
    {
        $this->orari[] = $orario;
    }

    public function Filtra($giorno)
    {
        $filtro = [];
        foreach ($this->orari as $orario) {
            if ($orario->giorno == $giorno) {
                $filtro[] = $orario;
            }
        }
        return $filtro;
    }

    public function ToArray()
    {
        $risultato = [];
        foreach ($this->orari as $orario) {
            $risultato[] = array('giorno' => $orario->giorno, 'ora' => $orario->ora, 'attivo' => $orario->attivo);
        }
        return $risultato;
    }

    public function GetLista()
    {
        return $this->orari;
    }

    public function CercaDaGiorno($giorno)
    {
        $risultato = [];
        foreach ($this->orari as $orario) {
            if($orario->giorno == $giorno) {
                $risultato[] = array('ora' => $orario->ora, 'attivo' => $orario->attivo);
            }
        }
        return $risultato;
    }
}
