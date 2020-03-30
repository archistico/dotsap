<?php
namespace App;

class Ricetta
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

    public function Nuova($f3)
    {
        $f3->set('titolo', 'Ricette');
        $f3->set('contenuto', '/ricetta/nuova.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lista($f3)
    {
        $lista = \App\Richiesta::LoadAll();

        for($c=0;$c<count($lista); $c++){
            $data = \DateTime::createFromFormat('Y/m/d H:i', $lista[$c]["data"]);
            if($data) {
                $lista[$c]["data"] = $data->format('d/m/Y H:i');
            }            
        }

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Ricette');
        $f3->set('contenuto', '/ricetta/lista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Aggiungi($f3)
    {
        $paziente = \App\Utilita::PulisciStringa($f3->get('POST.paziente'));

        $farmaco1 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco1'));
        $farmaco2 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco2'));
        $farmaco3 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco3'));
        $farmaco4 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco4'));
        $farmaco5 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco5'));
        $farmaco6 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco6'));
        $farmaco7 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco7'));
        $farmaco8 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco8'));
        $farmaco9 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco9'));

        $note = \App\Utilita::PulisciStringa($f3->get('POST.note'));

        $farmaci = array();
        $farmaci[] = $farmaco1;
        $farmaci[] = $farmaco2;
        $farmaci[] = $farmaco3;
        $farmaci[] = $farmaco4;
        $farmaci[] = $farmaco5;
        $farmaci[] = $farmaco6;
        $farmaci[] = $farmaco7;
        $farmaci[] = $farmaco8;
        $farmaci[] = $farmaco9;

        $data = date('Y/m/d H:i');

        $richiesta = new \App\Richiesta($paziente, $data, $farmaci, $note);
        $richiesta->Save();

        $f3->reroute('/ricetta/lista');
    }

    public function Cancella($f3, $params)
    {
        $id = $params['id'];
        
        \App\Richiesta::Cancella($id);

        $f3->reroute('/ricetta/lista');
    }

    // Carica i dati per la modifica
    public function Modifica($f3, $params)
    {
        $id = $params['id'];
        
        $richiesta = \App\Richiesta::Carica($id);

        $f3->set('richiesta', $richiesta[0]);
        $f3->set('titolo', 'Ricette');
        $f3->set('contenuto', '/ricetta/modifica.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    // inserisci i dati nel DB
    public function ModificaPost($f3)
    {
        $id = \App\Utilita::PulisciStringa($f3->get('POST.id'));
        $data = \App\Utilita::PulisciStringa($f3->get('POST.data'));

        $paziente = \App\Utilita::PulisciStringa($f3->get('POST.paziente'));

        $farmaco1 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco1'));
        $farmaco2 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco2'));
        $farmaco3 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco3'));
        $farmaco4 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco4'));
        $farmaco5 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco5'));
        $farmaco6 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco6'));
        $farmaco7 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco7'));
        $farmaco8 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco8'));
        $farmaco9 = \App\Utilita::PulisciStringa($f3->get('POST.farmaco9'));

        $note = \App\Utilita::PulisciStringa($f3->get('POST.note'));
        
        \App\Richiesta::Modifica($id, $paziente, $data, $farmaco1, $farmaco2, $farmaco3, $farmaco4, $farmaco5, $farmaco6, $farmaco7, $farmaco8, $farmaco9, $note);

        $f3->reroute('/ricetta/lista');
    }
}

