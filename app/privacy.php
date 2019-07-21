<?php
namespace App;

class Privacy
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
        $listaAlfabetica = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Y", "Z"];
        $f3->set('lista', $listaAlfabetica);

        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', 'privacy.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lista($f3, $params)
    {
        $lettera = $params['lettera'];
        $f3->set('lettera', $lettera);

        $lista = [
            (new \App\Paziente(1, "Pippo", "nome pippo", "PPPNNN11A11E333H"))->ToArray(),
            (new \App\Paziente(2, "Minnie", "nome Minnie", "MMMNNN11A11E333H"))->ToArray(),
        ];

        $f3->set('lista', $lista);
        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', 'privacylista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function MakePDF() {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Output();
    }
}
