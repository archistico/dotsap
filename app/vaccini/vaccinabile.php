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

    public function ToArray()
    {
        return [
            'id'            => $this->id,
            'denominazione'          => $this->denominazione,
            'telefono'          => $this->telefono,
            'eta'         => $this->eta,
            'rischio'      => $this->rischio,
        ];
    }

    public static function ListaVaccinabili()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM vaccinabili ORDER BY denominazione ASC";
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Vaccinabile($el["id"], $el["denominazione"], $el["telefono"], $el["eta"], $el["rischio"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }
}