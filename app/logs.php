<?php

namespace App;

class Logs
{
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
