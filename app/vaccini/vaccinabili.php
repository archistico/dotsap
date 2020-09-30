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
        define('FILE_NAME', "2020vaccini.csv");

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
                $telefono = Utilita::pulisciStringaTelefonoCSV($parti[2]);
                $eta = $parti[3];
                $rischio = $parti[4];

                $v = new \App\Vaccini\Vaccinabile(null, $denominazione, $telefono, $eta, $rischio);
                $v->AddDB();
            }
            fclose($handle);
        } else {
            echo "Errore nella lettura del file";
        }

        \App\Flash::instance()->addMessage('Importati con successo', 'success');
        $f3->reroute('/vaccini');
    }

}
