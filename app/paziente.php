<?php
namespace App;

class Paziente {

    // dati paziente
    public $id;
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

    public function __construct($id, $cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono)
    {
        $this->id = $id;
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

    public function AddDB()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'INSERT into pazienti values(null, "'.$this->cognome.'", "'.$this->nome.'", "'.$this->datanascita.'", "'.$this->sesso.'", "'.$this->codicefiscale.'", "'.$this->indirizzo.'", "'.$this->citta.'", "'.$this->telefono.'", "'.$this->data.'", "'.$this->segreteria.'", "'.$this->associazione.'", "'.$this->sostituti.'", "'.$this->consulenti.'", "'.$this->softwarehouse.'")';

        $db->begin();
        $db->exec($sql);
        $db->commit();

    }

    public static function ReadByLetter($lettera)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $risposta = [];

        $sql = "SELECT * FROM pazienti WHERE cognome LIKE '$lettera%'";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $risposta[] = (new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"]))->ToArray();
        }

        // Ordina in base a cognome
        usort($risposta, function ($a, $b) {
            return strcmp($a["nomecompleto"], $b["nomecompleto"]);
        });

        return $risposta;
    }

    public static function ReadByID($id)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = "SELECT * FROM pazienti WHERE id = '$id'";
        $pazientiArray = $db->exec($sql);
        $paz = $pazientiArray[0];
        return new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"]);
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
            'id'            => $this->id,
            'cognome'       => $this->cognome,
            'nome'          => $this->nome,
            'nomecompleto'  => $this->cognome . " ". $this->nome,
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
