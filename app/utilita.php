<?php
namespace App;

class Utilita
{
    public static function Dump($variabile, $nome="")
    {
        echo "<h4>$nome</h4>";
        echo "<pre>";
        var_dump($variabile);
        echo "</pre>";
    }

    public static function DumpDie($variabile, $nome="")
    {
        echo "<h4>$nome</h4>";
        echo "<pre>";
        var_dump($variabile);
        echo "</pre>";
        die();
    }

    public static function TimeDiffToMinutes($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));
        return $diff->format("%H:%I:%S");
    }

    public static function TimeDiffToArray($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));

        // Converti in un array
        return [
            'giorni' => $diff->format("%a"),
            'ore' => $diff->format("%h"),
            'minuti' => $diff->format("%i"),
            'secondi' => $diff->format("%s"),
        ];
    }

    public static function TimeDiffToIntervallo($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));

        $ret = new \App\Intervallo();
        $ret->Make($diff->format("%a"), $diff->format("%h"), $diff->format("%i"),$diff->format("%s"));

        return $ret;
    }

    public static function TimeDiffToDateinterval($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));
        return $diff;
    }

    public static function PulisciStringa($testo)
    {
        $testo = str_replace('"', "", $testo);
        $testo = str_replace("'", "", $testo);
        return $testo;
    }

    public static function PulisciStringaVirgolette($testo)
    {
        $testo = str_replace('"', "", $testo);
        return $testo;
    }

    public static function Anonimize($text) {
        // Da: Pippo Pluto A: Pi. Pl.
        $parti = explode(" ", $text);
        $risultato = "";
        foreach ($parti as $p) {
            $risultato .= " ".(strlen($p) > 2 ? substr($p,0,2)."." : $p);
        }
        return trim($risultato);
    }

    public static function ConvertToDMY($testo)
    {
        if(is_null($testo) || empty($testo)) {
            return null;
        } else {
            $data = \DateTime::createFromFormat('Y-m-d', $testo);
            return $data->format('d/m/Y');
        }
    }
}
