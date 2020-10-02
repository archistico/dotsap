<?php
namespace App\Vaccini;

class Vaccinazioni
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
        $vaccini = Vaccino::ListaArray();
        $deposito = Deposito::ListaArray();

        $fatti_antinfluenzali = 0;
        $fatti_antinfluenzali = \App\Vaccini\Statistiche::Fatti($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('fatti_antinfluenzali', $fatti_antinfluenzali);

        $lasciati_paziente_antinfluenzali = 0;
        $lasciati_paziente_antinfluenzali = \App\Vaccini\Statistiche::LasciatiPaziente($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('lasciati_paziente_antinfluenzali', $lasciati_paziente_antinfluenzali);

        $fatti_antipneumococcica = 0;
        $fatti_antipneumococcica = \App\Vaccini\Statistiche::Fatti($vaccini, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA);
        $f3->set('fatti_antipneumococcica', $fatti_antipneumococcica);

        $lasciati_paziente_antipneumococcica = 0;
        $lasciati_paziente_antipneumococcica = \App\Vaccini\Statistiche::LasciatiPaziente($vaccini, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA);
        $f3->set('lasciati_paziente_antipneumococcica', $lasciati_paziente_antipneumococcica);

        $rimanenza_antinfluenzale = 0;
        $rimanenza_antinfluenzale = \App\Vaccini\Statistiche::Rimanenti($vaccini, $deposito, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('rimanenza_antinfluenzale', $rimanenza_antinfluenzale);


        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/vaccinazioni/home.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}