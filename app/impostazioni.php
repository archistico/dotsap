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

    public function SvuotaRicette($f3)
    {
        Richiesta::SvuotaTabellaRicetteFatte();
        \App\Flash::instance()->addMessage('Tabella ricette fatte svuotata', 'success');
        $f3->reroute('/impostazioni');
    }

    public function SvuotaPrivacy($f3)
    {
        Paziente::SvuotaPrivacy();
        \App\Flash::instance()->addMessage('Lista privacy svuotata', 'success');
        $f3->reroute('/impostazioni');
    }

    public function SvuotaPrenotazioni($f3)
    {
        Appuntamenti::SvuotaTabellaAppuntamenti();
        \App\Flash::instance()->addMessage('Tabella appuntamenti svuotata', 'success');
        $f3->reroute('/impostazioni');
    }
}