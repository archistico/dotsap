<?php
namespace App\Vaccini;

use App\Utilita;

class Depositi
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

    public function Nuovo($f3)
    {
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/depositi/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        $data = $f3->get('POST.data');
        $tipo = $f3->get('POST.tipo');
        $lotto = $f3->get('POST.lotto');
        $scadenza = $f3->get('POST.scadenza');
        $quantita = $f3->get('POST.quantita');
        $note = \App\Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
     
        $d = new \App\Vaccini\Deposito(null, $data, $tipo, $lotto, $quantita, $scadenza, $note);
        $d->AddDB();

        \App\Flash::instance()->addMessage('Deposito aggiunto', 'success');
        $f3->reroute('/vaccini');
    }

    public function Lista($f3)
    {
        $lista = Deposito::Lista();

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/depositi/lista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}