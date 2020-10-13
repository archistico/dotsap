<?php

namespace App\Vaccini;

use App\Utilita;

class Prenotazione
{
    public $idprenotazione;
    public $data;
    public $ora;
    public $fkpersona;
    public $antinfluenzale;
    public $antipneumococco;
    public $fatto;

    public function __construct($idprenotazione, $data, $ora, $fkpersona, $antinfluenzale, $antipneumococco, $fatto)
    {
        $this->idprenotazione = $idprenotazione;
        $this->data = $data;
        $this->ora = $ora;
        $this->fkpersona = $fkpersona;
        $this->antinfluenzale = $antinfluenzale;
        $this->antipneumococco = $antipneumococco;
        $this->fatto = $fatto;
    }

    public function ToArray()
    {
        return [
            'idprenotazione'    => $this->idprenotazione,
            'data'              => $this->data,
            'ora'               => $this->ora,
            'fkpersona'         => $this->fkpersona,
            'antinfluenzale'    => $this->antinfluenzale,
            'antipneumococco'   => $this->antipneumococco,
            'fatto'             => $this->fatto
        ];
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $data = Utilita::ConvertToYMD($this->data);
            $sql = "INSERT into prenotazioni values(null, '$data', '$this->ora', $this->fkpersona, '$this->antinfluenzale', '$this->antipneumococco', $this->fatto)";

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function ReadAll()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM prenotazioni WHERE fatto=0";
        $sqlArray = $db->exec($sql);
        $risposta = $sqlArray;

        return $risposta;
    }

    public static function ReadComplete()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM prenotazioni INNER JOIN vaccinabili ON prenotazioni.fkpersona = vaccinabili.id ORDER BY prenotazioni.data ASC, prenotazioni.ora ASC";
        $sqlArray = $db->exec($sql);
        $risposta = $sqlArray;

        return $risposta;
    }

    public static function EraseById($id)
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "DELETE FROM prenotazioni WHERE idprenotazione = '$id'";
            $db->exec($sql);
            
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return true;
    }

    public function UpdateDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $data = Utilita::ConvertToYMD($this->data);

            $sql = "UPDATE prenotazioni
                    SET 
                        data = '$data', 
                        ora = '$this->ora', 
                        fkpersona = $this->fkpersona, 
                        antinfluenzale = '$this->antinfluenzale', 
                        antipneumococco = '$this->antipneumococco', 
                        fatto= $this->fatto 
                    WHERE idprenotazione = $this->idprenotazione
                    ;";

            // Utilita::DumpDie($sql);

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
