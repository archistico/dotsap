<?php

namespace App\Covid\Controller;

use App\Utilita;

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
        $listapazienti = \App\Paziente::ReadAllName();
        $f3->set('listapazienti', $listapazienti);

        $schede_array = \App\Covid\Model\Covid::ReadAll();
        $stato_positivi = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_POSITIVO);
        $stato_sospetti_in_attesa_di_tampone = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE);
        $stato_sospetti_non_in_attesa_di_tampone = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE);
        $stato_isolamento = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_ISOLAMENTO);
        $stato_negativi = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_NEGATIVO);
        $stato_guariti = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_GUARITO);
        $stato_deceduti = \App\Covid\Model\Covid::Conteggio($schede_array, \App\Covid\Model\Covid::$STATO_DECEDUTO);
        
        $f3->set('stato_positivi', $stato_positivi);
        $f3->set('stato_sospetti', $stato_sospetti_in_attesa_di_tampone + $stato_sospetti_non_in_attesa_di_tampone);
        $f3->set('stato_isolamento', $stato_isolamento);
        $f3->set('stato_negativi', $stato_negativi);
        $f3->set('stato_guariti', $stato_guariti);
        $f3->set('stato_deceduti', $stato_deceduti);

        $schede_array = \App\Covid\Model\Covid::ReadAllOrderByDate();
        $schede_positivi = \App\Covid\Model\Covid::FilterLastByStato($schede_array, \App\Covid\Model\Covid::$STATO_POSITIVO);
        $f3->set('schede_positivi', $schede_positivi);

        $schede_sospetti = \App\Covid\Model\Covid::FilterLastByStato($schede_array, \App\Covid\Model\Covid::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE);
        $f3->set('schede_sospetti', $schede_sospetti);

        $schede_isolamento = \App\Covid\Model\Covid::FilterLastByStato($schede_array, \App\Covid\Model\Covid::$STATO_ISOLAMENTO);
        $f3->set('schede_isolamento', $schede_isolamento);

        $schede_guariti = \App\Covid\Model\Covid::FilterLastByStato($schede_array, \App\Covid\Model\Covid::$STATO_GUARITO);
        $f3->set('schede_guariti', $schede_guariti);

        $schede_deceduti = \App\Covid\Model\Covid::FilterLastByStato($schede_array, \App\Covid\Model\Covid::$STATO_DECEDUTO);
        $f3->set('schede_deceduti', $schede_deceduti);

        $f3->set('titolo', 'Covid');
        $f3->set('script', 'covid.js');
        $f3->set('contenuto', '/covid/covid.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function SchedaNuova($f3, $params)
    {
        $fkpaziente = $params['fkpaziente'];
        
        $paziente = \App\Paziente::ReadByID($fkpaziente);

        $paziente_denominazione = $paziente->cognome ." ". $paziente->nome;
        $f3->set('paziente_denominazione', $paziente_denominazione);
        $paziente_data_di_nascita = $paziente->datanascita;
        $f3->set('paziente_data_di_nascita', $paziente_data_di_nascita);
        
        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/schedanuova.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function SchedaRegistra($f3, $params)
    {
        $fkpaziente = $params['fkpaziente'];
        $datascheda = Utilita::PulisciStringaVirgolette($f3->get('POST.datascheda'));
        $datatampone = Utilita::PulisciStringaVirgolette($f3->get('POST.datatampone'));
        $stato = Utilita::PulisciStringaVirgolette($f3->get('POST.stato'));
        $clinica = Utilita::PulisciStringaVirgolette($f3->get('POST.clinica'));
        $presaincarico = Utilita::PulisciStringaVirgolette($f3->get('POST.presaincarico'));
        $comorbidita = Utilita::PulisciStringaVirgolette($f3->get('POST.comorbidita'));
        $esami = Utilita::PulisciStringaVirgolette($f3->get('POST.esami'));
        $terapia = Utilita::PulisciStringaVirgolette($f3->get('POST.terapia'));
        $ossigeno = Utilita::PulisciStringaVirgolette($f3->get('POST.ossigeno'));
        $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note'));

        $schedacovid = new \App\Covid\Model\Covid(null, $fkpaziente, $datascheda, $datatampone, $stato, $clinica, $presaincarico, $comorbidita, $esami, $terapia, $ossigeno, $note);
        $schedacovid->AddDB();

        \App\Flash::instance()->addMessage('Scheda aggiunta', 'success');
        $f3->reroute('@covid');
    }

    public function Lista($f3)
    {
        $schede_array = \App\Covid\Model\Covid::ReadAllOrderByDate();
        $f3->set('lista', $schede_array);

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/lista.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function SchedaModifica($f3, $params)
    {
        $id = $params['id'];
        $schedaArray = \App\Covid\Model\Covid::ReadByID($id);
       
        $f3->set('paziente_denominazione', $schedaArray['cognome']." ".$schedaArray['nome']);
        $f3->set('paziente_data_di_nascita', $schedaArray['datanascita']);
        
        $f3->set('fkpaziente', $schedaArray['fkpaziente']);
        $f3->set('datascheda', $schedaArray['datascheda']);
        $f3->set('datatampone', $schedaArray['datatampone']);
        $f3->set('stato', $schedaArray['stato']);
        $f3->set('clinica', $schedaArray['clinica']);
        $f3->set('comorbidita', $schedaArray['comorbidita']);
        $f3->set('presaincarico', $schedaArray['presaincarico']);
        $f3->set('terapia', $schedaArray['terapia']);
        $f3->set('o2', $schedaArray['o2']);
        $f3->set('esami', $schedaArray['esami']);
        $f3->set('note', $schedaArray['note']);

        //Utilita::DumpDie($schedaArray);

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/schedamodifica.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function SchedaModificaRegistra($f3, $params)
    {
        $id = $params['id'];
        
        $fkpaziente = Utilita::PulisciStringaVirgolette($f3->get('POST.fkpaziente'));
        $datascheda = Utilita::PulisciStringaVirgolette($f3->get('POST.datascheda'));
        $datatampone = Utilita::PulisciStringaVirgolette($f3->get('POST.datatampone'));
        $stato = Utilita::PulisciStringaVirgolette($f3->get('POST.stato'));
        $clinica = Utilita::PulisciStringaVirgolette($f3->get('POST.clinica'));
        $presaincarico = Utilita::PulisciStringaVirgolette($f3->get('POST.presaincarico'));
        $comorbidita = Utilita::PulisciStringaVirgolette($f3->get('POST.comorbidita'));
        $esami = Utilita::PulisciStringaVirgolette($f3->get('POST.esami'));
        $terapia = Utilita::PulisciStringaVirgolette($f3->get('POST.terapia'));
        $ossigeno = Utilita::PulisciStringaVirgolette($f3->get('POST.ossigeno'));
        $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
        
        $schedacovid = new \App\Covid\Model\Covid($id, $fkpaziente, $datascheda, $datatampone, $stato, $clinica, $presaincarico, $comorbidita, $esami, $terapia, $ossigeno, $note);
        $schedacovid->UpdateDB();

        \App\Flash::instance()->addMessage('Scheda modificata', 'success');
        $f3->reroute('@covid');
    }

    public function SchedaCancellaConferma($f3, $params)
    {
        echo "ok cancella conferma";
    }

    public function SchedaCancellaRegistra($f3, $params)
    {
        echo "ok cancella registra";
    }

    // public function Home($f3)
    // {
    //     $listapazienti = Paziente::ReadAllName();
    //     $f3->set('listapazienti', $listapazienti);

    //     $listapositivi = Paziente::ReadByStato('Positivo');
    //     $listapositivit1 = Paziente::ReadByStato('Primo Tampone negativo');
    //     $listapositivit2 = Paziente::ReadByStato('Secondo Tampone negativo');
    //     $listapositivit3 = Paziente::ReadByStato('Terzo Tampone negativo');

    //     if(count($listapositivit1)>0) {
    //         foreach ($listapositivit1 as $el){
    //             array_push($listapositivi, $el);
    //         }
    //     }

    //     if(count($listapositivit2)>0) {
    //         foreach ($listapositivit2 as $el){
    //             array_push($listapositivi, $el);
    //         }
    //     }

    //     if(count($listapositivit3)>0) {
    //         foreach ($listapositivit3 as $el){
    //             array_push($listapositivi, $el);
    //         }
    //     }

    //     $f3->set('listapositivi', $listapositivi);

    //     $listasospetti = Paziente::ReadByStato('Sospetto in attesa di tampone');
    //     $listasospetti1 = Paziente::ReadByStato('Sospetto non in attesa di tampone');

    //     if(count($listasospetti1)>0) {
    //         foreach ($listasospetti1 as $el){
    //             array_push($listasospetti, $el);
    //         }
    //     }

    //     $f3->set('listasospetti', $listasospetti);

    //     $listadubbi = Paziente::ReadByStato('Sospetto non in attesa di tampone');
    //     $f3->set('listadubbi', $listadubbi);

    //     $listaisolamento = Paziente::ReadByStato('Isolamento');
    //     $f3->set('listaisolamento', $listaisolamento);

    //     $listanegativi = Paziente::ReadByStato('Negativo');
    //     $f3->set('listanegativi', $listanegativi);

    //     $listaguariti = Paziente::ReadByStato('Guarito');
    //     $f3->set('listaguariti', $listaguariti);

    //     $listadeceduti = Paziente::ReadByStato('Deceduto');
    //     $f3->set('listadeceduti', $listadeceduti);

    //     $listaPlaquenil = Paziente::ReadByNote('Plaquenil');
    //     $f3->set('listaplaquenil', $listaPlaquenil);

    //     $f3->set('totalepositivi', count($listapositivi));
    //     $f3->set('totalesospetti', count($listasospetti));
    //     $f3->set('totaleisolamento', count($listaisolamento));
    //     $f3->set('totalenegativi', count($listanegativi));
    //     $f3->set('totaleguariti', count($listaguariti));
    //     $f3->set('totaledeceduti', count($listadeceduti));

    //     $f3->set('titolo', 'Covid');
    //     $f3->set('script', 'covid.js');
    //     $f3->set('contenuto', '/covid/covid.htm');
    //     \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
    //     echo \Template::instance()->render('templates/base.htm');
    // }

    // public function Modifica($f3, $params)
    // {
    //     $id = $params['id'];

    //     $paziente = Paziente::ReadByID($id);
    //     $f3->set('p', $paziente->ToArray());

    //     $f3->set('titolo', 'Covid');
    //     $f3->set('contenuto', '/covid/modifica.htm');
    //     echo \Template::instance()->render('templates/base.htm');
    // }

    // public function ModificaSQL($f3)
    // {
    //     $id = $f3->get('POST.id');
    //     $cognome = Utilita::PulisciStringaVirgolette($f3->get('POST.cognome'));
    //     $nome = Utilita::PulisciStringaVirgolette($f3->get('POST.nome'));
    //     $cf = Utilita::PulisciStringaVirgolette($f3->get('POST.codicefiscale'));
    //     $indirizzo = Utilita::PulisciStringaVirgolette($f3->get('POST.indirizzo'));
    //     $citta = Utilita::PulisciStringaVirgolette($f3->get('POST.citta'));
    //     $sesso = Utilita::PulisciStringaVirgolette($f3->get('POST.sesso'));
    //     $datanascita = Utilita::PulisciStringaVirgolette($f3->get('POST.datanascita'));

    //     $cognome = ucwords(strtolower($cognome));
    //     $nome = ucwords(strtolower($nome));

    //     $indirizzo = ucwords(strtolower($indirizzo));
    //     $citta = ucwords(strtolower($citta));

    //     $telefono = Utilita::PulisciStringaVirgolette($f3->get('POST.telefono'));
    //     $lavoro = Utilita::PulisciStringaVirgolette($f3->get('POST.lavoro'));
    //     $stato = Utilita::PulisciStringaVirgolette($f3->get('POST.stato'));

    //     $email = Utilita::PulisciStringaVirgolette($f3->get('POST.email'));
    //     $email = strtolower($email);

    //     // SEGNA LE MODIFICHE NELLE NOTE
    //     $paziente = \App\Paziente::ReadByID($id);
    //     $statoprecedente = $paziente->stato;

    //     if($stato == $statoprecedente) {
    //         $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
    //     } else {
    //         $note = Utilita::PulisciStringaVirgolette($f3->get('POST.note')) . "\nModifica: " . date("d/m/Y") . " | Stato: ".$statoprecedente." -> ".$stato;
    //     }

    //     $datacovid = Utilita::PulisciStringaVirgolette($f3->get('POST.datacovid'));

    //     $p = new \App\Paziente($id, $cognome, $nome, $datanascita, $sesso, $cf, $indirizzo, $citta, $telefono, $lavoro, $note, $stato, $email, $datacovid);
    //     $p->UpdateDB();

    //     \App\Flash::instance()->addMessage('Paziente modificato', 'success');

    //     $f3->reroute('/covid');
    // }
}
