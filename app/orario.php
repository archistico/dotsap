<?php
namespace App;

class Orario {
    public $giorno;
    public $ora;
    public $attivo;

    public function __construct($giorno, $ora, $attivo) {
        $this->giorno = $giorno;
        $this->ora = $ora;
        $this->attivo = $attivo;
    }
}