<?php

namespace App\Vaccini;

use App\Utilita;
use App\Vaccini\Vaccino;

class Statistiche
{
    public static function Fatti($vaccini, $tipo)
    {
        $fatti = 0;
        foreach($vaccini as $v) {
            if($v["stato"]==1) {
                if($tipo == Vaccino::$ANTINFLUENZALE && ($v['tipo'] == Vaccino::$Fluad || $v['tipo'] == Vaccino::$VaxigripTetra)) {
                    $fatti++;
                }

                if($tipo == Vaccino::$ANTIPNEUMOCOCCICA && ($v['tipo'] == Vaccino::$Prevenar)) {
                    $fatti++;
                }
            }
        }

        return $fatti;
    }

    public static function LasciatiPaziente($vaccini, $tipo)
    {
        $risultato = 0;
        foreach($vaccini as $v) {
            if($v["stato"]==2) {
                if($tipo == Vaccino::$ANTINFLUENZALE && ($v['tipo'] == Vaccino::$Fluad || $v['tipo'] == Vaccino::$VaxigripTetra)) {
                    $risultato++;
                }

                if($tipo == Vaccino::$ANTIPNEUMOCOCCICA && ($v['tipo'] == Vaccino::$Prevenar)) {
                    $risultato++;
                }
            }
        }

        return $risultato;
    }

    public static function Rimanenti($vaccini, $depositi, $tipo)
    {
        $risultato = 0;
    
        return $risultato;
    }
}
