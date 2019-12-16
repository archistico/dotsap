<?php
namespace App;

class Giornata_check
{
    public $giorno;
    public $ora;
    public $ambulatorio;
    public $vuoto;

    public function __construct($giorno, $ora, $ambulatorio, $vuoto)
    {
        $this->giorno = $giorno;
        $this->ora = $ora;
        $this->ambulatorio = $ambulatorio;
        $this->vuoto = $vuoto;
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

    public function getVuoto()
    {
        return $this->vuoto;
    }

    public function setVuoto($bool)
    {
        $this->vuoto = $bool;

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

    public function getAmbulatorio()
    {
        return $this->ambulatorio;
    }

    public function setAmbulatorio($ambulatorio)
    {
        $this->ambulatorio = $ambulatorio;

        return $this;
    }
}