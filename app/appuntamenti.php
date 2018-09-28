<?php
namespace App;

class Appuntamenti
{
    // Bisogna essere loggati
    function beforeroute($f3) {
        $auth = \App\Auth::Autentica($f3); 
        if(!$auth) {
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    public function TabellaGiorno($f3) {
        
        $listaGiorni = new \App\ListaGiorni();
        $listaGiorni->Add(new \App\Giorno('24/09/2018', 'Lunedì'));
        $listaGiorni->Add(new \App\Giorno('25/09/2018', 'Martedì'));
        $listaGiorni->Add(new \App\Giorno('26/09/2018', 'Mercoledì'));
        $listaGiorni->Add(new \App\Giorno('28/09/2018', 'Venerdì'));

        $listaOrari = new \App\ListaOrari();
        
        $listaOrari->Add(new \App\Orario('Lunedì', '8:00',  '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:15',  '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:30',  '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:45',  '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:00',  'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:15',  'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:30',  'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:45',  'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '10:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '10:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '10:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '10:45', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '11:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '11:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '11:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '11:45', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '12:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '12:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '12:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '12:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '13:00', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '13:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '13:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '13:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '14:00', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '14:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '14:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '14:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '15:00', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '15:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '15:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '15:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '16:00', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '16:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '16:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '16:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '17:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '17:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '17:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '17:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '18:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '18:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '18:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '18:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '19:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '19:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '19:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '19:45', '', false));

        $listaOrari->Add(new \App\Orario('Martedì', '8:00',  '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '8:15',  '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '8:30',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '8:45',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:00',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:15',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:30',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:45',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '10:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '10:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '10:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '10:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '11:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '11:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '11:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '11:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '12:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '12:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '12:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '12:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '13:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '13:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '13:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '13:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '14:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '14:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '14:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '14:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '15:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '15:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '15:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '15:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '16:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '16:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '16:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '16:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '17:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '17:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '17:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '17:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '18:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '18:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '18:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '18:45', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '19:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '19:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '19:30', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '19:45', '', false));

        $listaOrari->Add(new \App\Orario('Mercoledì', '8:00',  '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:15',  '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:30',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:45',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:00',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:15',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:30',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:45',  'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '10:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '10:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '10:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '10:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '11:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '11:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '11:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '11:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '12:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '12:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '12:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '12:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '13:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '13:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '13:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '13:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '14:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '14:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '14:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '14:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '15:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '15:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '15:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '15:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '16:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '16:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '16:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '16:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '17:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '17:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '17:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '17:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '18:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '18:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '18:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '18:45', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '19:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '19:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '19:30', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '19:45', '', false));

        $listaOrari->Add(new \App\Orario('Venerdì', '8:00',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:15',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:30',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:45',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:00',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:15',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:30',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:45',  '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '10:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '10:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '10:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '10:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '11:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '11:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '11:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '11:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '12:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '12:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '12:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '12:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '13:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '13:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '13:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '13:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '14:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '14:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '14:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '14:45', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '15:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '15:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '15:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '15:45', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '16:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '16:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '16:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '16:45', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Venerdì', '17:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '17:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '17:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '17:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '18:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '18:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '18:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '18:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '19:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '19:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '19:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '19:45', '', false));

        // Data Orario Persona Nota Fatto Assente Annullato
        $listaAppuntamenti = new \App\ListaAppuntamenti();
        $listaAppuntamenti->Add(new \App\Appuntamento('24/09/2018', '8:30', 'Emilie Rollandin', '', 0, 0, 0));
        $listaAppuntamenti->Add(new \App\Appuntamento('25/09/2018', '9:00', 'Primo', '', 0, 0, 0));
        $listaAppuntamenti->Add(new \App\Appuntamento('24/09/2018', '9:00', 'Provola', 'punti', 0, 0, 0));
        $listaAppuntamenti->Add(new \App\Appuntamento('25/09/2018', '9:15', 'Secondo', '', 0, 0, 0));
        $listaAppuntamenti->Add(new \App\Appuntamento('24/09/2018', '9:30', 'Terzo', '', 0, 0, 0));

        $tabella = new Tabella($listaGiorni, $listaOrari, $listaAppuntamenti);
        $f3->set('tabella', $tabella->ToArray());
        
        $f3->set('lunedi', '10-10-2018');
        $f3->set('domenica', '16-10-2018');

        $f3->set('lunediPrecedente', '2018-01-01');
        $f3->set('lunediSuccessivo', '2018-01-01');

        $f3->set('titolo', 'Appuntamenti');
        $f3->set('script', 'appuntamenti.js');
        $f3->set('contenuto', 'appuntamenti.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Tabella($f3)
    {
        // ridirigi sulla tabella con la data odierna
        $f3->reroute('/appuntamenti/2018');
    }

    public function Modifica($f3)
    {
        // ridirigi sulla tabella con la data odierna
        $f3->reroute('/appuntamenti/2018');
    }
    
}
