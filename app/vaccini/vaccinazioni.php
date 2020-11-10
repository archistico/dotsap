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

        $antipneumococco_usciti = \App\Vaccini\Statistiche::Fatti($vaccini, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA);
        $f3->set('antipneumococco_usciti', $antipneumococco_usciti);

        $antinfluenzali_lasciati_paziente = \App\Vaccini\Statistiche::LasciatiPaziente($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('antinfluenzali_lasciati_paziente', $antinfluenzali_lasciati_paziente);

        $antinfluenzali_scartati = \App\Vaccini\Statistiche::Scartati($vaccini, \App\Vaccini\Vaccino::$ANTINFLUENZALE);
        $f3->set('antinfluenzali_scartati', $antinfluenzali_scartati);

        $antinfluenzali_usciti = $antinfluenzali_lasciati_paziente + $antinfluenzali_fatti + $antinfluenzali_scartati;
        $f3->set('antinfluenzali_usciti', $antinfluenzali_usciti);        

        $antinfluenzali_forniti_ausl = \App\Vaccini\Statistiche::Forniti($deposito, \App\Vaccini\Vaccino::$ANTINFLUENZALE, \App\Vaccini\Vaccino::$FORNITO_AUSL);
        $f3->set('antinfluenzali_forniti_ausl', $antinfluenzali_forniti_ausl);
        $antinfluenzali_forniti_paziente = \App\Vaccini\Statistiche::Forniti($deposito, \App\Vaccini\Vaccino::$ANTINFLUENZALE, \App\Vaccini\Vaccino::$FORNITO_PAZIENTE);
        $f3->set('antinfluenzali_forniti_paziente', $antinfluenzali_forniti_paziente);
        $totale_forniti = $antinfluenzali_forniti_ausl + $antinfluenzali_forniti_paziente;
        $f3->set('antinfluenzali_forniti_totale', $totale_forniti);

        $antipneumococco_forniti_totale = \App\Vaccini\Statistiche::Forniti($deposito, \App\Vaccini\Vaccino::$ANTIPNEUMOCOCCICA, \App\Vaccini\Vaccino::$FORNITO_AUSL);
        $f3->set('antipneumococco_forniti_totale', $antipneumococco_forniti_totale);

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

        $antinfluenzali_rimanenza_altro = \App\Vaccini\Statistiche::Rimanenti($vaccini, $deposito, \App\Vaccini\Vaccino::$AltroAntinfluenzale);
        $f3->set('antinfluenzali_rimanenza_altro', $antinfluenzali_rimanenza_altro);

        $antinfluenzali_rimanenti = $antinfluenzali_rimanenza_fluad + $antinfluenzali_rimanenza_vaxigrip + $antinfluenzali_rimanenza_altro; 
        $f3->set('antinfluenzali_rimanenza', $antinfluenzali_rimanenti);

        $antipneumococco_prevenar_rimanenza = \App\Vaccini\Statistiche::Rimanenti($vaccini, $deposito, \App\Vaccini\Vaccino::$Prevenar);
        $f3->set('antipneumococco_prevenar_rimanenza', $antipneumococco_prevenar_rimanenza);

        // PRENOTAZIONI
        $prenotazioni = \App\Vaccini\Prenotazione::ReadAll();

        $prenotazioni_fluad = \App\Vaccini\Statistiche::Prenotazioni($prenotazioni, \App\Vaccini\Vaccino::$Fluad);
        $f3->set('prenotazioni_fluad', $prenotazioni_fluad);

        $prenotazioni_vaxigrip = \App\Vaccini\Statistiche::Prenotazioni($prenotazioni, \App\Vaccini\Vaccino::$VaxigripTetra);
        $f3->set('prenotazioni_vaxigrip', $prenotazioni_vaxigrip);

        $prenotazioni_altro = \App\Vaccini\Statistiche::Prenotazioni($prenotazioni, \App\Vaccini\Vaccino::$AltroAntinfluenzale);
        $f3->set('prenotazioni_altro', $prenotazioni_altro);

        $prenotazioni_prevenar = \App\Vaccini\Statistiche::Prenotazioni($prenotazioni, \App\Vaccini\Vaccino::$Prevenar);
        $f3->set('prenotazioni_prevenar', $prenotazioni_prevenar);

        // STATISTICHE
        if($totale_forniti != 0) {
            $antinfluenzali_percentuale_vaccinati = round((( $antinfluenzali_fatti / $totale_forniti ) * 100), 2);
        } else {
            $antinfluenzali_percentuale_vaccinati = "-";
        }
        $f3->set('antinfluenzali_percentuale_vaccinati', $antinfluenzali_percentuale_vaccinati);

        // Ancora prenotabili
        $prenotazioni_possibili_fluad = $antinfluenzali_rimanenza_fluad - $prenotazioni_fluad;
        $f3->set('prenotazioni_possibili_fluad', $prenotazioni_possibili_fluad);

        $prenotazioni_possibili_vaxigrip = $antinfluenzali_rimanenza_vaxigrip - $prenotazioni_vaxigrip;
        $f3->set('prenotazioni_possibili_vaxigrip', $prenotazioni_possibili_vaxigrip);

        $prenotazioni_possibili_prevenar = $antipneumococco_prevenar_rimanenza - $prenotazioni_prevenar;
        $f3->set('prenotazioni_possibili_prevenar', $prenotazioni_possibili_prevenar);
        
        //prenotazioni_tipo_da_definire
        $prenotazioni_tipo_da_definire = \App\Vaccini\Prenotazione::NonDefinite();
        $f3->set('prenotazioni_tipo_da_definire', $prenotazioni_tipo_da_definire);

        // Percentuale sopra 60 anni vaccinati
        $over60 = \App\Vaccini\Statistiche::Over60(\App\Vaccini\Vaccinabile::ReadAll());
        $f3->set('over60', $over60);
        $percentualeover60 = \App\Vaccini\Statistiche::PercentualeFattiOver60(\App\Vaccini\Vaccinabile::ReadAll(), $vaccini);
        $f3->set('percentualeover60', $percentualeover60);

        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/home.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}