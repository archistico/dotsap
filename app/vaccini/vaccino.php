<?php

namespace App\Vaccini;

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
    public static $Prevenar = 'Prevenar';

    public static $FORNITO_AUSL = 1;
    public static $FORNITO_PAZIENTE = 2;

    public static $STATO_VACCINATO = 1;
    public static $STATO_LASCIATO_PAZIENTE = 2;

    public function __construct($id, $data, $fkpersona, $sede, $fkdeposito, $stato)
    {
        $this->id = $id;
        $this->data = $data;
        $this->fkpersona = $fkpersona;
        $this->sede = $sede;
        $this->fkdeposito = $fkdeposito;
        $this->stato = $stato;
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

        $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function IsANTINFLUENZALE($tipo)
    {
        if ($tipo == Vaccino::$Fluad || $tipo == Vaccino::$VaxigripTetra) {
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
        
        // ->ToArray()
        return $risposta->ToArray();
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
}
