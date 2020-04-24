<?php

namespace App;

class Logs
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
    
    public function Show($f3)
    {
        $lista = \App\Log::LoadAll();

        for($c=0;$c<count($lista); $c++){
            $data = \DateTime::createFromFormat('Y/m/d H:i', $lista[$c]["data"]);
            if($data) {
                $lista[$c]["data"] = $data->format('d/m/Y H:i');
            }
        }

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Log');
        $f3->set('contenuto', '/log/lista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}
