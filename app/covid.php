<?php
namespace App;

class Covid
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
        $listapazienti = Paziente::ReadAllName();
        $f3->set('listapazienti', $listapazienti);

        $listapositivi = Paziente::ReadByStato('Positivo');
        $f3->set('listapositivi', $listapositivi);

        $listasospetti = Paziente::ReadByStato('Sospetto in attesa di tampone');
        $f3->set('listasospetti', $listasospetti);

        $listaisolamento = Paziente::ReadByStato('Isolamento');
        $f3->set('listaisolamento', $listaisolamento);

        /*
           <option value="Ignoto">Ignoto</option>
           <option value="Sospetto in attesa di tampone">Sospetto in attesa di tampone</option>
           <option value="Sospetto non in attesa di tampone">Sospetto non in attesa di tampone</option>
           <option value="Negativo">Negativo</option>
           <option value="Isolamento">Isolamento</option>
           <option value="Positivo">Positivo</option>
           <option value="Primo Tampone negativo">Primo Tampone negativo</option>
           <option value="Secondo Tampone negativo">Secondo Tampone negativo</option>
           <option value="Terzo Tampone negativo">Terzo Tampone negativo</option>
           <option value="Guarito">Guarito</option>
           <option value="Deceduto">Deceduto</option>
         */

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/covid.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Show($f3, $params)
    {
        $id = $params['id'];

        $paziente = Paziente::ReadByID($id);
        $f3->set('p', $paziente->ToArray());

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/show.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Edit($f3, $params)
    {
        $id = $params['id'];

        $paziente = Paziente::ReadByID($id);
        $f3->set('p', $paziente->ToArray());

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/edit.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function EditSQL($f3)
    {
        $id = $f3->get('POST.id');
        $cognome = Utilita::PulisciStringaVirgolette($f3->get('POST.cognome'));
        $nome = Utilita::PulisciStringaVirgolette($f3->get('POST.nome'));
        $cf = Utilita::PulisciStringaVirgolette($f3->get('POST.codicefiscale'));
        $indirizzo = Utilita::PulisciStringaVirgolette($f3->get('POST.indirizzo'));
        $citta = Utilita::PulisciStringaVirgolette($f3->get('POST.citta'));
        $sesso = Utilita::PulisciStringaVirgolette($f3->get('POST.sesso'));
        $datanascita = Utilita::ConvertToDMY($f3->get('POST.datanascita'));

        $cognome = ucwords(strtolower($cognome));
        $nome = ucwords(strtolower($nome));

        $indirizzo = ucwords(strtolower($indirizzo));
        $citta = ucwords(strtolower($citta));

        $telefono = Utilita::PulisciStringaVirgolette($f3->get('POST.telefono'));
        $lavoro = Utilita::PulisciStringaVirgolette($f3->get('POST.lavoro'));
        $stato = Utilita::PulisciStringaVirgolette($f3->get('POST.stato'));

        $email = Utilita::PulisciStringaVirgolette($f3->get('POST.email'));
        $email = strtolower($email);

        // SEGNA LE MODIFICHE NELLE NOTE
        $paziente = \App\Paziente::ReadByID($id);
        $statoprecedente = $paziente->stato;

        if($stato == $statoprecedente) {
            $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
        } else {
            $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note')) . "\nModifica: " . date("d/m/Y") . " | Stato: ".$statoprecedente." -> ".$stato;
        }

        $p = new \App\Paziente($id, $cognome, $nome, $datanascita, $sesso, $cf, $indirizzo, $citta, $telefono, $lavoro, $note, $stato, $email);
        $p->UpdateDB();

        \App\Flash::instance()->addMessage('Paziente modificato', 'success');

        $f3->reroute('/covid');
    }
}