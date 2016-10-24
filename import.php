<?php
/**
 * Crea las clases que creas necesarias para hacer el trabajo.
 * Ten en cuenta que el archivo `users.csv`
 */

$db = require __DIR__.'/db.php';

class Test{

	public function getstmt(){

		$row = 1;
		if (($file = fopen("users.csv", "r")) !== FALSE) {
			$fields = fgetcsv($file, 0, "|");
			for($j = 0; $j < sizeof($fields); $j++){
				if($j == 3){
					$phones = explode("-", $fields[$j]);
					$fields[$j] = $phones[1].", ".$phones[0];
				}
			}
			
			$fields = implode(", ", $fields);

		    while (($data = fgetcsv($file, 1000, "|")) !== FALSE) {
		        $num = count($data);
		        $row++;
		        $values = array();
		        for ($i=0; $i < $num; $i++) {
					if($i == 3){
						$vPhones = explode("-", $data[$i]);
						$data[$i] = $vPhones[1]."\", \"".$vPhones[0];
					}        	
		        	$values[$i] .= "\"".$data[$i]."\"";
		        }
		       	$all_values[] = "(".implode(", ", $values).")";
		    }

		   	$all_values = implode(", ", $all_values);
		   	$stmt = "INSERT INTO users (".$fields.") VALUES ".$all_values;
		    fclose($file);

		    return $stmt;

		}

	}

}

$test = new Test();
$stmt = $test->getstmt();
//echo $stmt;

$db->exec($stmt);