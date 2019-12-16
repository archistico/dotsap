<?php
namespace App;

class Appuntamento_check
{
    public $orari;
    public $appuntamenti;

    public function __construct($orari)
    {
        $this->orari = $orari;
        $this->appuntamenti = array();
    }

    public function AddGiornata(string $giorno, string $ambulatorio, string $inizio, string $fine, array $vuoti): self
    {
        // cerca appuntamenti in cui > inizio e < fine
        $iniziato = false;

        if (array_key_exists($giorno, $this->appuntamenti)) {
            $app = $this->appuntamenti[$giorno];
        } else {
            $app = array();
        }

        foreach ($this->orari->getOrari() as $o) {
            if ($o == $inizio) {
                $iniziato = true;
            }

            if ($o == $fine) {
                $iniziato = false;
            }

            if ($iniziato) {
                $v = array_key_exists($o, $vuoti)?$vuoti[$o]:"";
                $app[] = new \App\Giornata_check($giorno, $o, $ambulatorio, $v);
            }
        }

        $this->appuntamenti[$giorno] = $app;

        return $this;
    }

    public function getAppuntamenti()
    {
        return $this->appuntamenti;
    }

    public function CercaAmbulatorio($g, $o) 
    {
        if(array_key_exists ($g, $this->appuntamenti)) {
            $app_giorno = $this->appuntamenti[$g];
            foreach($app_giorno as $orari) {
                if(($orari->giorno == $g) && $orari->ora == $o) {
                    return $orari->ambulatorio;
                }
            }
        }

        return "";
    }

    public function CercaPrenotabile($g, $o) 
    {
        if(array_key_exists ($g, $this->appuntamenti)) {
            $app_giorno = $this->appuntamenti[$g];
            foreach($app_giorno as $orari) {
                if(($orari->giorno == $g) && $orari->ora == $o) {
                    return true;
                }
            }
        }

        return false;
    }
}