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
    public $lavoro;
    public $note;
    public $email;
    
    // dati privacy
    public $data;
    public $segreteria;
    public $associazione;
    public $sostituti;
    public $consulenti;
    public $softwarehouse;
    public $invioricette;
    public $datafirma;

    // stato covid
    public $stato;
    public $datacovid;

    public function __construct($id, $cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono, $lavoro, $note, $stato, $email, $datacovid)
    {
        $this->id = $id;
        $this->cognome = ucwords($cognome);
        $this->nome = ucwords($nome);
        $this->datanascita = $datanascita;
        $this->sesso = strtoupper($sesso);
        $this->codicefiscale = strtoupper($codicefiscale);
        $this->indirizzo = ucwords($indirizzo);
        $this->citta = ucwords($citta);
        $this->telefono = $telefono;

        $this->data = null;
        $this->segreteria = 0;
        $this->associazione = 0;
        $this->sostituti = 0;
        $this->consulenti = 0;
        $this->softwarehouse = 0;
        $this->invioricette = 0;

        $this->lavoro = $lavoro;
        $this->note = $note;
        $this->stato = $stato;

        $this->email = $email;
        $this->datacovid = $datacovid;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = 'INSERT into pazienti values(null, "' . $this->cognome . '", "' . $this->nome . '", "' . $this->datanascita . '", "' . $this->sesso . '", "' . $this->codicefiscale . '", "' . $this->indirizzo . '", "' . $this->citta . '", "' . $this->telefono . '", "' . $this->data . '", "' . $this->segreteria . '", "' . $this->associazione . '", "' . $this->sostituti . '", "' . $this->consulenti . '", "' . $this->softwarehouse . '", "' . $this->lavoro . '", "' . $this->stato . '", "' . $this->note . '", "' . $this->email . '", "' . $this->invioricette . '", "' . $this->datacovid . '")';
            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function UpdateDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "UPDATE pazienti
                    SET 
                         cognome = '$this->cognome',
                         nome = '$this->nome',
                         datanascita = '$this->datanascita',
                         sesso = '$this->sesso',
                         codicefiscale = '$this->codicefiscale',
                         indirizzo = '$this->indirizzo',
                         citta = '$this->citta',
                         telefono = '$this->telefono',
                         lavoro = '$this->lavoro',
                         stato = '$this->stato',
                         note = '$this->note',
                         email = '$this->email',
                         datacovid = '$this->datacovid' 
                    WHERE id = $this->id
                    ;";

            $db->begin();
            $db->exec($sql);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
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
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM pazienti WHERE cognome LIKE '$lettera%'";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["stato"], $paz["email"], $paz["datacovid"]);
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

    public static function ReadByStato($stato)
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM pazienti WHERE stato = '$stato'";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["stato"], $paz["email"], $paz["datacovid"]);
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

    // Trattato con Plaquenil
    public static function ReadByNote($str)
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];
        // LIKE '%cats%'

        $sql = "SELECT * FROM pazienti WHERE note LIKE '%$str%'";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["stato"], $paz["email"], $paz["datacovid"]);
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


    public static function Search($testoRicerca)
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT * FROM pazienti WHERE cognome LIKE '$testoRicerca%' OR nome  LIKE '$testoRicerca%';";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["stato"], $paz["email"], $paz["datacovid"]);
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
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM pazienti WHERE id = '$id'";
        $pazientiArray = $db->exec($sql);
        $paz = $pazientiArray[0];
        $risposta = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["stato"], $paz["email"], $paz["datacovid"]);
        $risposta->data = $paz["data"];
        $risposta->segreteria = $paz["segreteria"];
        $risposta->associazione = $paz["associazione"];
        $risposta->sostituti = $paz["sostituti"];
        $risposta->consulenti = $paz["consulenti"];
        $risposta->softwarehouse = $paz["softwarehouse"];
        $risposta->invioricette = $paz["invioricette"];

        $risposta->lavoro = $paz["lavoro"];
        $risposta->note = $paz["note"];
        $risposta->stato = $paz["stato"];
        $risposta->email = $paz["email"];
        $risposta->datacovid = $paz["datacovid"];

        return $risposta;
    }

    public static function ModifyPrivacyByID($id, $datafirma, $segreteria, $sostituti, $associati, $consulenti, $softwarehouse, $invioricette)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "UPDATE pazienti SET data='$datafirma', segreteria='$segreteria', sostituti='$sostituti', associazione='$associati', consulenti='$consulenti', softwarehouse='$softwarehouse', invioricette='$invioricette'  WHERE id='$id';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function CancellaByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "DELETE FROM pazienti WHERE id='$id';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function ContaTotalePazienti()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT COUNT(id) as totale FROM pazienti;";
        $risSql = $db->exec($sql);
        return $risSql[0]["totale"];
    }

    public static function ContaTotaleFirmate()
    {
        $db = (\App\Db::getInstance())->connect();

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
            'invioricette'  => $this->invioricette,
            'lavoro'        => $this->lavoro,
            'note'          => $this->note,
            'notebr'        => nl2br($this->note),
            'stato'         => $this->stato,
            'email'         => $this->email,
            'datacovid'     => $this->datacovid,
        ];
    }

    public static function AllSigned()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM pazienti WHERE data IS NOT NULL AND data != '' ORDER BY data ASC, cognome ASC, nome ASC";
        
        return $db->exec($sql);
    }

    public static function ReadAllName()
    {
        $db = (\App\Db::getInstance())->connect();
        $risposta = [];

        $sql = "SELECT id, cognome, nome FROM pazienti";
        $pazientiArray = $db->exec($sql);

        foreach($pazientiArray as $paz) {
            $risposta[] = [
                'id' => $paz["id"],
                'nomecompleto' => $paz["cognome"] . " ". $paz["nome"]
            ];
        }

        // Ordina in base a cognome
        usort($risposta, function ($a, $b) {
            return strcmp($a["nomecompleto"], $b["nomecompleto"]);
        });

        return $risposta;
    }

    public static function SvuotaPrivacy()
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "UPDATE pazienti SET data='', segreteria='0', sostituti='0', associazione='0', consulenti='0', softwarehouse='0', invioricette='0';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function CancellaPrivacyByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "UPDATE pazienti SET data='', segreteria='0', sostituti='0', associazione='0', consulenti='0', softwarehouse='0', invioricette='0' WHERE id='$id';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function ModifyEmailByID($id, $email)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "UPDATE pazienti SET email='$email' WHERE id='$id';";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }
}
