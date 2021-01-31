<?php

namespace App;

class Paziente
{

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

    public function __construct($id, $cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono, $lavoro, $note, $email)
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

        $this->email = $email;
    }

    public function AddDB()
    {
        try {
            $db = (\app\Db::getInstance())->connect();
            $sql = "INSERT INTO pazienti (id, cognome, nome, datanascita, sesso, codicefiscale, indirizzo, citta, telefono, lavoro, note, email)
            VALUES (:id, :cognome, :nome, :datanascita, :sesso, :codicefiscale, :indirizzo, :citta, :telefono, :lavoro, :note, :email)";

            $db->begin();
            $db->exec($sql, [
                ':id' => $this->id,
                ':cognome' => $this->cognome,
                ':nome' => $this->nome,
                ':datanascita' => $this->datanascita,
                ':sesso' => $this->sesso,
                ':codicefiscale' => $this->codicefiscale,
                ':indirizzo' => $this->indirizzo,
                ':citta' => $this->citta,
                ':telefono' => $this->telefono,
                ':lavoro' => $this->lavoro,
                ':note' => $this->note,
                ':email' => $this->email
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            return false;
        }
        return true;
    }

    public function UpdateDB()
    {
        try {
            $db = (\app\Db::getInstance())->connect();
            $sql = "UPDATE pazienti SET 
               cognome = :cognome, 
               nome = :nome, 
               datanascita = :datanascita, 
               sesso = :sesso, 
               codicefiscale = :codicefiscale, 
               indirizzo = :indirizzo, 
               citta = :citta, 
               telefono = :telefono, 
               lavoro = :lavoro, 
               note = :note, 
               email = :email

               WHERE id = :id;
            ";

            $db->begin();
            $db->exec($sql, [
                ':id' => $this->id,
                ':cognome' => $this->cognome,
                ':nome' => $this->nome,
                ':datanascita' => $this->datanascita,
                ':sesso' => $this->sesso,
                ':codicefiscale' => $this->codicefiscale,
                ':indirizzo' => $this->indirizzo,
                ':citta' => $this->citta,
                ':telefono' => $this->telefono,
                ':lavoro' => $this->lavoro,
                ':note' => $this->note,
                ':email' => $this->email
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            return false;
        }
        return true;
    }

    public function getData()
    {
        if (is_null($this->data) || empty($this->data)) {
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

        foreach ($pazientiArray as $paz) {
            // $id, $cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono, $lavoro, $note, $email
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["email"]);
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

        foreach ($pazientiArray as $paz) {
            $t = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["email"]);
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
        $risposta = new Paziente($paz["id"], $paz["cognome"], $paz["nome"], $paz["datanascita"], $paz["sesso"], $paz["codicefiscale"], $paz["indirizzo"], $paz["citta"], $paz["telefono"], $paz["lavoro"], $paz["note"], $paz["email"]);
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
        if ($this->sesso == 'M') {
            return "Sig.";
        } else {
            return "Sig.ra";
        }
    }

    public function getFirmata()
    {
        if (is_null($this->data) || empty($this->data)) {
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
            'nomecompleto'  => $this->cognome . " " . $this->nome,
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
            'email'         => $this->email
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

        $sql = "SELECT id, cognome, nome, datanascita FROM pazienti";
        $pazientiArray = $db->exec($sql);

        foreach ($pazientiArray as $paz) {
            $risposta[] = [
                'id' => $paz["id"],
                'nomecompleto' => $paz["cognome"] . " " . $paz["nome"],
                'datanascita' => $paz["datanascita"]
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

    public static function SvuotaTabellaPazienti()
    {
        $db = (\App\Db::getInstance())->connect();

        $db->begin();
        $db->exec("DELETE FROM pazienti;");

        $db->commit();
    }

    public static function ESISTE($cognome, $nome, $datanascita)
    {
        $db = (\app\Db::getInstance())->connect();
        $sql = "SELECT COUNT() as qt FROM pazienti WHERE cognome = :cognome AND nome = :nome AND datanascita = :datanascita";
        $lista = $db->exec($sql, [
            ':cognome' => $cognome,
            ':nome' => $nome,
            ':datanascita' => $datanascita,
        ]);
        
        if($lista[0]["qt"]==0) {
            return false;
        } else {
            return true;
        }        
    }

    public static function SELECT_ID_BY_COGNOME_NOME_DATANASCITA($cognome, $nome, $datanascita)
    {
        $db = (\app\Db::getInstance())->connect();
        $sql = "SELECT id FROM pazienti WHERE cognome = :cognome AND nome = :nome AND datanascita = :datanascita";
        $lista = $db->exec($sql, [
            ':cognome' => $cognome,
            ':nome' => $nome,
            ':datanascita' => $datanascita,
        ]);
        
        return $lista[0]["id"];        
    }

    public static function ImportaCSV($csv)
    {
        $csv = strtoupper($csv);
        $array_csv = explode("\n", $csv);

        foreach ($array_csv as $linea) {
            if (!empty($linea)) {

                $linea = self::CLEAN_TEXT($linea);
                $parti = preg_split("/[|]/", $linea);

                /* cognome|nome|sesso|nascita|codice_fiscale|eta|telefono|cellulare */
                $cognome = $parti[0];
                $nome = $parti[1];
                $sesso = $parti[2];
                $datanascita = $parti[3];
                $codicefiscale = $parti[4];
                $eta = self::CLEAN_ONLY_NUMBER($parti[5]);
                $telefono = self::CLEAN_ONLY_NUMBER_SPACE($parti[6]);
                $cellulare = self::CLEAN_ONLY_NUMBER_SPACE($parti[7]);

                if ($telefono == $cellulare) {
                    if (!empty($telefono)) {
                        $recapito = self::CLEAN_TEXT($telefono);
                    }
                    if (!empty($cellulare)) {
                        $recapito = self::CLEAN_TEXT($cellulare);
                    }
                } else {
                    $recapito = self::CLEAN_TEXT($telefono . " " . $cellulare);
                }

                // TRASFORMO DATA DA GG/MM/YY IN GG/MM/YYYY GRAZIE ALL'ETA
                $anno_in_corso = date("y");
                if($eta<100) {
                    if($eta>=$anno_in_corso) {
                        $centenario = "19";
                    } else {
                        $centenario = "20";
                    }
                } else {
                    $centenario = "19";
                }
                $datanascita_completa = substr($datanascita, 0, 6).$centenario.substr($datanascita, -2);
                // Utilita::Dump([$eta, $datanascita, $datanascita_completa]);


                // CONTROLLO SE ESISTE GIA
                if (Paziente::ESISTE($cognome, $nome, $datanascita_completa)) {
                    // SE ESISTE AGGIORNO I DATI
                    $id = Paziente::SELECT_ID_BY_COGNOME_NOME_DATANASCITA($cognome, $nome, $datanascita_completa);
                    $paz = new Paziente($id, $cognome, $nome, $datanascita_completa, $sesso, $codicefiscale, "", "", $recapito, "", "", "");
                    $paz->UpdateDB();
                    //echo "Modificato paziente: " . $cognome . " " . $nome . "<br>";
                } else {
                    // SE NON ESISTE ALLORA LO AGGIUNGO
                    $paz = new Paziente(null, $cognome, $nome, $datanascita_completa, $sesso, $codicefiscale, "", "", $recapito, "", "", "");
                    $paz->AddDB();
                    //echo "Aggiunto paziente: " . $cognome . " " . $nome . "<br>";
                }
            }
        }

        // CORREGGERE SQL PAZIENTE CON :cognome ecc.

        // $paz = new Paziente($cognome, $nome, $datanascita, $sesso, $codicefiscale, $indirizzo, $citta, $telefono);
        // $paz->AddDB();
    }

    private static function CLEAN_TEXT($text)
    {
        if (!empty($text)) {
            $text = str_replace("- ", " - ", $text);
            $text = str_replace(" -", " - ", $text);
            $text = str_replace("     ", " ", $text);
            $text = str_replace("    ", " ", $text);
            $text = str_replace("   ", " ", $text);
            $text = str_replace("  ", " ", $text);

            $text = str_replace(array("\n", "\r"), "", $text);
            if (!empty($text)) {
                $text = trim($text);
            }
        }
        return $text;
    }

    private static function CLEAN_ONLY_NUMBER_SPACE($text)
    {
        if (!empty($text)) {
            $output = preg_replace('/[^0-9 ]/', '', $text);
            return $output;
        } else {
            return $text;
        }
    }

    private static function CLEAN_ONLY_NUMBER($text)
    {
        if (!empty($text)) {
            $output = preg_replace('/[^0-9]/', '', $text);
            return $output;
        } else {
            return $text;
        }
    }
}
