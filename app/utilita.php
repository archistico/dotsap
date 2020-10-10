<?php

namespace App;

class Utilita
{
    public static function Dump($variabile, $nome = "")
    {
        echo "<h4>$nome</h4>";
        echo "<pre>";
        var_dump($variabile);
        echo "</pre>";
    }

    public static function DumpDie($variabile, $nome = "")
    {
        echo "<h4>$nome</h4>";
        echo "<pre>";
        var_dump($variabile);
        echo "</pre>";
        die();
    }

    public static function TimeDiffToMinutes($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));
        return $diff->format("%H:%I:%S");
    }

    public static function TimeDiffToArray($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));

        // Converti in un array
        return [
            'giorni' => $diff->format("%a"),
            'ore' => $diff->format("%h"),
            'minuti' => $diff->format("%i"),
            'secondi' => $diff->format("%s"),
        ];
    }

    public static function TimeDiffToIntervallo($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));

        $ret = new \App\Intervallo();
        $ret->Make($diff->format("%a"), $diff->format("%h"), $diff->format("%i"), $diff->format("%s"));

        return $ret;
    }

    public static function TimeDiffToDateinterval($inizio, $fine)
    {
        $data_inizio = new \DateTime($inizio);
        $diff = $data_inizio->diff(new \DateTime($fine));
        return $diff;
    }

    public static function PulisciStringa($testo)
    {
        $testo = str_replace('"', "", $testo);
        $testo = str_replace("'", "`", $testo);
        return $testo;
    }

    public static function PulisciStringaVirgolette($testo)
    {
        $testo = str_replace('"', "", $testo);
        $testo = str_replace("'", "`", $testo);
        return $testo;
    }

    public static function Anonimize($text)
    {
        // Da: Pippo Pluto A: Pi. Pl.
        $parti = explode(" ", $text);
        $risultato = "";
        foreach ($parti as $p) {
            $risultato .= " " . (strlen($p) > 2 ? substr($p, 0, 2) . "." : $p);
        }
        return trim($risultato);
    }

    public static function CheckData($date, $format = 'Y-m-d', $strict = true)
	{
		$dateTime = \DateTime::createFromFormat($format, $date);
		if ($strict) {
			$errors = \DateTime::getLastErrors();
			if (!empty($errors['warning_count'])) {
				return false;
			}
		}
		return $dateTime !== false;
	}

    public static function ConvertToDMY($testo)
    {
        if (is_null($testo) || empty($testo) || !self::CheckData($testo, 'Y-m-d')) {
            return null;
        } else {
            $data = \DateTime::createFromFormat('Y-m-d', $testo);
            return $data->format('d/m/Y');
        }
    }

    public static function ConvertToYMD($testo)
    {
        if (is_null($testo) || empty($testo) || !self::CheckData($testo, 'd/m/Y')) {
            return null;
        } else {
            $data = \DateTime::createFromFormat('d/m/Y', $testo);
            return $data->format('Y-m-d');
        }
    }

    public static function pulisciStringaCSV($text)
    {
        if (!empty($text)) {
            $text = str_replace("- ", " - ", $text);
            $text = str_replace(" -", " - ", $text);
            $text = str_replace("     ", " ", $text);
            $text = str_replace("    ", " ", $text);
            $text = str_replace("   ", " ", $text);
            $text = str_replace("  ", " ", $text);
            $text = str_replace("\"", "", $text);
            $text = str_replace("'", "`", $text);

            $text = str_replace(array("\n", "\r"), "", $text);
            if (!empty($text)) {
                $text = trim($text);
            }
        }
        return $text;
    }

    public static function pulisciStringaTelefonoCSV($text)
    {
        if (!empty($text)) {
            $text = str_replace("-", " ", $text);
            $text = str_replace("     ", " ", $text);
            $text = str_replace("    ", " ", $text);
            $text = str_replace("   ", " ", $text);
            $text = str_replace("  ", " ", $text);
            $text = str_replace("\"", "", $text);
            $text = str_replace("'", "`", $text);

            $text = str_replace(array("\n", "\r"), "", $text);
            if (!empty($text)) {
                $text = trim($text);
            }
        }
        return $text;
    }

    public static function Maiuscola($text)
    {
        if (!empty($text)) {
            $text = ucwords(strtolower($text));
            $text = implode('-', array_map('ucfirst', explode('-', $text)));
            $text = implode('\'', array_map('ucfirst', explode('\'', $text)));
        }
        return $text;
    }
}
