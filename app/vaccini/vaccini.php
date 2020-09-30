<?php
namespace App\Vaccini;

use App\Utilita;

class Vaccini
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

    public function Nuovo($f3, $param)
    {
        $tipoVaccino = $param["tipo"];
        $listaVaccinabili = \App\Vaccini\Vaccinabile::ListaVaccinabili();
        $listaVaccini = \App\Vaccini\Deposito::ListaVaccini($tipoVaccino);

        $f3->set('tipoVaccino', $tipoVaccino);
        $f3->set('listaVaccinabili', $listaVaccinabili);
        $f3->set('listaVaccini', $listaVaccini);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        $data = $f3->get('POST.data');
        $fkpersona = $f3->get('POST.fkpersona');
        $sede = $f3->get('POST.sede');
        $fkdeposito = $f3->get('POST.fkdeposito');
        $stato = $f3->get('POST.stato');
        $fornito = $f3->get('POST.fornito');

        $d = new \App\Vaccini\Vaccino(null, $data, $fkpersona, $sede, $fkdeposito, $stato, $fornito);
        $d->AddDB();

        \App\Flash::instance()->addMessage('Vaccino aggiunto', 'success');
        $f3->reroute('/vaccini');
    }

    public function Lista($f3)
    {
        $lista = Vaccino::Lista();

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/lista.htm');
        \Template::instance()->filter('stato','\App\Helpers\Filter::instance()->stato');
        echo \Template::instance()->render('templates/base.htm');
    }
}