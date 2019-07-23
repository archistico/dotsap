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
    public $datafirma;

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

    public function getData()
    {
        if(is_null($this->data) || empty($this->data)) {
            return null;
        } else {
            $data = \DateTime::createFromFormat('Y-m-d', $this->data);
            return $data->format('d/m/Y');
        }
    }

    public static function ReadByLetter($lettera)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $risposta = [];

        $sql = "SELECT * FROM pazienti WHERE cognome LIKE '$lettera%'";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"]);
            $t->data = $paz["data"];
            $t->datafirma = $t->getData();
            $risposta[] = $t->ToArray();
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
        $risposta = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"]);
        $risposta->data = $paz["data"];
        $risposta->segreteria = $paz["segreteria"];
        $risposta->associazione = $paz["associazione"];
        $risposta->sostituti = $paz["sostituti"];
        $risposta->consulenti = $paz["consulenti"];
        $risposta->softwarehouse = $paz["softwarehouse"];

        return $risposta;
    }

    public static function ModifyPrivacyByID($id, $datafirma, $segreteria, $sostituti, $associati, $consulenti, $softwarehouse)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = "UPDATE pazienti SET data='$datafirma', segreteria='$segreteria', sostituti='$sostituti', associazione='$associati', consulenti='$consulenti', softwarehouse='$softwarehouse'  WHERE id='$id';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function ContaTotalePazienti()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = "SELECT COUNT(id) as totale FROM pazienti;";
        $risSql = $db->exec($sql);
        return $risSql[0]["totale"];
    }

    public static function ContaTotaleFirmate()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = "SELECT COUNT(*) as totale FROM pazienti WHERE data IS NOT NULL AND data!='';";
        $risSql = $db->exec($sql);
        return $risSql[0]["totale"];
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
        if(is_null($this->data) || empty($this->data)) {
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
            'datafirma'     => $this->datafirma,
            'firmata'       => $this->getFirmata(),
            'segreteria'    => $this->segreteria,
            'associazione'  => $this->associazione,
            'sostituti'     => $this->sostituti,
            'consulenti'    => $this->consulenti,
            'softwarehouse' => $this->softwarehouse,
        ];
    }
}
