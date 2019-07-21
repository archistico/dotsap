<?php
namespace App;

class Paziente
{
    // Data Orario Persona Nota Fatto Assente Annullato
    public $id;
    public $nome;
    public $cognome;
    public $codicefiscale;

    public $data;
    public $ora;

    public $collaboratori;
    public $associazione;
    public $sostituti;
    public $consulentifiscali;
    public $softwarehouse;

    public function __construct($id, $cognome, $nome, $codicefiscale)
    {
        // $this-> = $;
        $this->id = $id;
        $this->cognome = $cognome;
        $this->nome = $nome;
        $this->codicefiscale = $codicefiscale;
    }

    public function ToArray()
    {
        // ''    => $this->,
        return [
            'id'        => $this->id,
            'cognome'   => $this->cognome,
            'nome'      => $this->nome,
            'nomecompleto'  => $this->cognome . " " . $this->nome,
            'codicefiscale' => $this->codicefiscale,
        ];
    }
}
