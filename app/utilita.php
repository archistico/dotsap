<?php
namespace App;

class Utilita 
{
    public static function TimeDiffToMinutes($inizio, $fine) 
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));
        
        // Converti tutto il minuti
        return $diff->format("%H:%I:%S");
    }
}