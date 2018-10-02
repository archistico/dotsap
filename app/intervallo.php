<?php
namespace App;

class Intervallo
{

    public $giorni;
    public $ore;
    public $minuti;
    public $secondi;

    public function __construct()
    {
        $this->giorni = 0;
        $this->ore = 0;
        $this->minuti = 0;
        $this->secondi = 0;
    }

    public function Make($giorni, $ore, $minuti, $secondi)
    {
        $this->giorni = (int)$giorni;
        $this->ore = (int)$ore;
        $this->minuti = (int)$minuti;
        $this->secondi = (int)$secondi;
    }

    public function AddSecondi($secondi)
    {
        if (($this->secondi + $secondi) <= 59) {
            $this->secondi += $secondi;
        } else {
            $this->secondi = $this->secondi + $secondi - 60;
            $this->minuti += 1;
        }
    }

    public function AddMinuti($minuti)
    {
        if (($this->minuti + $minuti) <= 59) {
            $this->minuti += $minuti;
        } else {
            $this->minuti = $this->minuti + $minuti - 60;
            $this->ore += 1;
        }
    }

    public function AddOre($ore)
    {
        if (($this->ore + $ore) <= 23) {
            $this->ore += $ore;
        } else {
            $this->ore = $this->ore + $ore - 24;
            $this->giorni += 1;
        }
    }

    public function AddGiorni($giorni)
    {
        $this->giorni += $giorni;
    }

    public function ToString() 
    {
        return "$this->giorni giorni, $this->ore ore, $this->minuti minuti e $this->secondi secondi";
    }

    public function Somma($intervallo)
    {
        $this->AddSecondi($intervallo->secondi);
        $this->AddMinuti($intervallo->minuti);
        $this->AddOre($intervallo->ore);
        $this->AddGiorni($intervallo->giorni);
    }
}
