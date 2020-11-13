<?php

namespace App\Covid\Controller;

use App\Utilita;

class SchedaPdf
{
    public $scheda;

    public function __construct($scheda)
    {
        $this->scheda = $scheda;    
    }

    public function MakePdf()
    {
        echo "pdf";
    }
}