<?php

namespace App\Vaccini;

use App\Utilita;

class Vaccino
{
    public $id;
    public $data;
    public $fkpersona;
    public $sede;
    public $fkdeposito;
    public $stato;

    public static $ANTINFLUENZALE = 'antinfluenzale';
    public static $ANTIPNEUMOCOCCICA = 'antipneumococcica';

    public static $Fluad = 'Fluad';
    public static $VaxigripTetra = 'Vaxigrip Tetra';
    public static $AltroAntinfluenzale = 'Altro antinfluenzale';
    public static $Prevenar = 'Prevenar';

    public static $FORNITO_AUSL = 1;
    public static $FORNITO_PAZIENTE = 2;

    public static $STATO_VACCINATO = 1;
    public static $STATO_LASCIATO_PAZIENTE = 2;
    public static $STATO_SCARTATO = 3;

    public static $SEDE_DX = 1;
    public static $SEDE_SX = 2;

    public function __construct($id, $data, $fkpersona, $sede, $fkdeposito, $stato)
    {
        $this->id = $id;
        $this->data = $data;
        $this->fkpersona = $fkpersona;
        $this->sede = $sede;
        $this->fkdeposito = $fkdeposito;
        $this->stato = $stato;
    }

    public static function Lista()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ListaArray()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ListaToView()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC, vaccinabili.denominazione ASC, vaccini.id DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ListaToPdf()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data ASC, vaccinabili.denominazione ASC, vaccini.id DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function IsANTINFLUENZALE($tipo)
    {
        if ($tipo == Vaccino::$Fluad || $tipo == Vaccino::$VaxigripTetra || $tipo == Vaccino::$AltroAntinfluenzale) {
            return true;
        } else {
            return false;
        }
    }

    public static function IsANTIPNEUMOCOCCO($tipo)
    {
        if ($tipo == Vaccino::$Prevenar) {
            return true;
        } else {
            return false;
        }
    }

    public function ToArray()
    {
        return [
            'id'            => $this->id,
            'data'          => $this->data,
            'fkpersona'     => $this->fkpersona,
            'sede'          => $this->sede,
            'fkdeposito'    => $this->fkdeposito,
            'stato'         => $this->stato
        ];
    }

    public static function ReadByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM vaccini WHERE id = '$id'";
        $sqlArray = $db->exec($sql);
        $el = $sqlArray[0];

        $risposta = new Vaccino($el['id'], \App\Utilita::ConvertToDMY($el['data']), $el['fkpersona'], $el['sede'], $el['fkdeposito'], $el['stato']);

        return $risposta->ToArray();
    }

    public static function ReadCompleteByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino, vaccinabili.id as idvaccinabili, depositi.id as iddepositi FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id WHERE vaccini.id = '$id'";
        $sqlArray = $db->exec($sql);
        $risposta = $sqlArray[0];

        return $risposta;
    }

    public static function EraseByID($id)
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "DELETE FROM vaccini WHERE id = '$id'";
            $db->exec($sql);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return true;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = 'INSERT into vaccini values(null, "' . $this->data . '", ' . $this->fkpersona . ', ' . $this->sede . ', ' . $this->fkdeposito . ', ' . $this->stato . ')';

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function UpdateDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "UPDATE vaccini
                    SET 
                        data = '$this->data',
                        fkpersona = '$this->fkpersona',
                        sede = '$this->sede',
                        fkdeposito = '$this->fkdeposito ',
                        stato= '$this->stato'
                    WHERE id = $this->id
                    ;";

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    
    public static function SvuotaTabellaAntinfluenzale()
    {
        $db = (\App\Db::getInstance())->connect();

        $db->begin();
        $db->exec("DELETE FROM vaccini;");

        $db->commit();
    }

    public static function SvuotaTabellaVaccinabili()
    {
        $db = (\App\Db::getInstance())->connect();

        $db->begin();
        $db->exec("DELETE FROM vaccinabili;");

        $db->commit();
    }

    public static function SvuotaTabellaPrenotazioni()
    {
        $db = (\App\Db::getInstance())->connect();

        $db->begin();
        $db->exec("DELETE FROM prenotazioni;");

        $db->commit();
    }

    public static function SvuotaTabellaDepositi()
    {
        $db = (\App\Db::getInstance())->connect();

        $db->begin();
        $db->exec("DELETE FROM depositi;");

        $db->commit();
    }
}
