<?php 

namespace App\Helpers;

use App\Utilita;

class Filter extends \Prefab {
	function stato($val) {
		if($val == "1") { return "Vaccinato"; }
		if($val == "2") { return "In attesa"; }
		return "!";
    }
}