<?php
namespace App;

class Orario {
    public $giorno;
    public $ora;
    public $attivo;
    public $ambulatorio;

    public function __construct($giorno, $ora, $ambulatorio, $attivo) {
        $this->giorno = $giorno;
        $this->ora = $ora;
        $this->ambulatorio = $ambulatorio;
        $this->attivo = $attivo;
    }

    public function ToArray()
    {
        return ['giorno' => $this->giorno,
                'ora' => $this->ora,
                'ambulatorio' => $this->ambulatorio,
                'attivo' => $this->attivo
        ];
    }
}