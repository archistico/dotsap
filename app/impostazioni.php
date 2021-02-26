<?php
namespace App;

class Impostazioni
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
        $f3->set('titolo', 'Impostazioni');
        $f3->set('contenuto', '/impostazioni/impostazioni.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function ImportPazienti($f3)
    {
        $f3->set('titolo', 'Impostazioni');
        $f3->set('contenuto', '/impostazioni/import_pazienti.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function ImportPazientiDb($f3)
    {
        $formato = $f3->get('POST.formato');
        $csv = $f3->get('POST.csv');

        if($formato=="generale") {
            Paziente::ImportaCSV($csv);
        } else if($formato=="vaccini") {
            Utilita::DumpDie("vaccini");
        } else {
            \App\Flash::instance()->addMessage('Selezionare uno dei due formati', 'danger');
            $f3->reroute('@impostazioni');
        }
        
        \App\Flash::instance()->addMessage('Pazienti caricati con successo', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaRicette($f3)
    {
        Richiesta::SvuotaTabellaRicetteFatte();
        \App\Flash::instance()->addMessage('Tabella ricette fatte svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaPrivacy($f3)
    {
        Paziente::SvuotaPrivacy();
        \App\Flash::instance()->addMessage('Lista privacy svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaPrenotazioni($f3)
    {
        Appuntamenti::SvuotaTabellaAppuntamenti();
        \App\Flash::instance()->addMessage('Tabella appuntamenti svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaSchedeCovid($f3)
    {
        Covid::SvuotaTabellaSchedeCovid();
        \App\Flash::instance()->addMessage('Tabella schede covid svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaAntinfluenzale($f3)
    {
        \App\Vaccini\Vaccino::SvuotaTabellaDepositi();
        \App\Vaccini\Vaccino::SvuotaTabellaPrenotazioni();
        \App\Vaccini\Vaccino::SvuotaTabellaAntinfluenzale();
        \App\Vaccini\Vaccino::SvuotaTabellaVaccinabili();
        \App\Flash::instance()->addMessage('Tabella vaccini antinfluenzali e vaccinabili svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaNaoTao($f3)
    {
        \App\Naotao\Model\Naotao::SvuotaTabellaNaoTao();
        \App\Flash::instance()->addMessage('Tabella Nao/Tao svuotata', 'success');
        $f3->reroute('@impostazioni');
    }

    public function SvuotaPazienti($f3)
    {
        Covid::SvuotaTabellaSchedeCovid();
        \App\Naotao\Model\Naotao::SvuotaTabellaNaoTao();
        Paziente::SvuotaTabellaPazienti();
        \App\Flash::instance()->addMessage('Tabella pazienti svuotata e tutte quelle collegate', 'success');
        $f3->reroute('@impostazioni');
    }

    public function ConvertiNomi($f3)
    {
        Paziente::ConvertiNomi();
        \App\Flash::instance()->addMessage('Conversione pazienti riuscita', 'success');
        $f3->reroute('@impostazioni');
    } 
}