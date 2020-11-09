<?php

namespace App\Covid\Model;

use App\Utilita;

class Covid
{
    public $id;
    public $fkpaziente;
    public $datascheda;
    public $datatampone;
    public $stato;
    public $clinica;
    public $presaincarico;
    public $comorbidita;
    public $esami;
    public $terapia;
    public $ossigeno;
    public $note;

    public static $STATO_IGNOTO = "Ignoto";
    public static $STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE = "Sospetto in attesa di tampone";
    public static $STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE = "Sospetto non in attesa di tampone";
    public static $STATO_NEGATIVO = "Negativo";
    public static $STATO_ISOLAMENTO = "Isolamento";
    public static $STATO_POSITIVO = "Positivo";
    public static $STATO_GUARITO = "Guarito";
    public static $STATO_DECEDUTO = "Deceduto";

    public function __construct($id, $fkpaziente, $datascheda, $datatampone, $stato, $clinica, $presaincarico, $comorbidita, $esami, $terapia, $ossigeno, $note) {
        $this->id = $id;
        $this->fkpaziente = $fkpaziente;
        $this->datascheda = $datascheda;
        $this->datatampone = $datatampone;
        $this->stato = $stato;
        $this->clinica = $clinica;
        $this->presaincarico = $presaincarico;
        $this->comorbidita = $comorbidita;
        $this->esami = $esami;
        $this->terapia = $terapia;
        $this->ossigeno = $ossigeno;
        $this->note = $note;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = 'INSERT into covid values(null, :fkpaziente, :datascheda, :datatampone, :stato, :clinica, :comorbidita, :presaincarico, :terapia, :ossigeno, :esami, :note)';

            $db->begin();
            $db->exec($sql, [
                ':fkpaziente' => $this->fkpaziente,
                ':datascheda' => $this->datascheda,
                ':datatampone' => $this->datatampone,
                ':stato' => $this->stato,
                ':clinica' => $this->clinica,
                ':presaincarico' => $this->presaincarico,
                ':comorbidita' => $this->comorbidita,
                ':esami' => $this->esami,
                ':terapia' => $this->terapia,
                ':ossigeno' => $this->ossigeno,
                ':note' => $this->note,
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    // public static function Lista()
    // {
    //     $db = (\App\Db::getInstance())->connect();
    //     $risposta = [];

    //     $sql = "SELECT * FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC";
    //     $listaArray = $db->exec($sql);

    //     return $listaArray;
    // }

    // public static function ListaArray()
    // {
    //     $db = (\App\Db::getInstance())->connect();

    //     $sql = "SELECT * FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC";
    //     $listaArray = $db->exec($sql);

    //     return $listaArray;
    // }

    // public static function ListaToView()
    // {
    //     $db = (\App\Db::getInstance())->connect();

    //     $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id  ORDER BY data DESC, vaccini.id DESC";
    //     $listaArray = $db->exec($sql);

    //     return $listaArray;
    // }

    // public static function IsANTINFLUENZALE($tipo)
    // {
    //     if ($tipo == Vaccino::$Fluad || $tipo == Vaccino::$VaxigripTetra || $tipo == Vaccino::$AltroAntinfluenzale) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public static function IsANTIPNEUMOCOCCO($tipo)
    // {
    //     if ($tipo == Vaccino::$Prevenar) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function ToArray()
    // {
    //     return [
    //         'id'            => $this->id,
    //         'data'          => $this->data,
    //         'fkpersona'     => $this->fkpersona,
    //         'sede'          => $this->sede,
    //         'fkdeposito'    => $this->fkdeposito,
    //         'stato'         => $this->stato
    //     ];
    // }

    // public static function ReadByID($id)
    // {
    //     $db = (\App\Db::getInstance())->connect();

    //     $sql = "SELECT * FROM vaccini WHERE id = '$id'";
    //     $sqlArray = $db->exec($sql);
    //     $el = $sqlArray[0];

    //     $risposta = new Vaccino($el['id'], \App\Utilita::ConvertToDMY($el['data']), $el['fkpersona'], $el['sede'], $el['fkdeposito'], $el['stato']);

    //     return $risposta->ToArray();
    // }

    // public static function ReadCompleteByID($id)
    // {
    //     $db = (\App\Db::getInstance())->connect();

    //     $sql = "SELECT vaccini.*, depositi.*, vaccinabili.*, vaccini.data as datavaccino, vaccini.id as idvaccino, vaccinabili.id as idvaccinabili, depositi.id as iddepositi FROM vaccini INNER JOIN vaccinabili ON vaccini.fkpersona = vaccinabili.id INNER JOIN depositi ON vaccini.fkdeposito = depositi.id WHERE vaccini.id = '$id'";
    //     $sqlArray = $db->exec($sql);
    //     $risposta = $sqlArray[0];

    //     return $risposta;
    // }

    // public static function EraseByID($id)
    // {
    //     try {
    //         $db = (\App\Db::getInstance())->connect();

    //         $sql = "DELETE FROM vaccini WHERE id = '$id'";
    //         $db->exec($sql);
    //     } catch (\Exception $e) {
    //         echo 'Caught exception: ',  $e->getMessage(), "\n";
    //     }

    //     return true;
    // }

    // public function AddDB()
    // {
    //     try {
    //         $db = (\App\Db::getInstance())->connect();

    //         $sql = 'INSERT into vaccini values(null, "' . $this->data . '", ' . $this->fkpersona . ', ' . $this->sede . ', ' . $this->fkdeposito . ', ' . $this->stato . ')';

    //         $db->begin();
    //         $db->exec($sql);
    //         $db->commit();
    //     } catch (\Exception $e) {
    //         echo 'Caught exception: ',  $e->getMessage(), "\n";
    //     }
    // }

    // public function UpdateDB()
    // {
    //     try {
    //         $db = (\App\Db::getInstance())->connect();

    //         $sql = "UPDATE vaccini
    //                 SET 
    //                     data = '$this->data',
    //                     fkpersona = '$this->fkpersona',
    //                     sede = '$this->sede',
    //                     fkdeposito = '$this->fkdeposito ',
    //                     stato= '$this->stato'
    //                 WHERE id = $this->id
    //                 ;";

    //         $db->begin();
    //         $db->exec($sql);
    //         $db->commit();
    //     } catch (\Exception $e) {
    //         echo 'Caught exception: ',  $e->getMessage(), "\n";
    //     }
    // }
}
