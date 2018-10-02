<?php
namespace App;

class Appuntamenti
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

    public function TabellaGiorno($f3, $params)
    {
        $settimana = new \App\Settimana($params['data']);

        $listaGiorni = new \App\ListaGiorni();
        $listaGiorni->Add(new \App\Giorno($settimana->lunedi->format('d/m/Y'), 'Lunedì'));
        $listaGiorni->Add(new \App\Giorno($settimana->martedi->format('d/m/Y'), 'Martedì'));
        $listaGiorni->Add(new \App\Giorno($settimana->mercoledi->format('d/m/Y'), 'Mercoledì'));
        $listaGiorni->Add(new \App\Giorno($settimana->venerdi->format('d/m/Y'), 'Venerdì'));

        $listaOrari = new \App\ListaOrari();

        $listaOrari->Add(new \App\Orario('Lunedì', '8:00', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:15', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:30', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '8:45', '', false));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:00', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:15', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:30', 'Chatillon', true));
        $listaOrari->Add(new \App\Orario('Lunedì', '9:45', 'Chatillon', true));
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

        $listaOrari->Add(new \App\Orario('Martedì', '8:00', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '8:15', '', false));
        $listaOrari->Add(new \App\Orario('Martedì', '8:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '8:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Martedì', '9:45', 'Saint-Vincent', true));
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

        $listaOrari->Add(new \App\Orario('Mercoledì', '8:00', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:15', '', false));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '8:45', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:00', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:15', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:30', 'Saint-Vincent', true));
        $listaOrari->Add(new \App\Orario('Mercoledì', '9:45', 'Saint-Vincent', true));
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

        $listaOrari->Add(new \App\Orario('Venerdì', '8:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '8:45', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:00', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:15', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:30', '', false));
        $listaOrari->Add(new \App\Orario('Venerdì', '9:45', '', false));
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

        $db = new \DB\SQL('sqlite:.database.sqlite');
        $sql = "SELECT * FROM appuntamenti WHERE annullato = 0 AND fatto = 0 AND assente = 0";
        $appuntamentiDB = $db->exec($sql);

        foreach ($appuntamentiDB as $appuntamentoDB) {

            $str = jdtojulian($appuntamentoDB['data']);
            $dmy = \DateTime::createFromFormat('m/d/Y', $str)->format('d/m/Y');

            $listaAppuntamenti->Add(new \App\Appuntamento($dmy, $appuntamentoDB['ora'], $appuntamentoDB['persona'], $appuntamentoDB['note'], $appuntamentoDB['annullato'], $appuntamentoDB['assente'], $appuntamentoDB['fatto']));
        }

        $tabella = new Tabella($listaGiorni, $listaOrari, $listaAppuntamenti);
        $f3->set('tabella', $tabella->ToArray());

        $f3->set('lunedi', $settimana->lunedi->format('d-m-Y'));
        $f3->set('domenica', $settimana->domenica->format('d-m-Y'));

        $f3->set('lunediPrecedente', $settimana->lunediPrecedente->format('d-m-Y'));
        $f3->set('lunediSuccessivo', $settimana->lunediSuccessivo->format('d-m-Y'));

        $f3->set('titolo', 'Appuntamenti');
        $f3->set('script', 'appuntamenti.js');
        $f3->set('contenuto', 'appuntamenti.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Tabella($f3)
    {
        $oggi = new \Datetime();
        $dmy = $oggi->format('d-m-Y');
        $f3->reroute('/appuntamenti/'.$dmy);
    }

    public function Modifica($f3)
    {
        $db = new \DB\SQL('sqlite:.database.sqlite');

        $tipologia = $f3->get('POST.tipologia');
        $data = $f3->get('POST.data');
        $ora = $f3->get('POST.ora');
        $lunedi = $f3->get('POST.tabelladata');

        $data_array = explode("/", $data);
        $jd = juliantojd($data_array[1], $data_array[0], $data_array[2]);

        switch ($tipologia) {
            case "annullato":
                $sql = "UPDATE appuntamenti SET annullato = 1 WHERE data=$jd AND ora='$ora'";
                break;
            case "assente":
                $sql = "UPDATE appuntamenti SET assente = 1 WHERE data=$jd AND ora='$ora'";
                break;
            case "fatto":
                $sql = "UPDATE appuntamenti SET fatto = 1 WHERE data=$jd AND ora='$ora'";
                break;
        }

        $db->begin();
        $db->exec($sql);
        $db->commit();

        // ridirigi sulla tabella con la data odierna
        $f3->reroute('/appuntamenti/'.$lunedi);
    }

    public function Aggiungi($f3)
    {
        $data = $f3->get('POST.data');
        $ora = $f3->get('POST.ora');
        $persona = $f3->get('POST.persona');
        $note = $f3->get('POST.note');
        $lunedi = $f3->get('POST.tabelladata');

        $db = new \DB\SQL('sqlite:.database.sqlite');
        $data_array = explode("/", $data);
        $jd = juliantojd($data_array[1], $data_array[0], $data_array[2]);

        $db->begin();
        $sql = "INSERT into appuntamenti values(null, $jd, '$ora', '$persona', '$note', 0, 0, 0)";
        $db->exec($sql);
        $db->commit();

        // ridirigi sulla tabella con la data odierna
        $f3->reroute('/appuntamenti/'.$lunedi);
    }

}
