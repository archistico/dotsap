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
        $f3->set('titolo', 'Privacy');
        $f3->set('contenuto', 'privacy.htm');
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
