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
        $vaccinabili = Vaccinabili::ListaArray();

        // ANTINFLUENZALI
        $antinfluenzali_fatti = \App\Vaccini\Statistiche::Fatti($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('antinfluenzali_fatti', $antinfluenzali_fatti);

        $antinfluenzali_lasciati_paziente = \App\Vaccini\Statistiche::LasciatiPaziente($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('antinfluenzali_lasciati_paziente', $antinfluenzali_lasciati_paziente);

        $antinfluenzali_usciti = $antinfluenzali_lasciati_paziente + $antinfluenzali_fatti;
        $f3->set('antinfluenzali_usciti', $antinfluenzali_usciti);        

        $antinfluenzali_forniti_ausl = \App\Vaccini\Statistiche::Forniti($deposito, \App\Vaccini\Vaccino::$ANTINFLUENZALE, \App\Vaccini\Vaccino::$FORNITO_AUSL);
        $f3->set('antinfluenzali_forniti_ausl', $antinfluenzali_forniti_ausl);
        $antinfluenzali_forniti_paziente = \App\Vaccini\Statistiche::Forniti($deposito, \App\Vaccini\Vaccino::$ANTINFLUENZALE, \App\Vaccini\Vaccino::$FORNITO_PAZIENTE);
        $f3->set('antinfluenzali_forniti_paziente', $antinfluenzali_forniti_paziente);
        $totale_forniti = $antinfluenzali_forniti_ausl + $antinfluenzali_forniti_paziente;
        $f3->set('antinfluenzali_forniti_totale', $totale_forniti);

        $totale_pazienti = \App\Vaccini\Statistiche::TotalePazienti($vaccinabili);
        $f3->set('totale_pazienti', $totale_pazienti);

        $antinfluenzali_totale_rischio = \App\Vaccini\Statistiche::TotalePazientiRischio($vaccinabili);
        $f3->set('antinfluenzali_totale_rischio', $antinfluenzali_totale_rischio);

        $antinfluenzali_da_vaccinare = $antinfluenzali_totale_rischio - $antinfluenzali_fatti;
        $f3->set('antinfluenzali_da_vaccinare', $antinfluenzali_da_vaccinare);
        
        $antinfluenzali_rimanenza_fluad = \App\Vaccini\Statistiche::Rimanenti($vaccini, $deposito, \App\Vaccini\Vaccino::$Fluad);
        $f3->set('antinfluenzali_rimanenza_fluad', $antinfluenzali_rimanenza_fluad);

        $antinfluenzali_rimanenza_vaxigrip = \App\Vaccini\Statistiche::Rimanenti($vaccini, $deposito, \App\Vaccini\Vaccino::$VaxigripTetra);
        $f3->set('antinfluenzali_rimanenza_vaxigrip', $antinfluenzali_rimanenza_vaxigrip);

        $antinfluenzali_rimanenti = $antinfluenzali_rimanenza_fluad + $antinfluenzali_rimanenza_vaxigrip; 
        $f3->set('antinfluenzali_rimanenza', $antinfluenzali_rimanenti);

        // // ANTIPNEUMOCOCCO
        // $f3->set('antipneumococco_fatti', \App\Vaccini\Statistiche::Fatti($vaccini, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA));
        // $f3->set('antipneumococco_lasciati_paziente', \App\Vaccini\Statistiche::LasciatiPaziente($vaccini, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA));

        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/home.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}