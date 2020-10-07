<?php

namespace App\Helpers;

use App\Utilita;

class Filter extends \Prefab
{

	function stato($val)
	{
		if ($val == "1") {
			return "Vaccinato";
		}
		if ($val == "2") {
			return "In attesa";
		}
		return "!";
	}

	function fornito($val)
	{
		if ($val == "1") {
			return "AUSL";
		}
		if ($val == "2") {
			return "Paziente";
		}
		return "!";
	}

	function vaccinato($val)
	{
		if ($val == "0") {
			return "No";
		}
		if ($val == "1") {
			return "Vaccinato";
		}
		return "!";
	}


	private static function verifyDate($date, $format = 'Y-m-d', $strict = true)
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

	function datatoymd($val)
	{
		if (is_null($val) || empty($val) || !self::verifyDate($val, 'd/m/Y')) {
			return "!";
		} else {
			$data = \DateTime::createFromFormat('d/m/Y', $val);
			return $data->format('Y-m-d');
		}
	}

	function datatodmy($val)
	{
		if (is_null($val) || empty($val) || !self::verifyDate($val, 'Y-m-d')) {
			return "!";
		} else {
			$data = \DateTime::createFromFormat('Y-m-d', $val);
			return $data->format('d/m/Y');
		}
	}
}
