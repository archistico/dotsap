<?php
namespace App\Vaccini;

use App\Utilita;

class Vaccinabile
{
    public $id;
    public $denominazione;
    public $eta;
    public $rischio;
    public $vaccinato2019;

    public static $VACCINATO_ANNO_PRECEDENTE = 1;
    public static $NON_VACCINATO_ANNO_PRECEDENTE = 0;

    public function __construct($id, $denominazione, $eta, $rischio, $vaccinato2019)
    {
        $this->id = $id;
        $this->denominazione = $denominazione;
        $this->eta = $eta;
        $this->rischio = $rischio;
        if(empty($vaccinato2019) || is_null($vaccinato2019)) {
            $vaccinato2019 = 0;
        }
        $this->vaccinato2019 = $vaccinato2019;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into vaccinabili values(null, "' . $this->denominazione . '", ' . $this->eta . ', "' . $this->rischio . '", ' . $this->vaccinato2019 .');';
            
            // Utilita::Dump($sql);

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
            'denominazione' => $this->denominazione,
            'eta'           => $this->eta,
            'rischio'       => $this->rischio,
            'vaccinato2019' => $this->vaccinato2019,
        ];
    }

    public static function ListaVaccinabili()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM vaccinabili ORDER BY denominazione ASC";
        $listaArray = $db->exec($sql);

        foreach($listaArray as $el) {
            $t = new Vaccinabile($el["id"], $el["denominazione"], $el["eta"], $el["rischio"], $el["vaccinato2019"]);
            $risposta[] = $t->ToArray();
        }

        return $risposta;
    }
}