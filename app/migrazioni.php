<?php

namespace App;

class Migrazioni
{
    // Bisogna essere loggati
    public function beforeroute($f3)
    {
        $auth = \App\Auth::Autentica($f3);
        if (!$auth) {
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    private $messaggi = [];
    private $db;

    public function CreazioneTabella($nometabella, $sql)
    {
        $sql_exist = "SELECT * FROM sqlite_master WHERE name ='$nometabella' and type='table'; ";
        $exist = $this->db->exec($sql_exist);

        if (!$exist) {
            try {
                $this->db->exec($sql);
                $this->messaggi[] = "<i class='fas fa-check'></i> Creazione tabella $nometabella riuscita";
            } catch (\PDOException $e) {
                $this->messaggi[] = "<i class='fas fa-times'></i> Creazione tabella $nometabella fallita";
            }
        } else {
            $this->messaggi[] = "<i class='fas fa-ellipsis-h'></i> Tabella $nometabella già esistente";
        }
    }

    public function AggiornaTabella($nometabella, $sql)
    {
        $sql_exist = "SELECT * FROM sqlite_master WHERE name ='$nometabella' and type='table'; ";
        $exist = $this->db->exec($sql_exist);

        if ($exist) {
            try {
                $this->db->exec($sql);
                $this->messaggi[] = "<i class='fas fa-check'></i> Modifica della tabella $nometabella riuscita";
            } catch (\PDOException $e) {
                $this->messaggi[] = "<i class='fas fa-times'></i> Modifica della tabella $nometabella fallita";
            }
        } else {
            $this->messaggi[] = "<i class='fas fa-ellipsis-h'></i> Tabella $nometabella non esiste";
        }
    }

    public function CancellaTabella($nometabella)
    {
        $sql_exist = "SELECT * FROM sqlite_master WHERE name ='$nometabella' and type='table'; ";
        $exist = $this->db->exec($sql_exist);

        if ($exist) {
            try {
                $this->db->exec("DROP TABLE '$nometabella';");
                $this->messaggi[] = "<i class='fas fa-check'></i> Cancellazione tabella $nometabella riuscita";
            } catch (\PDOException $e) {
                $this->messaggi[] = "<i class='fas fa-times'></i> Cancellazione tabella $nometabella fallita";
            }
        } else {
            $this->messaggi[] = "<i class='fas fa-ellipsis-h'></i> Tabella $nometabella non esiste";
        }
    }

    public function All($f3)
    {
        $this->db = (\App\Db::getInstance())->connect();
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //----------- CREAZIONE TABELLE -----------------

        // $this->CreazioneTabella($db, "", "");
        $this->CreazioneTabella("todo", "CREATE TABLE IF NOT EXISTS 'todo' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'todo' TEXT NOT NULL, 'chi' TEXT NOT NULL );");
        $this->CreazioneTabella("categoria1", "CREATE TABLE IF NOT EXISTS 'categoria1' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL );");
        $this->CreazioneTabella("categoria2", "CREATE TABLE IF NOT EXISTS 'categoria1' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL );");
        $this->CreazioneTabella("categoria3", "CREATE TABLE IF NOT EXISTS 'categoria3' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL, 'madre' INTEGER REFERENCES categoria2(id) ON UPDATE CASCADE );");
        $this->CreazioneTabella("categoria4", "CREATE TABLE IF NOT EXISTS 'categoria4' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL, 'madre' INTEGER REFERENCES categoria3(id) ON UPDATE CASCADE );");
        $this->CreazioneTabella("movimenti", "CREATE TABLE IF NOT EXISTS 'movimenti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 'giorno' INTEGER NOT NULL, 'importo' NUMERIC NOT NULL, 'note' TEXT, 'cat1' INTEGER NOT NULL, 'cat2' INTEGER NOT NULL, 'cat3' INTEGER NOT NULL, 'cat4' INTEGER NOT NULL );");
        $this->CreazioneTabella("orario", "CREATE TABLE IF NOT EXISTS 'orario' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'giorno' TEXT NOT NULL, 'ora' TEXT NOT NULL, 'ambulatorio' TEXT, 'attivo' INTEGER NOT NULL );");
        $this->CreazioneTabella("pazienti", "CREATE TABLE IF NOT EXISTS 'pazienti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'cognome' TEXT NOT NULL, 'nome' TEXT NOT NULL, 'datanascita' TEXT NOT NULL, 'sesso' TEXT, 'codicefiscale' TEXT, 'indirizzo' TEXT, 'citta' TEXT, 'telefono' TEXT, 'data' TEXT, 'segreteria' INTEGER NOT NULL DEFAULT 0, 'associazione' INTEGER NOT NULL DEFAULT 0, 'sostituti' INTEGER NOT NULL DEFAULT 0, 'consulenti' INTEGER NOT NULL DEFAULT 0, 'softwarehouse' INTEGER NOT NULL DEFAULT 0 );");
        $this->CreazioneTabella("richieste", "CREATE TABLE IF NOT EXISTS 'richieste' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'paziente' TEXT NOT NULL, 'data' TEXT NOT NULL, 'farmaco1' TEXT, 'farmaco2' TEXT, 'farmaco3' TEXT, 'farmaco4' TEXT, 'farmaco5' TEXT, 'farmaco6' TEXT, 'farmaco7' TEXT, 'farmaco8' TEXT, 'farmaco9' TEXT, 'note' TEXT );");
        $this->CreazioneTabella("appuntamenti", "CREATE TABLE IF NOT EXISTS 'appuntamenti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'data' INTEGER NOT NULL, 'ora' INTEGER NOT NULL, 'persona' TEXT NOT NULL, 'note' TEXT, 'annullato' INTEGER NOT NULL, 'assente' INTEGER NOT NULL, 'fatto' INTEGER NOT NULL, 'inizio' TEXT, 'fine' TEXT );");
        $this->CreazioneTabella("users", "CREATE TABLE IF NOT EXISTS 'users' ( 'user_id' TEXT NOT NULL UNIQUE, 'password' TEXT NOT NULL, PRIMARY KEY('user_id') );");
        $this->CreazioneTabella("logs", "CREATE TABLE IF NOT EXISTS 'logs' ('id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'data' TEXT NOT NULL, 'ip' TEXT NOT NULL, 'user' TEXT NOT NULL, 'message' TEXT NOT NULL);");
        $this->CreazioneTabella("depositi", "CREATE TABLE 'depositi' ( `id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE, `data` TEXT, `tipo` TEXT, `lotto` TEXT, `scadenza` TEXT, `quantita` INTEGER DEFAULT 0, `fornito` INTEGER DEFAULT 1, `note` TEXT );");
        $this->CreazioneTabella("vaccinabili", "CREATE TABLE 'vaccinabili' ( 'id' INTEGER PRIMARY KEY AUTOINCREMENT, 'denominazione' TEXT NOT NULL, 'eta' INTEGER NOT NULL, 'rischio' TEXT, 'vaccinato2019' INTEGER DEFAULT 0 );");
        $this->CreazioneTabella("vaccini", "CREATE TABLE 'vaccini' ( 'id' INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE, 'data' TEXT NOT NULL, 'fkpersona' INTEGER NOT NULL, 'sede' INTEGER NOT NULL, 'fkdeposito' INTEGER NOT NULL, 'stato' INTEGER NOT NULL );");
        $this->CreazioneTabella("prenotazioni", "CREATE TABLE 'prenotazioni' ( 'idprenotazione' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 'data' TEXT, 'ora' TEXT, 'fkpersona' INTEGER, 'antinfluenzale' TEXT, 'antipneumococco' TEXT, 'fatto' INTEGER );");
        $this->CreazioneTabella("covid", "CREATE TABLE 'covid' ('id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 'fkpaziente' INTEGER NOT NULL, 'datascheda' TEXT, 'datatampone' TEXT, 'stato' TEXT, 'clinica' TEXT, 'comorbidita' TEXT, 'presaincarico' TEXT, 'terapia' TEXT, 'o2'	TEXT, 'esami' TEXT, 'note' TEXT);");
        $this->CreazioneTabella("naotao", "CREATE TABLE 'naotao' ('idnaotao' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'fkpaziente' INTEGER NOT NULL, 'farmaco' TEXT, 'dataultimiesami' TEXT, 'allegatocompilato' INTEGER, 'datafollowup' TEXT, 'esamiprescritti' INTEGER, 'convocare' INTEGER, 'note' TEXT);");

        //$this->CancellaTabella( "richieste_eliminate");
        $this->CreazioneTabella("richieste_eliminate", "CREATE TABLE IF NOT EXISTS 'richieste_eliminate' ( id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'paziente' TEXT NOT NULL, 'data' TEXT NOT NULL, 'farmaco1' TEXT, 'farmaco2' TEXT, 'farmaco3' TEXT, 'farmaco4' TEXT, 'farmaco5' TEXT, 'farmaco6' TEXT, 'farmaco7' TEXT, 'farmaco8' TEXT, 'farmaco9' TEXT, 'note' TEXT );");
        $this->CreazioneTabella("dipendenti", "CREATE TABLE IF NOT EXISTS 'dipendenti' ( id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'cognome' TEXT NOT NULL, 'nome' TEXT NOT NULL );");
        $this->CreazioneTabella("presenze", "CREATE TABLE IF NOT EXISTS 'presenze' ( id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'fkdipendente' INTEGER NOT NULL, 'data' TEXT, 'entrata' TEXT, 'uscita' TEXT, 'note' TEXT );");
        $this->CreazioneTabella("utente", "CREATE TABLE IF NOT EXISTS 'utente' ( 'idutente'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 'username' TEXT UNIQUE, 'password' TEXT NOT NULL, 'role' TEXT NOT NULL);");

        //----------- UPDATE TABELLE -----------------
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'lavoro' TEXT;");
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'stato' TEXT;");
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'note' TEXT;");
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'email' TEXT;");
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'invioricette' INTEGER NOT NULL DEFAULT 0;");
        $this->AggiornaTabella("pazienti", "ALTER TABLE 'pazienti' ADD COLUMN 'datacovid' TEXT;");

        $f3->set('messaggi', $this->messaggi);
        $f3->set('titolo', 'Migrazioni');
        $f3->set('contenuto', 'migrazioni/migrazioni.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Download($f3)
    {
        $file = "database.sqlite";
        $file = "db/" . $file;
        $download_filename = "database_" . date("Y-m-d_H-i-s") . ".sqlite";
        if (!file_exists($file)) {
            die('file not found');
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$download_filename");
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            //header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
}
