<?php

namespace App\Vaccini;

use App\Utilita;

class Vaccinabili
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

    public function Import($f3)
    {
        define('FILE_NAME', "2020vaccini_public.csv");

        echo "Leggo il file " . FILE_NAME . "<br>";
        $handle = fopen(FILE_NAME, "r");
        if ($handle) {
            $persona_precedente = "";
            $denominazione_precedente = "";
            while (($line = fgets($handle)) !== false) {
                $parti = preg_split("/[|]/", $line);

                for ($i = 0; $i < count($parti); $i++) {
                    $parti[$i] = Utilita::pulisciStringaCSV($parti[$i]);
                }

                $denominazione = Utilita::Maiuscola($parti[0]) . " " . Utilita::Maiuscola($parti[1]);
                $eta = $parti[2];
                $rischio = $parti[3];
                $vaccinato2019 = $parti[4];

                $v = new \App\Vaccini\Vaccinabile(null, $denominazione, $eta, $rischio, $vaccinato2019);
                $v->AddDB();
            }
            fclose($handle);
        } else {
            echo "Errore nella lettura del file";
        }

        \App\Flash::instance()->addMessage('Importati con successo', 'success');
        $f3->reroute('@vaccini_vaccinabili_lista');
    }

    public function Nuovo($f3)
    {
        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/vaccinabili/nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function NuovoRegistra($f3)
    {
        $cognome = $f3->get('POST.cognome');
        $nome = $f3->get('POST.nome');
        $eta = $f3->get('POST.eta');
        $rischio = $f3->get('POST.rischio');
        $vaccinato2019 = $f3->get('POST.vaccinato2019');

        $denominazione = Utilita::Maiuscola($cognome) . " " . Utilita::Maiuscola($nome);
        $d = new \App\Vaccini\Vaccinabile(null, $denominazione, $eta, $rischio, $vaccinato2019);
        $d->AddDB();

        \App\Flash::instance()->addMessage('Vaccino aggiunto', 'success');
        $f3->reroute('@vaccini_vaccinabili_lista');
    }

    public function Lista($f3)
    {
        $listaVaccinabili = \App\Vaccini\Vaccinabile::ListaVaccinabili();
        $f3->set('listaVaccinabili', $listaVaccinabili);

        $f3->set('titolo', 'Vaccini');
        $f3->set('contenuto', '/vaccini/vaccinabili/lista.htm');
        \Template::instance()->filter('vaccinato','\App\Helpers\Filter::instance()->vaccinato');
        echo \Template::instance()->render('templates/base.htm');
    }

    public static function ListaArray()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT * FROM vaccinabili ORDER BY denominazione ASC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }
}
