<?php
namespace App\Vaccini;

class Vaccinabile
{
    public $id;
    public $denominazione;
    public $telefono;
    public $eta;
    public $rischio;

    public function __construct($id, $denominazione, $telefono, $eta, $rischio)
    {
        $this->id = $id;
        $this->denominazione = $denominazione;
        $this->telefono = $telefono;
        $this->eta = $eta;
        $this->rischio = $rischio;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into vaccinabili values(null, "' . $this->denominazione . '", "' . $this->telefono . '", ' . $this->eta . ', "' . $this->rischio . '")';
            
            // echo $sql;
            
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
}