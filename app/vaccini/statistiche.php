<?php

namespace App\Vaccini;

use App\Utilita;
use App\Vaccini\Vaccino;

class Statistiche
{
    public static function Fatti($vaccini, $tipo)
    {
        $fatti = 0;
        foreach ($vaccini as $v) {
            if ($v["stato"] == Vaccino::$STATO_VACCINATO) {
                if ($tipo == Vaccino::$ANTINFLUENZALE && Vaccino::IsANTINFLUENZALE($v['tipo'])) {
                    $fatti++;
                }

                if ($tipo == Vaccino::$ANTIPNEUMOCOCCICA && Vaccino::IsANTIPNEUMOCOCCO($v['tipo'])) {
                    $fatti++;
                }
            }
        }

        return $fatti;
    }

    public static function LasciatiPaziente($vaccini, $tipo)
    {
        $risultato = 0;
        foreach ($vaccini as $v) {
            if ($v["stato"] == Vaccino::$STATO_LASCIATO_PAZIENTE) {
                if ($tipo == Vaccino::$ANTINFLUENZALE && Vaccino::IsANTINFLUENZALE($v['tipo'])) {
                    $risultato++;
                }

                if ($tipo == Vaccino::$ANTIPNEUMOCOCCICA && Vaccino::IsANTIPNEUMOCOCCO($v['tipo'])) {
                    $risultato++;
                }
            }
        }

        return $risultato;
    }

    public static function Rimanenti($vaccini, $depositi, $check_tipo)
    {
        $fatti_per_tipo = 0;
        $depositati_per_tipo = 0;

        // Depositati check_tipo - fatti check_tipo
        
        // Calcolo depositati per tipo
        foreach ($depositi as $dep) {

            // Antinfluenzale
            if ($check_tipo == Vaccino::$Fluad && $dep['tipo'] == Vaccino::$Fluad) {
                $depositati_per_tipo += $dep["quantita"];
            }

            if ($check_tipo == Vaccino::$VaxigripTetra && $dep['tipo'] == Vaccino::$VaxigripTetra) {
                $depositati_per_tipo += $dep["quantita"];
            }

            if ($check_tipo == Vaccino::$AltroAntinfluenzale && $dep['tipo'] == Vaccino::$AltroAntinfluenzale) {
                $depositati_per_tipo += $dep["quantita"];
            }

            if ($check_tipo == Vaccino::$Prevenar && $dep['tipo'] == Vaccino::$Prevenar) {
                $depositati_per_tipo += $dep["quantita"];
            }
        }

        // Calcolo fatti per tipo
        foreach ($vaccini as $vac) {
            if ($check_tipo == Vaccino::$Fluad && $vac['tipo'] == Vaccino::$Fluad) {
                $fatti_per_tipo++;
            }

            if ($check_tipo == Vaccino::$VaxigripTetra && $vac['tipo'] == Vaccino::$VaxigripTetra) {
                $fatti_per_tipo++;
            }

            if ($check_tipo == Vaccino::$AltroAntinfluenzale && $vac['tipo'] == Vaccino::$AltroAntinfluenzale) {
                $fatti_per_tipo++;
            }

            if ($check_tipo == Vaccino::$Prevenar && $vac['tipo'] == Vaccino::$Prevenar) {
                $fatti_per_tipo++;
            }
        }

        return $depositati_per_tipo - $fatti_per_tipo;
    }

    public static function Forniti($depositi, $check_tipo, $check_fornito)
    {
        $risultato = 0;

        foreach ($depositi as $dep) {

            // Antinfluenzale
            if ($check_tipo == Vaccino::$ANTINFLUENZALE && Vaccino::IsANTINFLUENZALE($dep['tipo']) && $check_fornito == Vaccino::$FORNITO_AUSL && $dep["fornito"] == Vaccino::$FORNITO_AUSL) {
                $risultato += $dep["quantita"];
            }

            if ($check_tipo == Vaccino::$ANTINFLUENZALE && Vaccino::IsANTINFLUENZALE($dep['tipo']) && $check_fornito == Vaccino::$FORNITO_PAZIENTE && $dep["fornito"] == Vaccino::$FORNITO_PAZIENTE) {
                $risultato += $dep["quantita"];
            }

            // Antipneumococco
            if ($check_tipo == Vaccino::$ANTIPNEUMOCOCCICA && Vaccino::IsANTIPNEUMOCOCCO($dep['tipo']) && $check_fornito == Vaccino::$FORNITO_AUSL && $dep["fornito"] == Vaccino::$FORNITO_AUSL) {
                $risultato += $dep["quantita"];
            }

            if ($check_tipo == Vaccino::$ANTIPNEUMOCOCCICA && Vaccino::IsANTIPNEUMOCOCCO($dep['tipo']) && $check_fornito == Vaccino::$FORNITO_PAZIENTE && $dep["fornito"] == Vaccino::$FORNITO_PAZIENTE) {
                $risultato += $dep["quantita"];
            }
        }

        return $risultato;
    }

    public static function TotalePazienti($vaccinabili)
    {
        $risultato = 0;
        $risultato = count($vaccinabili);

        return $risultato;
    }

    public static function TotalePazientiRischio($vaccinabili)
    {
        $risultato = 0;
        foreach ($vaccinabili as $v) {
            if (strlen($v["rischio"]) > 0 || $v["vaccinato2019"] == Vaccinabile::$VACCINATO_ANNO_PRECEDENTE) {
                $risultato++;
            }
        }

        return $risultato;
    }

    // STATISTICHE PRENOTAZIONI

    public static function Prenotazioni($prenotazioni, $check_tipo)
    {
        $prenotati = 0;

        // Calcolo fatti per tipo
        foreach ($prenotazioni as $p) {
            if ($check_tipo == Vaccino::$Fluad && $p['antinfluenzale'] == Vaccino::$Fluad) {
                $prenotati++;
            }

            if ($check_tipo == Vaccino::$VaxigripTetra && $p['antinfluenzale'] == Vaccino::$VaxigripTetra) {
                $prenotati++;
            }

            if ($check_tipo == Vaccino::$AltroAntinfluenzale && $p['antinfluenzale'] == Vaccino::$AltroAntinfluenzale) {
                $prenotati++;
            }

            if ($check_tipo == Vaccino::$Prevenar && $p['antipneumococco'] == Vaccino::$Prevenar) {
                $prenotati++;
            }
        }

        return $prenotati;
    }
}
