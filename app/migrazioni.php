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

    public function CreazioneTabella($nometabella, $sql) {
        $sql_exist="SELECT * FROM sqlite_master WHERE name ='$nometabella' and type='table'; ";
        $exist = $this->db->exec($sql_exist);

        if (!$exist) {
            $risultato = $this->db->exec($sql);
            if (!$risultato) {
                $this->messaggi[] = "<i class='fas fa-check'></i> Creazione tabella $nometabella riuscita";
            } else {
                $this->messaggi[] = "<i class='fas fa-times'></i> Creazione tabella $nometabella fallita";
            }
        } else {
            $this->messaggi[] = "<i class='fas fa-ellipsis-h'></i> Tabella $nometabella già esistente";
        }
    }

    public function CancellaTabella($nometabella) {
        $sql_exist="SELECT * FROM sqlite_master WHERE name ='$nometabella' and type='table'; ";
        $exist = $this->db->exec($sql_exist);

        if ($exist) {
            $risultato = $this->db->exec("DROP TABLE '$nometabella';");
            if (!$risultato) {
                $this->messaggi[] = "<i class='fas fa-check'></i> Cancellazione tabella $nometabella riuscita";
            } else {
                $this->messaggi[] = "<i class='fas fa-times'></i> Cancellazione tabella $nometabella fallita";
            }
        } else {
            $this->messaggi[] = "<i class='fas fa-ellipsis-h'></i> Tabella $nometabella non esiste";
        }
    }

    public function All($f3)
    {
        $this->db = new \DB\SQL('sqlite:db/database.sqlite');

        //----------- CREAZIONE TABELLE -----------------

        // $this->CreazioneTabella($db, "", "");
        $this->CreazioneTabella( "todo", "CREATE TABLE IF NOT EXISTS 'todo' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'todo' TEXT NOT NULL, 'chi' TEXT NOT NULL );");
        $this->CreazioneTabella( "categoria1", "CREATE TABLE IF NOT EXISTS 'categoria1' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL );");
        $this->CreazioneTabella( "categoria2", "CREATE TABLE IF NOT EXISTS 'categoria1' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL );");
        $this->CreazioneTabella( "categoria3", "CREATE TABLE IF NOT EXISTS 'categoria3' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL, 'madre' INTEGER REFERENCES categoria2(id) ON UPDATE CASCADE );");
        $this->CreazioneTabella( "categoria4", "CREATE TABLE IF NOT EXISTS 'categoria4' ( 'id' INTEGER PRIMARY KEY, 'descrizione' TEXT NOT NULL, 'madre' INTEGER REFERENCES categoria3(id) ON UPDATE CASCADE );");
        $this->CreazioneTabella( "movimenti", "CREATE TABLE IF NOT EXISTS 'movimenti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 'giorno' INTEGER NOT NULL, 'importo' NUMERIC NOT NULL, 'note' TEXT, 'cat1' INTEGER NOT NULL, 'cat2' INTEGER NOT NULL, 'cat3' INTEGER NOT NULL, 'cat4' INTEGER NOT NULL );");
        $this->CreazioneTabella( "orario", "CREATE TABLE IF NOT EXISTS 'orario' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'giorno' TEXT NOT NULL, 'ora' TEXT NOT NULL, 'ambulatorio' TEXT, 'attivo' INTEGER NOT NULL );");
        $this->CreazioneTabella( "pazienti", "CREATE TABLE IF NOT EXISTS 'pazienti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'cognome' TEXT NOT NULL, 'nome' TEXT NOT NULL, 'datanascita' TEXT NOT NULL, 'sesso' TEXT, 'codicefiscale' TEXT, 'indirizzo' TEXT, 'citta' TEXT, 'telefono' TEXT, 'data' TEXT, 'segreteria' INTEGER NOT NULL DEFAULT 0, 'associazione' INTEGER NOT NULL DEFAULT 0, 'sostituti' INTEGER NOT NULL DEFAULT 0, 'consulenti' INTEGER NOT NULL DEFAULT 0, 'softwarehouse' INTEGER NOT NULL DEFAULT 0 );");
        $this->CreazioneTabella( "richieste", "CREATE TABLE IF NOT EXISTS 'richieste' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'paziente' TEXT NOT NULL, 'data' TEXT NOT NULL, 'farmaco1' TEXT, 'farmaco2' TEXT, 'farmaco3' TEXT, 'farmaco4' TEXT, 'farmaco5' TEXT, 'farmaco6' TEXT, 'farmaco7' TEXT, 'farmaco8' TEXT, 'farmaco9' TEXT, 'note' TEXT );");
        $this->CreazioneTabella( "appuntamenti", "CREATE TABLE IF NOT EXISTS 'appuntamenti' ( 'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'data' INTEGER NOT NULL, 'ora' INTEGER NOT NULL, 'persona' TEXT NOT NULL, 'note' TEXT, 'annullato' INTEGER NOT NULL, 'assente' INTEGER NOT NULL, 'fatto' INTEGER NOT NULL, 'inizio' TEXT, 'fine' TEXT );");
        $this->CreazioneTabella( "users", "CREATE TABLE IF NOT EXISTS 'users' ( 'user_id' TEXT NOT NULL UNIQUE, 'password' TEXT NOT NULL, PRIMARY KEY('user_id') );");

        //$this->CancellaTabella( "richieste_eliminate");
        $this->CreazioneTabella( "richieste_eliminate", "CREATE TABLE IF NOT EXISTS 'richieste_eliminate' ( id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 'paziente' TEXT NOT NULL, 'data' TEXT NOT NULL, 'farmaco1' TEXT, 'farmaco2' TEXT, 'farmaco3' TEXT, 'farmaco4' TEXT, 'farmaco5' TEXT, 'farmaco6' TEXT, 'farmaco7' TEXT, 'farmaco8' TEXT, 'farmaco9' TEXT, 'note' TEXT );");

        //----------- UPDATE TABELLE -----------------

        $f3->set('messaggi', $this->messaggi);
        $f3->set('titolo', 'Migrazioni');
        $f3->set('contenuto', 'migrazioni/migrazioni.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}
