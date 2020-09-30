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
        $listaVaccini = \App\Vaccini\Deposito::ListaVaccini();

        $f3->set('tipoVaccino', $tipoVaccino);
        $f3->set('listaVaccinabili', $listaVaccinabili);
        $f3->set('listaVaccini', $listaVaccini);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        echo "registra";
    }
}