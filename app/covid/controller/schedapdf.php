<?php

namespace App\Covid\Controller;

use App\Utilita;

class SchedaPdf
{
    public $schede;
    public $stato;

    public function __construct($stato, $schede)
    {
        $this->schede = $schede;
        $this->stato = ucfirst($stato);
    }

    public function CropText($text, $lenght) {
        $text = utf8_decode($text);
        if(strlen($text)>($lenght-3)) {
            return substr($text, 0, $lenght). "...";
        } else return $text;
    }

    public function ConvertText($text) {
        $text = utf8_decode($text);
        return $text;
    }

    public function MakePdf()
    {
        $sizeFontGrande = 10;
        $sizeFontPiccolo = 7;
        $altezze_linea = 4;
        $altezze_titolo = 8;

        $larghezza_schedadata = 15;
        $larghezza_paziente = 43;
        $larghezza_stato = 22;
        $larghezza_clinica = 21;
        $larghezza_comorbidita = 21;
        $larghezza_presaincarico = 13;
        $larghezza_terapia = 36;
        $larghezza_ossigeno = 12;
        $larghezza_esami = 48;
        $larghezza_note = 50;

        $pdf = new \App\Covid\Controller\MyFpdf();
        $pdf->AddPage('L');
        $pdf->SetMargins(8, 10, 8);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetFont('Arial', 'B', $sizeFontGrande);
        $pdf->Cell(0, $altezze_titolo, $this->stato, 0, '', 'C');
        $pdf->Ln($altezze_titolo);
        $pdf->SetFont('Arial', '', $sizeFontPiccolo);

        // INTESTAZIONE TABELLA 

        $pdf->MultiAlignCell($larghezza_schedadata, $altezze_linea, 'Data', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_paziente, $altezze_linea, 'Paziente', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_stato, $altezze_linea, 'Stato', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_clinica, $altezze_linea, 'Clinica', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_comorbidita, $altezze_linea, 'Comorbidita', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_presaincarico, $altezze_linea, 'Carico', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_terapia, $altezze_linea, 'Terapia', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_ossigeno, $altezze_linea, 'O2', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_esami, $altezze_linea, 'Esami', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_note, $altezze_linea, 'Note', 1, 1, 'C');

        // INSERIMENTO PAZIENTI 

        foreach ($this->schede as $s) {
            $datascheda =Utilita::ConvertToDMY($s['datascheda']);
            $paziente = $this->ConvertText($s['cognome']) . " " . $this->CropText($s['nome'], 15);
            $stato = $this->ConvertText($s['stato']);
            $clinica = $this->ConvertText($s['clinica']);
            $comorbidita = $this->ConvertText($s['comorbidita']);
            $presaincarico = $this->ConvertText($s['presaincarico']);
            $terapia = $this->ConvertText($s['terapia']);
            $o2 = $this->ConvertText($s['o2']);
            $esami = $this->ConvertText($s['esami']);
            $note = $this->ConvertText($s['note']);

            $hs = [];

            $hs[] = $pdf->MultiAlignCell($larghezza_schedadata, $altezze_linea, $datascheda, 1, 0, 'C');
            $hs[] = $pdf->MultiAlignCell($larghezza_paziente, $altezze_linea, $paziente, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_stato, $altezze_linea, $stato, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_clinica, $altezze_linea, $clinica, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_comorbidita, $altezze_linea, $comorbidita, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_presaincarico, $altezze_linea, $presaincarico, 1, 0, 'C');
            $hs[] = $pdf->MultiAlignCell($larghezza_terapia, $altezze_linea, $terapia, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_ossigeno, $altezze_linea, $o2, 1, 0, 'C');
            $hs[] = $pdf->MultiAlignCell($larghezza_esami, $altezze_linea, $esami, 1, 0, 'L');
            $hs[] = $pdf->MultiAlignCell($larghezza_note, $altezze_linea, $note, 1, 1, 'L');
        }

        // var_dump($hs);

        $titolo = date("Y-m-d") . " " . $this->stato;
        $pdf->SetTitle($titolo);
        $pdf->Output('', $titolo . ".pdf");
    }
}
