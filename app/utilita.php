<?php
namespace App;

class Utilita
{
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
}
