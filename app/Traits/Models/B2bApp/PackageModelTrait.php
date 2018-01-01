<?php 

namespace App\Traits\Models\B2bApp;

trait PackageModelTrait 
{
    
	public function comparePackage($token, $way = 0)
	{
		$default = $this->tripSummary();
		$package = Self::byToken($token)->firstOrFail();
		$compareTo = $package->tripSummary();


		$result = [
				'uid' => $package->uid,
				'visa' => $package->cost->is_visa,
				'hotels' => [],
				'flights' => [],
				'transfers' => [],
				'activities' => [],
			];

		foreach ($result as $key => &$value) {
			if (is_array($value) && isset($default[$key]) && isset($compareTo[$key])) {
				if ($way == 1) {
					$count = count($default[$key]) > count($compareTo[$key])
								 ? count($default[$key]) : count($compareTo[$key]);

					for ($i=0; $i < $count; $i++) {
						if (isset($compareTo[$key][$i])) {
							$def = isset($default[$key][$i]) 
									 ? $default[$key][$i]
									 : null;

							$comp = $compareTo[$key][$i];

							$new = $comp;

							$which = 'changed';

							if (is_null($def)) {
								$which = 'new';
							}
							elseif ($def == $comp) {
								$which = 'same';
							}

							$result[$key][] = [
									"same" 		=> $def,
									"new" 		=> $new,
									"changed" => $comp,
									"which" 	=> $which
								];
						}
					}
				}
				else{
					$value = [
							'same' => array_intersect($default[$key], $compareTo[$key]),
							'del' => array_diff($default[$key], $compareTo[$key]),
							'new' => array_diff($compareTo[$key], $default[$key]),
						];
				}
			}
		}


		$etDef = $this->extra_word;
		$etNew = $package->extra_word;
		$etComp = $package->extra_word;
		$etWhich = 'new';

		if ($etDef == $etNew) {
			$etWhich = 'same';
		}
		elseif (strlen($etDef) && $etDef != $etNew) {
			$etWhich = 'changed';
		}

		$result['extra_word'] = [
								"same" 		=> $etDef,
								"new" 		=> $etNew,
								"changed" => $etComp,
								"which" 	=> $etWhich
							];

		return $result;
	}


}
