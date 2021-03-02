<?php

namespace App\Dipendenti;

use App\Utilita;

class Presenza
{
    public $id;
    public $fkdipendente;
    public $data;
    public $entrata;
    public $uscita;
    public $note;

    public function __construct($id, $fkdipendente, $data, $entrata, $uscita, $note)
    {
        $this->id = $id;
        $this->fkdipendente = $fkdipendente;
        $this->data = $data;
        $this->entrata = $entrata;
        $this->uscita = $uscita;
        if (empty($note)) {
            $note = "-";
        }
        $this->note = $note;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into presenze values(null, "' . $this->fkdipendente . '", "' . $this->data . '", "' . $this->entrata . '", "' . $this->uscita . '", "' . $this->note . '")';

            // Utilita::DumpDie($sql);

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function ListaArray()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM presenze ORDER BY data ASC, entrata ASC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ListaArrayOrderDESC()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM presenze ORDER BY data DESC, entrata DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public function ToArray()
    {
        return [
            'id'            => $this->id,
            'data'          => $this->data,
            'entrata'       => $this->entrata,
            'uscita'        => $this->uscita,
            'note'          => $this->note,
        ];
    }

    public function UpdateDB()
    {
        // try {
        //     $db = (\App\Db::getInstance())->connect();

        //     $sql = "UPDATE depositi
        //             SET 
        //                 data = '$this->data',
        //                 tipo = '$this->tipo',
        //                 lotto = '$this->lotto',
        //                 scadenza = '$this->scadenza',
        //                 quantita = '$this->quantita ',
        //                 fornito = '$this->fornito',
        //                 note = '$this->note'
        //             WHERE id = $this->id
        //             ;";

        //     $db->begin();
        //     $db->exec($sql);
        //     $db->commit();
        // } catch (\Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }
    }

    public static function EraseByID($id)
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "DELETE FROM presenze WHERE id = '$id'";
            $db->exec($sql);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return true;
    }

    public static function Statistiche()
    {
        $risposta = [];
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM presenze ORDER BY data ASC, entrata ASC";
        $listaArray = $db->exec($sql);

        $anno_precedente = null;
        $mese_precedente = null;
        $giorno_precedente = null;

        $risposta = [];

        // ottengo gli anni da considerare
        foreach ($listaArray as $p) {
            $data = explode("-", $p['data']);
            $anno = $data[0];
            $mese = $data[1];
            $giorno = $data[2];

            $entrata = new \Datetime($p['entrata']);
            $uscita = new \Datetime($p['uscita']);

            $ore_lavorate = date_diff($uscita, $entrata);
            $oreminuti = explode(":",$ore_lavorate->format("%h:%i"));
            $ore = $oreminuti[0];
            $minuti = $oreminuti[1];
            $totale_ore = round($ore + $minuti / 60, 2);

            if(($anno_precedente != $anno) || ($mese_precedente != $mese)) {
                $anno_precedente = $anno;
                $mese_precedente = $mese;

                $risposta[$anno_precedente][$mese_precedente] = $totale_ore;
            } else {
                $risposta[$anno_precedente][$mese_precedente] += $totale_ore;
            }
        }

        //Utilita::DumpDie($risposta);
        return $risposta;
    }
}
