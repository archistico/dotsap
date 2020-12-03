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
        $f3->set('script', 'vaccini.js');
        $f3->set('contenuto', '/vaccini/nuovo.htm');
        \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        $data = $f3->get('POST.data');
        $fkpersona = $f3->get('POST.fkpersona');
        $sede = $f3->get('POST.sede');
        $fkdeposito = $f3->get('POST.fkdeposito');
        $stato = $f3->get('POST.stato');
        
        $d = new \App\Vaccini\Vaccino(null, $data, $fkpersona, $sede, $fkdeposito, $stato);
        $d->AddDB();

        \App\Flash::instance()->addMessage('Vaccino aggiunto', 'success');
        $f3->reroute('@vaccini_lista');
    }

    public function Lista($f3)
    {
        $lista = Vaccino::ListaToView();

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/lista.htm');
        \Template::instance()->filter('stato','\App\Helpers\Filter::instance()->stato');
        \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        \Template::instance()->filter('sede','\App\Helpers\Filter::instance()->sede');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Pdf($f3)
    {
        $lista = Vaccino::ListaToPdf();
        $pdf = new \App\Vaccini\ListaPdf($lista);
        $pdf->MakePdf();
    }

    public function Modifica($f3, $params)
    {
        $id = $params['id'];
        $vaccino = Vaccino::ReadById($id);

        $listaVaccinabili = \App\Vaccini\Vaccinabile::ListaVaccinabili();
        $listaVaccini = \App\Vaccini\Deposito::ListaVacciniGenerico();
        $f3->set('listaVaccinabili', $listaVaccinabili);
        $f3->set('listaVaccini', $listaVaccini);

        $f3->set('vaccino', $vaccino);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/modifica.htm');

        \Template::instance()->filter('stato','\App\Helpers\Filter::instance()->stato');
        \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
        \Template::instance()->filter('datatoymd','\App\Helpers\Filter::instance()->datatoymd');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function ModificaRegistra($f3, $params)
    {
        $id = $params['id'];
        $data = $f3->get('POST.data');
        $fkpersona = $f3->get('POST.fkpersona');
        $sede = $f3->get('POST.sede');
        $fkdeposito = $f3->get('POST.fkdeposito');
        $stato = $f3->get('POST.stato');
        
        $d = new \App\Vaccini\Vaccino($id, $data, $fkpersona, $sede, $fkdeposito, $stato);
                
        $d->UpdateDB();

        \App\Flash::instance()->addMessage('Vaccino modificato', 'success');
        $f3->reroute('@vaccini_lista');
    }

    public function Cancella($f3, $params)
    {
        $id = $params['id'];

        $vaccino = Vaccino::ReadCompleteByID($id);

        $f3->set('vaccino', $vaccino);
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/cancella.htm');
        
        \Template::instance()->filter('stato','\App\Helpers\Filter::instance()->stato');
        \Template::instance()->filter('fornito','\App\Helpers\Filter::instance()->fornito');
        \Template::instance()->filter('datatodmy','\App\Helpers\Filter::instance()->datatodmy');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function CancellaRegistra($f3, $params)
    {
        $id = $params['id'];
        Vaccino::EraseByID($id);

        \App\Flash::instance()->addMessage('Vaccino cancellato', 'success');
        $f3->reroute('@vaccini_lista');
    }
}