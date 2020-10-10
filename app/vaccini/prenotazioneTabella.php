<?php
namespace App\Vaccini;

class PrenotazioneTabella
{
    public $listaGiorni;
    public $listaOrari;
    public $listaAppuntamenti;

    public function __construct($listaGiorni, $listaOrari, $listaAppuntamenti)
    {
        $this->listaGiorni = $listaGiorni;
        $this->listaOrari = $listaOrari;
        $this->listaAppuntamenti = $listaAppuntamenti;
    }

    public function SetGiorni($listaGiorni)
    {
        $this->listaGiorni = $listaGiorni;
    }

    public function SetOrari($listaOrari)
    {
        $this->listaOrari = $listaOrari;
    }

    public function SetAppuntamenti($listaAppuntamenti)
    {
        $this->listaAppuntamenti = $listaAppuntamenti;
    }

    public function ToArray()
    {
        $arrs = [];
        $giorni = $this->listaGiorni->ToArray();
        $orari = $this->listaOrari->ToArray();
        $appuntamenti = $this->listaAppuntamenti->ToArray();

        foreach ($giorni as $giorno) {
            $arrs[] = [
                'data' => $giorno['data'],
                'giorno' => $giorno['giorno'],
                'orari' => $this->listaOrari->CercaDaGiorno($giorno['giorno']),
            ];
        }

        foreach ($appuntamenti as $appuntamento) {
            // Se stessa data e stessa ora allora aggiungi dati
            $data = $appuntamento['data'];
            $ora = $appuntamento['ora'];

            for ($c_giorno = 0; $c_giorno < count($arrs); $c_giorno++) {
                if($arrs[$c_giorno]['data'] == $data) {
                    for ($c_ora = 0; $c_ora < count($arrs[$c_giorno]['orari']); $c_ora++) {
                        if($ora == $arrs[$c_giorno]['orari'][$c_ora]['ora']) {
                            $arrs[$c_giorno]['orari'][$c_ora] = array_merge($arrs[$c_giorno]['orari'][$c_ora], $appuntamento);
                        }
                    }
                }                
            }
        }

        return $arrs;
    }
}
