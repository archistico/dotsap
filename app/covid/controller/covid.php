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

        //$schede_array = \App\Covid\Model\Covid::ReadAllOrderByDate();
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

    public function ListaPaziente($f3, $params)
    {
        $fkpaziente = $params['fkpaziente'];
        
        $schede_array = \App\Covid\Model\Covid::ReadByFkpaziente($fkpaziente);
        $f3->set('lista', $schede_array);

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/lista.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');

    }

    public function SchedaCancellaConferma($f3, $params)
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

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/schedacancella.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function SchedaCancellaRegistra($f3, $params)
    {
        $id = $params['id'];

        \App\Covid\Model\Covid::EraseByID($id);

        \App\Flash::instance()->addMessage('Scheda cancellata', 'success');
        $f3->reroute('@covid');
    }

    public function PdfStato($f3, $params)
    {
        $stato = $params['stato'];
        if($stato == 'positivi') {
            $schede_array = \App\Covid\Model\Covid::FilterLastByStato(\App\Covid\Model\Covid::ReadAll(), \App\Covid\Model\Covid::$STATO_POSITIVO);
        } else if ($stato == 'sospetti') {
            $schede_array = \App\Covid\Model\Covid::FilterLastByStato(\App\Covid\Model\Covid::ReadAll(), \App\Covid\Model\Covid::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE);
        } else if ($stato == 'isolamento') {
            $schede_array = \App\Covid\Model\Covid::FilterLastByStato(\App\Covid\Model\Covid::ReadAll(), \App\Covid\Model\Covid::$STATO_ISOLAMENTO);
        } else if ($stato == 'guariti') {
            $schede_array = \App\Covid\Model\Covid::FilterLastByStato(\App\Covid\Model\Covid::ReadAll(), \App\Covid\Model\Covid::$STATO_GUARITO);
        } else if ($stato == 'deceduti') {
            $schede_array = \App\Covid\Model\Covid::FilterLastByStato(\App\Covid\Model\Covid::ReadAll(), \App\Covid\Model\Covid::$STATO_DECEDUTO);
        } else {
            \App\Flash::instance()->addMessage('Pdf di categoria non valida', 'danger');
            $f3->reroute('@covid');
        }

        if(count($schede_array)>0) {
            $pdf = new \App\Covid\Controller\SchedaPdf($schede_array);
            $pdf->MakePdf();
        }
    }
}
