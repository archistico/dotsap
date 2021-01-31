<?php
namespace App;

class Pazienti
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

    public function Home($f3)
    {
        $listaAlfabetica = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Y", "Z"];
        $f3->set('lista', $listaAlfabetica);

        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/home.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lettera($f3, $params)
    {
        $lettera = $params['lettera'];
        $f3->set('lettera', $lettera);

        $lista = Paziente::ReadByLetter($lettera);
        $f3->set('lista', $lista);

        // Generali
        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/lettera.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo($f3)
    {
        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Salva($f3)
    {
        $cognome = $f3->get('POST.cognome');
        $nome = $f3->get('POST.nome');
        $cf = $f3->get('POST.codicefiscale');
        $indirizzo = $f3->get('POST.indirizzo');
        $citta = $f3->get('POST.citta');
        $sesso = $f3->get('POST.sesso');
        $datanascita = $f3->get('POST.datanascita');

        $cognome = strtoupper($cognome);
        $nome = strtoupper($nome);
        $indirizzo = ucwords(strtolower($indirizzo));
        $citta = ucwords(strtolower($citta));
        $telefono = $f3->get('POST.telefono');
        $lavoro = $f3->get('POST.lavoro');
        $email = $f3->get('POST.email');
        $email = strtolower($email);
        $note = $f3->get('POST.note');
        
        $p = new \App\Paziente(null, $cognome, $nome, $datanascita, $sesso, $cf, $indirizzo, $citta, $telefono, $lavoro, $note, $email);
        $p->AddDB();

        \App\Flash::instance()->addMessage('Paziente aggiunto', 'success');

        $f3->reroute('@pazienti');
    }

    public function Cerca($f3)
    {
        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/cerca.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function CercaLista($f3)
    {
        $testoRicerca = Utilita::PulisciStringaVirgolette($f3->get('POST.nome'));
        $lista = Paziente::Search($testoRicerca);
        $f3->set('lista', $lista);

        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/cercalista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Modifica($f3, $params)
    {
        $id = $params['id'];

        $paziente = Paziente::ReadByID($id);
        $f3->set('p', $paziente->ToArray());

        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/modifica.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function ModificaSQL($f3)
    {
        $id = $f3->get('POST.id');
        $cognome = $f3->get('POST.cognome');
        $nome = $f3->get('POST.nome');
        $cf = $f3->get('POST.codicefiscale');
        $indirizzo = $f3->get('POST.indirizzo');
        $citta = $f3->get('POST.citta');
        $sesso = $f3->get('POST.sesso');
        $datanascita = $f3->get('POST.datanascita');

        $cognome = strtoupper($cognome);
        $nome = strtoupper($nome);
        $indirizzo = ucwords(strtolower($indirizzo));
        $citta = ucwords(strtolower($citta));
        $telefono = $f3->get('POST.telefono');
        $lavoro = $f3->get('POST.lavoro');
        $email = $f3->get('POST.email');
        $email = strtolower($email);
        $note = $f3->get('POST.note');
        
        $p = new \App\Paziente($id, $cognome, $nome, $datanascita, $sesso, $cf, $indirizzo, $citta, $telefono, $lavoro, $note, $email);
        $p->UpdateDB();

        \App\Flash::instance()->addMessage('Paziente modificato', 'success');
        $f3->reroute('@pazienti');
    }

    public function CancellaConferma($f3, $params)
    {
        $id = $params['id'];

        $paziente = \App\Paziente::ReadByID($id);
        $f3->set('paziente', $paziente->ToArray());

        // Generali
        $f3->set('titolo', 'Pazienti');
        $f3->set('contenuto', '/pazienti/cancellaconferma.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Cancella($f3, $params)
    {
        $id = $f3->get('POST.id');
        \App\Paziente::CancellaByID($id);

        \App\Flash::instance()->addMessage("Paziente #$id cancellato", 'success');
        $f3->reroute('@pazienti');
    }
}