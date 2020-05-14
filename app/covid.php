<?php
namespace App;

class Covid
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
        $listapazienti = Paziente::ReadAllName();
        $f3->set('listapazienti', $listapazienti);

        $listapositivi = Paziente::ReadByStato('Positivo');
        $f3->set('listapositivi', $listapositivi);

        $listasospetti = Paziente::ReadByStato('Sospetto in attesa di tampone');
        $f3->set('listasospetti', $listasospetti);

        $listaisolamento = Paziente::ReadByStato('Isolamento');
        $f3->set('listaisolamento', $listaisolamento);

        /*
           <option value="Ignoto">Ignoto</option>
           <option value="Sospetto in attesa di tampone">Sospetto in attesa di tampone</option>
           <option value="Sospetto non in attesa di tampone">Sospetto non in attesa di tampone</option>
           <option value="Negativo">Negativo</option>
           <option value="Isolamento">Isolamento</option>
           <option value="Positivo">Positivo</option>
           <option value="Primo Tampone negativo">Primo Tampone negativo</option>
           <option value="Secondo Tampone negativo">Secondo Tampone negativo</option>
           <option value="Terzo Tampone negativo">Terzo Tampone negativo</option>
           <option value="Guarito">Guarito</option>
           <option value="Deceduto">Deceduto</option>
         */

        $f3->set('titolo', 'Covid');
        $f3->set('contenuto', '/covid/covid.htm');
        echo \Template::instance()->render('templates/base.htm');
    }
}