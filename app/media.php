<?php
namespace App;

class Media
{

    public static function Media($valori)
    {
        $numero_valori = count($valori);
        $somma = 0;

        foreach ($valori as $val) {
            $somma += $val;
        }

        if ($numero_valori > 0) {
            return $somma / $numero_valori;
        } else {
            return 0;
        }
    }

    public static function ScartoQuadraticoMedio($valori)
    {
        $numero_valori = count($valori);
        $media = self::Media($valori);

        $sommaScartiQ = 0;

        foreach ($valori as $val) {
            $sommaScartiQ += pow(($val - $media), 2);
        }

        if (($numero_valori - 1) > 0) {
            return sqrt($sommaScartiQ / ($numero_valori - 1));
        } else {
            return 0;
        }
    }

    public static function Anomalia($valori, $min, $max)
    {
        $listaSenzaAnomalie = [];

        foreach ($valori as $val) {
            if($val >= $min && $val <= $max) {
                $listaSenzaAnomalie[] = $val;
            }
        }

        return $listaSenzaAnomalie;
    }

    public static function MediaSenzaAnomalie($valori)
    {
        $numero_valori = count($valori);
        $media = self::Media($valori);
        $scartoQuadraticoMedio = self::ScartoQuadraticoMedio($valori);
        $anomaliaMin = $media - $scartoQuadraticoMedio;
        $anomaliaMax = $media + $scartoQuadraticoMedio;

        $valoriSenzaAnomalie = self::Anomalia($valori, $anomaliaMin, $anomaliaMax);
        $mediaPonderata = self::Media($valoriSenzaAnomalie);
        return $mediaPonderata;
    }

}
