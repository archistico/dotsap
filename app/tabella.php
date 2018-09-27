<?php
namespace App;

class Tabella
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
        $arr = [];
        $giorni = [];
        $orari = [];

        foreach ($this->listaGiorni->getLista() as $giorno) {
            foreach ($this->listaOrari->getLista() as $orario) {
                foreach ($this->listaAppuntamenti->getLista() as $appuntamento) {
                    $add = [];
                    if (($giorno->giorno == $orario->giorno) && ($giorno->data == $appuntamento->data) && ($orario->ora == $appuntamento->ora)) {
                        $add = array_merge($giorno->ToArray(), $orario->ToArray(), $appuntamento->ToArray());
                    } else {
                        $add = array_merge($giorno->ToArray(), $orario->ToArray());
                    }
                    $arr[] = $add;
                }

            }
        }

        /* echo "<pre>";
        var_dump($arr);
        echo "</pre>"; */

        return $arr;
    }
}
