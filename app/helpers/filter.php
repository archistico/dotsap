<?php 

namespace App\Helpers;

use App\Utilita;

class Filter extends \Prefab {
	function stato($val) {
		if($val == "1") { return "Vaccinato"; }
		if($val == "2") { return "In attesa"; }
		return "!";
	}
	
	function fornito($val) {
		if($val == "1") { return "AUSL"; }
		if($val == "2") { return "Paziente"; }
		return "!";
	}
	
	function vaccinato($val) {
		if($val == "0") { return "No"; }
		if($val == "1") { return "Vaccinato"; }
		return "!";
	}

	function datatodmy($val) {
		if (is_null($val) || empty($val)) {
            return "!";
        } else {
            $data = \DateTime::createFromFormat('d/m/Y', $val);
            return $data->format('Y-m-d');
        }
	}
}