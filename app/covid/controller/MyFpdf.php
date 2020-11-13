<?php

namespace App\Covid\Controller;

use App\Utilita;
use FPDF;

class MyFpdf extends \FPDF
{
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
}
