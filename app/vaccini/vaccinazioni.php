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
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/vaccinazioni/home.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}