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
    public $note;

    public function __construct($id, $data, $tipo, $lotto, $quantita, $scadenza, $note)
    {
        $this->id = $id;
        $this->data = $data;
        $this->tipo = $tipo;
        $this->lotto = $lotto;
        $this->quantita = $quantita;
        $this->scadenza = $scadenza;
        if(empty($note)) {
            $note = "-";
        }
        $this->note = $note;  
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into depositi values(null, "' . $this->data . '", "' . $this->tipo . '", "'. $this->lotto . '", "' . $this->scadenza . '", ' . $this->quantita . ', "' . $this->note . '")';
            
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
            $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["note"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
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
            'note'          => $this->note,
            'notebr'        => nl2br($this->note),
        ];
    }

    public static function ListaVaccini()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM depositi ORDER BY tipo ASC, data DESC";
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Deposito($el["id"], \App\Utilita::ConvertToDMY($el['data']), $el["tipo"], $el["lotto"], $el["quantita"], \App\Utilita::ConvertToDMY($el['scadenza']), $el["note"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }
}