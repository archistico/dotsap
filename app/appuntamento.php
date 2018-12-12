<?php
namespace App;

class Appuntamento
{
    // Data Orario Persona Nota Fatto Assente Annullato
    public $data;
    public $ora;
    public $persona;
    public $nota;
    public $fatto;
    public $assente;
    public $annullato;
    public $inizio;

    public function __construct($data, $ora, $persona, $nota, $fatto, $assente, $annullato, $inizio) 
    {
        $this->data = $data;
        $this->ora = $ora;
        $this->persona = $persona;
        $this->nota = $nota;
        $this->fatto = $fatto;
        $this->assente = $assente;
        $this->annullato = $annullato;
        $this->inizio = $inizio;
    }

    public function ToArray()
    {
        return ['data'    => $this->data, 
                'ora'     => $this->ora, 
                'persona' => $this->persona, 
                'nota'    => $this->nota, 
                'fatto'   => $this->fatto, 
                'assente' => $this->assente, 
                'annulato'=> $this->annulato,
                'inizio'=> $this->inizio 
            ];
    }
}