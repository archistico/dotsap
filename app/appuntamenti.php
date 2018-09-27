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
        $giorniAttivi = ['Lunedì', 'Martedì', 'Mercoledì', 'Venerdì'];
        $f3->set('giorniAttivi', $giorniAttivi);

        $orari = [
            "8:00","8:15","8:30","8:45",
            "9:00","9:15","9:30","9:45",
            "10:00","10:15","10:30","10:45",
            "11:00","11:15","11:30","11:45",
            "12:00","12:15","12:30","12:45",
            "13:00","13:15","13:30","13:45",
            "14:00","14:15","14:30","14:45",
            "15:00","15:15","15:30","15:45",
            "16:00","16:15","16:30","16:45",
            "17:00","17:15","17:30","17:45",
            "18:00","18:15","18:30","18:45",
            "19:00","19:15","19:30","19:45"
        ];

        $f3->set('orari', $orari);

        $f3->set('lunedi', '10-10-2018');
        $f3->set('domenica', '16-10-2018');

        $f3->set('lunediPrecedente', '2018-01-01');
        $f3->set('lunediSuccessivo', '2018-01-01');

        $f3->set('titolo', 'Appuntamenti');
        $f3->set('contenuto', 'appuntamenti.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Tabella($f3)
    {
        // ridirigi sulla tabella con la data odierna
        $f3->reroute('/appuntamenti/2018');
    }
    
}
