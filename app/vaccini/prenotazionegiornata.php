<?php
namespace App\Vaccini;

class PrenotazioneGiornata
{
    public $giorno;
    public $ora;

    public function __construct($giorno, $ora)
    {
        $this->giorno = $giorno;
        $this->ora = $ora;
    }

    public function getGiorno()
    {
        return $this->giorno;
    }

    public function setGiorno($giorno)
    {
        $this->giorno = $giorno;

        return $this;
    }

    public function getOra()
    {
        return $this->ora;
    }

    public function setOra($ora)
    {
        $this->ora = $ora;

        return $this;
    }
}