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

    public function __construct($data, $tipo, $lotto, $quantita, $scadenza, $note)
    {
        $this->data = $data;
        $this->tipo = $tipo;
        $this->lotto = $lotto;
        $this->quantita = $quantita;
        $this->scadenza = $scadenza;
        $this->note = $note;        
    }
}