<?php
namespace App;

class Admin
{
    public function beforeroute($f3)
    {
        $auth = \App\Auth::Autentica($f3);
        if (!$auth) {
            \App\Flash::instance()->addMessage('Prima effettuare il login', 'danger');
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    public function Amministrazione($f3, $args)
    {
        $utenti = \App\Utente::SelectAll();
        $f3->set('utenti', $utenti);
        $f3->set('titolo', 'Amministrazione');
        $f3->set('contenuto', '/impostazioni/amministrazione.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}
