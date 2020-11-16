<?php

namespace App\Covid\Controller;

use App\Utilita;
use FPDF;

class MyFpdf extends \FPDF
{
    /**
     * Controlla se cella di dimensioni $h ci sta altrimenti cambia pagina
     * 
     * @param int $h Altezza cella
     * @return boolean 
     */
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            return true;
        } else {
            return false;
        }            
    }

    /**
     * Calcola il numero di righe per una cella larga $w
     * 
     * @param int $w Larghezza cella
     * @param string $txt Testo da inserire
     */
    private function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    /**
     * MultiCell with alignment as in Cell.
     * @param float $w
     * @param float $h
     * @param string $text
     * @param mixed $border
     * @param int $ln
     * @param string $align
     * @param boolean $fill
     */
    public function MultiAlignCell($w, $h, $text, $border = 0, $ln = 0, $align = 'L', $fill = false)
    {
        // Store reset values for (x,y) positions
        $x = $this->GetX() + $w;
        $y = $this->GetY();

        // Make a call to FPDF's MultiCell
        $this->MultiCell($w, $h, $text, $border, $align, $fill);

        $h = $this->GetY();

        // Reset the line position to the right, like in Cell
        if ($ln == 0) {
            $this->SetXY($x, $y);
        }
        return $h;
    }

    /**
     * Stampa una sola riga di una tabella con testo multilinea
     *
     * @param array $columns
     * @return void
     */
    public function RowTable($columns, $altezze_linea, $riempimento, $riempimento_colore = 240)
    {
        $x_iniziale = $this->GetX();
        $y_iniziale = $this->GetY();
        $altezze = [];

        
        for ($c = 0; $c < count($columns); $c++) {
            $altezze[] = $altezze_linea * $this->NbLines($columns[$c]['larghezza'], $columns[$c]['testo']);
        }
        
        $altezza_max = max($altezze);
        if($this->CheckPageBreak($altezza_max)) {
            $x_iniziale = $this->GetX();
            $y_iniziale = $this->GetY();
        }
        
        // Disegna bordi
        $this->SetFillColor($riempimento_colore[0], $riempimento_colore[1], $riempimento_colore[2]);
        for ($c = 0; $c < count($columns); $c++) {
            if ($c < count($columns) - 1) {
                $this->MultiAlignCell($columns[$c]['larghezza'], $altezza_max, "", 1, 0, $columns[$c]['allineamento'], $riempimento);
            } else {
                $this->MultiAlignCell($columns[$c]['larghezza'], $altezza_max, "", 1, 1, $columns[$c]['allineamento'], $riempimento);
            }
        }

        $this->SetXY($x_iniziale, $y_iniziale);

        // Scrivi testi
        for ($c = 0; $c < count($columns); $c++) {
            if ($c < count($columns) - 1) {
                $this->MultiAlignCell($columns[$c]['larghezza'], $altezze_linea, $columns[$c]['testo'], 0, 0, $columns[$c]['allineamento'], 0);
            } else {
                $this->MultiAlignCell($columns[$c]['larghezza'], $altezze_linea, $columns[$c]['testo'], 0, 1, $columns[$c]['allineamento'], 0);
            }
        }

        $this->SetXY($this->GetX(), $y_iniziale + $altezza_max);

        // $x_finale = $this->GetX();
        // $y_finale = $this->GetY();

        // $altezza_max = max($altezze);

        // 



        // $this->SetXY($this->GetX(), $y_iniziale + $altezza_max);

        //Utilita::Dump($altezze);
    }
}
