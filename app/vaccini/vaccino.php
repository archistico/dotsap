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
    public $fornito;   

    public function __construct($id, $data, $fkpersona, $sede, $fkdeposito, $stato, $fornito)
    {
        $this->id = $id;
        $this->data = $data;
        $this->fkpersona = $fkpersona;
        $this->sede = $sede;
        $this->fkdeposito = $fkdeposito;
        $this->stato = $stato;
        $this->fornito = $fornito;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into vaccini values(null, "' . $this->data . '", ' . $this->fkpersona . ', ' . $this->sede . ', ' . $this->fkdeposito . ', ' . $this->stato . ', ' . $this->fornito . ')';
            
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

        // foreach($listaArray as $el) {
        //     $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["note"]);
        //     $risposta[] = $t->ToArray();
        // }

        // return $risposta;
    }
}