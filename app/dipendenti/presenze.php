<?php
namespace App\Dipendenti;

use App\Utilita;

class Presenze
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
        $f3->set('titolo', 'Presenze');
        $f3->set('contenuto', '/dipendenti/presenze/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        $data = $f3->get('POST.data');
        $entrata = $f3->get('POST.entrata');
        $uscita = $f3->get('POST.uscita');
        $note = $f3->get('POST.note');

        // Utilita::DumpDie([$data, $entrata, $uscita, $note]);

        $presenza = new \App\Dipendenti\Presenza(null, 1, $data, $entrata, $uscita, $note);
        $presenza->AddDB();

        \App\Flash::instance()->addMessage('Presenza aggiunta', 'success');
        $f3->reroute('@dipendenti_presenze_lista');
    }

    public function Lista($f3)
    {
        $lista = \App\Dipendenti\Presenza::ListaArray();
        $f3->set('lista', $lista);

        $f3->set('titolo', 'Presenze');
        $f3->set('contenuto', '/dipendenti/presenze/lista.htm');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Cancella($f3, $params)
    {
        $id = $params['id'];
        \App\Dipendenti\Presenza::EraseByID($id);

        \App\Flash::instance()->addMessage('Presenza cancellata', 'success');
        $f3->reroute('@dipendenti_presenze_lista');
    }
}