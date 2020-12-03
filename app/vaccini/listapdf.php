<?php

namespace App\Vaccini;

use App\Utilita;

class ListaPdf
{
    public $lista;

    public function __construct($lista)
    {
        $this->lista = $lista;
    }

    public function CropText($text, $lenght)
    {
        $text = utf8_decode($text);
        if (strlen($text) > ($lenght - 3)) {
            return substr($text, 0, $lenght) . "...";
        } else return $text;
    }

    public function ConvertText($text)
    {
        $text = utf8_decode($text);
        return $text;
    }

    public function MakePdf()
    {
        $sizeFontGrande = 10;
        $sizeFontPiccolo = 7;
        $altezze_linea = 4;
        $altezze_titolo = 8;

        $larghezza_data = 16;
        $larghezza_paziente = 80;
        $larghezza_vaccino = 74;
        $larghezza_stato = 15;
        $larghezza_millewin = 5;
        $larghezza_siavr = 5;

        $pdf = new \App\Covid\Controller\MyFpdf();
        $pdf->AddPage('P');
        $pdf->SetMargins(8, 10, 8);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->SetFont('Arial', 'B', $sizeFontGrande);
        $pdf->Cell(0, $altezze_titolo, "Vaccini", 0, 0, 'C');
        $pdf->Ln($altezze_titolo);
        $pdf->SetFont('Arial', '', $sizeFontPiccolo);

        // INTESTAZIONE TABELLA 

        $pdf->MultiAlignCell($larghezza_data, $altezze_linea, 'Data', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_paziente, $altezze_linea, 'Paziente', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_vaccino, $altezze_linea, 'Vaccino', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_stato, $altezze_linea, 'Stato', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_millewin, $altezze_linea, 'M', 1, 0, 'C');
        $pdf->MultiAlignCell($larghezza_siavr, $altezze_linea, 'S', 1, 1, 'C');

        // INSERIMENTO VACCINI

        // Utilita::DumpDie($this->lista);

        $riempimento = 0;

        foreach ($this->lista as $l) {
            $data = Utilita::ConvertToDMY($l['datavaccino']);
            $rischio = $this->ConvertText($l['rischio']);
            $paziente = $this->CropText($this->ConvertText($l['denominazione']), 20) . " (" . $l['eta'] . ") " . $rischio;
            $tipo = $this->ConvertText($l['tipo']);
            $lotto = $this->ConvertText($l['lotto']);
            $fornito = $this->ConvertText($l['fornito']);
            switch($fornito) {
                case \App\Vaccini\Vaccino::$FORNITO_AUSL: $fornito = "AUSL"; break;
                case \App\Vaccini\Vaccino::$FORNITO_PAZIENTE: $fornito = "Paziente"; break;
            }

            $sede = $this->ConvertText($l['sede']);
            switch($sede) {
                case \App\Vaccini\Vaccino::$SEDE_DX: $sede = "DX"; break;
                case \App\Vaccini\Vaccino::$SEDE_SX: $sede = "SX"; break;
            }

            $stato = $this->ConvertText($l['stato']);
            switch($stato) {
                case \App\Vaccini\Vaccino::$STATO_LASCIATO_PAZIENTE: $stato = "In attesa"; break;
                case \App\Vaccini\Vaccino::$STATO_SCARTATO: $stato = "Scartato"; break;
                case \App\Vaccini\Vaccino::$STATO_VACCINATO: $stato = "Vaccinato"; break;                
            }

            $vaccino = $tipo . ", ". $lotto . ", fornito: ".$fornito.", sede: ".$sede;

            $columns = [
                [
                    'larghezza' => $larghezza_data,
                    'testo' => $data,
                    'allineamento' => 'C'
                ],
                [
                    'larghezza' => $larghezza_paziente,
                    'testo' => $paziente,
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_vaccino,
                    'testo' => $vaccino,
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_stato,
                    'testo' => $stato,
                    'allineamento' => 'L'
                ],
                [
                    'larghezza' => $larghezza_millewin,
                    'testo' => "",
                    'allineamento' => 'C'
                ],
                [
                    'larghezza' => $larghezza_siavr,
                    'testo' => "",
                    'allineamento' => 'C'
                ],
            ];

            $riempimento = ($riempimento == 1)?0:1;
            $riempimento_colore = $riempimento?[240,240,240]:[255,255,255];
            $pdf->RowTable($columns, $altezze_linea, 1, $riempimento_colore);
        }

        $titolo = date("Y-m-d") . " Vaccini";
        $pdf->SetTitle($titolo);
        $pdf->Output('', $titolo . ".pdf");
    }
}
