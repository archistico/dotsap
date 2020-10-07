<?php
namespace App\Vaccini;

class Deposito
{
    public $id;
    public $data;
    public $tipo;
    public $lotto;
    public $scadenza;
    public $quantita;
    public $fornito;
    public $note;

    public function __construct($id, $data, $tipo, $lotto, $quantita, $scadenza, $fornito, $note)
    {
        $this->id = $id;
        $this->data = $data;
        $this->tipo = $tipo;
        $this->lotto = $lotto;
        $this->quantita = $quantita;
        $this->scadenza = $scadenza;
        $this->fornito = $fornito;
        if(empty($note)) {
            $note = "-";
        }
        $this->note = $note;  
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into depositi values(null, "' . $this->data . '", "' . $this->tipo . '", "'. $this->lotto . '", "' . $this->scadenza . '", ' . $this->quantita . ', ' . $this->fornito . ', "' . $this->note . '")';
            
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

        $sql = "SELECT * FROM depositi ORDER BY data ASC";
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["fornito"], $el["note"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }

    public static function ListaArray()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM depositi ORDER BY data ASC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public function ToArray()
    {
        return [
            'id'            => $this->id,
            'data'          => $this->data,
            'tipo'          => $this->tipo,
            'lotto'         => $this->lotto,
            'quantita'      => $this->quantita,
            'scadenza'      => $this->scadenza,
            'fornito'       => $this->fornito,
            'note'          => $this->note,
            'notebr'        => nl2br($this->note),
        ];
    }

    public static function ListaVaccini($tipo)
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        if($tipo == "antinfluenzale") {
            $sql = "SELECT * FROM depositi WHERE tipo = 'Fluad' OR tipo = 'Vaxigrip Tetra' ORDER BY tipo ASC, data DESC";
        } else {
            $sql = "SELECT * FROM depositi WHERE tipo = 'Prevenar' ORDER BY tipo ASC, data DESC";
        }
        
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["fornito"], $el["note"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }

    public static function ListaVacciniGenerico()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM depositi ORDER BY tipo ASC, data DESC";
        
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["fornito"], $el["note"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }

    public static function ReadByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM depositi WHERE id = '$id'";
        $depositiArray = $db->exec($sql);
        $el = $depositiArray[0];
        $risposta = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["fornito"], $el["note"]);

        return $risposta->ToArray();
    }

    public function UpdateDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "UPDATE depositi
                    SET 
                        data = '$this->data',
                        tipo = '$this->tipo',
                        lotto = '$this->lotto',
                        scadenza = '$this->scadenza',
                        quantita = '$this->quantita ',
                        fornito = '$this->fornito',
                        note = '$this->note'
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