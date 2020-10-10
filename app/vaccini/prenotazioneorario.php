<?php
namespace App\Vaccini;

class PrenotazioneOrario {
    public $giorno;
    public $ora;
    public $attivo;

    public function __construct($giorno, $ora, $attivo) {
        $this->giorno = $giorno;
        $this->ora = $ora;
        $this->attivo = $attivo;
    }

    public function ToArray()
    {
        return ['giorno' => $this->giorno,
                'ora' => $this->ora,
                'attivo' => $this->attivo
        ];
    }
}