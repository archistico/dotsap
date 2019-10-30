<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

define('FILE_NAME', "pazienti.txt");

echo "Leggo il file ".FILE_NAME."\n";
$handle = fopen(FILE_NAME, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $parti = preg_split("/[\t]/", $line);

        for($i=0; $i<count($parti); $i++) {
            $parti[$i] = pulisciStringa($parti[$i]);
        }

        $cognome = Maiuscola($parti[0]);
        $nome = Maiuscola($parti[1]);
        $datanascita = $parti[2];
        $sesso = $parti[3];
        $codicefiscale = $parti[4];
        $indirizzo = Maiuscola($parti[9]);
        $citta = Maiuscola($parti[10]);
        $telefono = $parti[12];

        $paz = new Paziente($cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono);
        $paz->AddDB();
    }
    fclose($handle);
} else {
    echo "Errore nella lettura del file";
}

class Paziente {

    // dati paziente
    public $cognome;
    public $nome;
    public $datanascita;
    public $sesso;
    public $codicefiscale;
    public $indirizzo;
    public $citta;
    public $telefono;

    // dati privacy
    public $data;
    public $segreteria;
    public $associazione;
    public $sostituti;
    public $consulenti;
    public $softwarehouse;

    public function __construct($cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono) {
        $this->cognome = $cognome;
        $this->nome = $nome;
        $this->datanascita = $datanascita;
        $this->sesso = $sesso;
        $this->codicefiscale = $codicefiscale;
        $this->indirizzo = $indirizzo;
        $this->citta = $citta;
        $this->telefono = $telefono;

        $this->data = null;
        $this->segreteria = 0;
        $this->associazione = 0;
        $this->sostituti = 0;
        $this->consulenti = 0;
        $this->softwarehouse = 0;
    }

    public function AddDB() {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'INSERT into pazienti values(null, "'.$this->cognome.'", "'.$this->nome.'", "'.$this->datanascita.'", "'.$this->sesso.'", "'.$this->codicefiscale.'", "'.$this->indirizzo.'", "'.$this->citta.'", "'.$this->telefono.'", "'.$this->data.'", "'.$this->segreteria.'", "'.$this->associazione.'", "'.$this->sostituti.'", "'.$this->consulenti.'", "'.$this->softwarehouse.'")';

        $db->begin();
        $db->exec($sql);
        $db->commit();

    }

    public function getPrefisso()
    {
        if($this->sesso == 'M') {
            return "Sig.";
        } else {
            return "Sig.ra";
        }
    }

    public function getFirmata() {
        if(is_null($this->data)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function ToArray()
    {
        return [
            'cognome'       => $this->cognome,
            'nome'          => $this->nome,
            'datanascita'   => $this->datanascita,
            'sesso'         => $this->sesso,
            'codicefiscale' => $this->codicefiscale,
            'prefisso'      => $this->getPrefisso(),
            'indirizzo'     => $this->indirizzo,
            'citta'         => $this->citta,
            'telefono'      => $this->telefono,
            'data'          => $this->data,
            'firmata'       => $this->getFirmata(),
            'segreteria'    => $this->segreteria,
            'associazione'  => $this->associazione,
            'sostituti'     => $this->sostituti,
            'consulenti'    => $this->consulenti,
            'softwarehouse' => $this->softwarehouse,
        ];
    }
}

function pulisciStringa($text)
{
    if(!empty($text)) {
        $text = str_replace("- ", " - ", $text);
        $text = str_replace(" -", " - ", $text);
        $text = str_replace("     ", " ", $text);
        $text = str_replace("    ", " ", $text);
        $text = str_replace("   ", " ", $text);
        $text = str_replace("  ", " ", $text);
        $text = str_replace("\"", "", $text);

        $text = str_replace(array("\n", "\r"), "", $text);
        if(!empty($text)) {
            $text = trim($text);
        }
    }
    return $text;
}

function Maiuscola($text)
{
    if(!empty($text)) {
        $text = ucwords(strtolower($text));
        $text = implode('-', array_map('ucfirst', explode('-', $text)));
        $text = implode('\'', array_map('ucfirst', explode('\'', $text)));
    }
    return $text;
}