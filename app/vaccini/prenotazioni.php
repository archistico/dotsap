<?php
namespace App\Vaccini;

use App\Utilita;

class Prenotazioni
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
        $f3->set('contenuto', '/vaccini/prenotazioni/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    // public function NuovoRegistra($f3)
    // {
    //     $data = $f3->get('POST.data');
    //     $tipo = $f3->get('POST.tipo');
    //     $lotto = $f3->get('POST.lotto');
    //     $scadenza = $f3->get('POST.scadenza');
    //     $quantita = $f3->get('POST.quantita');
    //     $fornito = $f3->get('POST.fornito');
    //     $note = \App\Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
     
    //     $d = new \App\Vaccini\Deposito(null, $data, $tipo, $lotto, $quantita, $scadenza, $fornito, $note);
    //     $d->AddDB();

    //     \App\Flash::instance()->addMessage('Deposito aggiunto', 'success');
    //     $f3->reroute('@vaccini_depositi_lista');
    // }

    // public function Lista($f3)
    // {
    //     $lista = Deposito::Lista();

    //     $f3->set('lista', $lista);
    //     $f3->set('titolo', 'Vaccini');
    //     $f3->set('contenuto', '/vaccini/depositi/lista.htm');
    //     \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
    //     echo \Template::instance()->render('templates/base.htm');
    // }

    // public function Modifica($f3, $params)
    // {
    //     $id = $params['id'];
    //     $deposito = Deposito::ReadById($id);

    //     // Utilita::DumpDie($deposito);

    //     $f3->set('deposito', $deposito);
    //     $f3->set('titolo', 'Vaccini');
    //     $f3->set('contenuto', '/vaccini/depositi/modifica.htm');
    //     \Template::instance()->filter('datatoymd','\App\Helpers\Filter::instance()->datatoymd');
    //     echo \Template::instance()->render('templates/base.htm');
    // }

    // public function ModificaRegistra($f3, $params)
    // {
    //     $id = $params['id'];
    //     $data = $f3->get('POST.data');
    //     $tipo = $f3->get('POST.tipo');
    //     $lotto = $f3->get('POST.lotto');
    //     $scadenza = $f3->get('POST.scadenza');
    //     $quantita = $f3->get('POST.quantita');
    //     $fornito = $f3->get('POST.fornito');
    //     $note = \App\Utilita::PulisciStringaVirgolette($f3->get('POST.note'));
     
    //     $d = new \App\Vaccini\Deposito($id, $data, $tipo, $lotto, $quantita, $scadenza, $fornito, $note);
        
    //     $d->UpdateDB();

    //     \App\Flash::instance()->addMessage('Deposito modificato', 'success');
    //     $f3->reroute('@vaccini_depositi_lista');
    // }

    // public function Cancella($f3, $params)
    // {
    //     $id = $params['id'];

    //     $deposito = Deposito::ReadByID($id);

    //     $f3->set('deposito', $deposito);
    //     $f3->set('titolo', 'Vaccini');
    //     $f3->set('contenuto', '/vaccini/depositi/cancella.htm');
        
    //     \Template::instance()->filter('stato','\App\Helpers\Filter::instance()->stato');
    //     \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
    //     \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
    //     echo \Template::instance()->render('templates/base.htm');
    // }

    // public function CancellaRegistra($f3, $params)
    // {
    //     $id = $params['id'];
    //     Deposito::EraseByID($id);

    //     \App\Flash::instance()->addMessage('Deposito cancellato', 'success');
    //     $f3->reroute('@vaccini_depositi_lista');
    // }
}