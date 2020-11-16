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

        // Utilita::DumpDie($this->schede);

        $riempimento = 0;

        foreach ($this->schede as $s) {
            $datascheda = Utilita::ConvertToDMY($s['datascheda']);
            $paziente = $this->ConvertText($s['cognome']) . " " . $this->CropText($s['nome'], 15) . " (".$s['datanascita'].")";
            if(empty($s['datatampone'])) {
                $stato = $this->ConvertText($s['stato']);
            } else {
                $stato = $this->ConvertText($s['stato']). " (".Utilita::ConvertToDMY($s['datatampone']).")";
            }            
            $clinica = $this->ConvertText($s['clinica']);
            $comorbidita = $this->ConvertText($s['comorbidita']);
            $presaincarico = $this->ConvertText($s['presaincarico']);
            $terapia = $this->ConvertText($s['terapia']);
            $o2 = $this->ConvertText($s['o2']);
            $esami = $this->ConvertText($s['esami']);
            $note = $this->ConvertText($s['note']);
           
            //  $border = 0, $ln = 0, $align = 'L', $fill = false
            $columns = [
                [   
                    'larghezza' => $larghezza_schedadata,  
                    'testo' => $datascheda, 
                    'allineamento' => 'C'
                ],
                [
                    'larghezza' => $larghezza_paziente, 
                    'testo' => $paziente,
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_stato, 
                    'testo' => $stato, 
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_clinica, 
                    'testo' => $clinica, 
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_comorbidita, 
                    'testo' => $comorbidita,
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_presaincarico, 
                    'testo' => $presaincarico, 
                    'allineamento' => 'C'
                ],
                [
                    'larghezza' => $larghezza_terapia, 
                    'testo' => $terapia, 
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_ossigeno, 
                    'testo' => $o2, 
                    'allineamento' => 'C'
                ],
                [
                    'larghezza' => $larghezza_esami, 
                    'testo' => $esami, 
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_note, 
                    'testo' => $note, 
                    'allineamento' => 'L'
                ],
            ];

            $riempimento = $riempimento == 1?0:1;

            $pdf->RowTable($columns, $altezze_linea, $riempimento);
        }

        // var_dump($hs);

        $titolo = date("Y-m-d") . " " . $this->stato;
        $pdf->SetTitle($titolo);
        $pdf->Output('', $titolo . ".pdf");
    }
}
