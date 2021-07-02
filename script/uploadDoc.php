<?php
	session_start();
	require "bdd.php";
	
	//Time pour ne pas avoir l'effet de cache sur l'upload d'images
	$time = time();
	
	if (isset($_FILES["myfile"]) and $_POST["id"] <> "") {
		$output_dir = "../../assets/files/media/";
		$ret = array();
		
		//Création du dossier.
		mkdir("../../assets/files/media/", 0755, true);
		
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if (!is_array($_FILES["myfile"]["name"])) { //Single $_FILES
			
			$error =$_FILES["myfile"]["error"];
			
			//$fileName = $_FILES["myfile"]["name"];
		
			$file_type = $_FILES["myfile"]["name"];
			$file_type_length = strlen($file_type) - 4;
			$file_type = substr($file_type, $file_type_length);
			$file_type = strtolower(str_replace(".", "", $file_type));
			
			$fileName = str_ok(str_replace("." . $file_type, "", $_FILES["myfile"]["name"])) . "_" . $time . "." . $file_type;
				
			if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.$fileName)) {

				//Save l'image en base tel quelle.
				$dataAddImg  = $bdd->prepare("INSERT INTO tbl_ent_dossiers (ED_Src, ED_Title) VALUES (?, ?)");
				$dataAddImg->execute([str_replace("../", "", $output_dir.$fileName), $_FILES["myfile"]["name"]]);
				$dataAddImg->closeCursor();

			} else {
				//echo $output_dir.$fileName;
			}

		} else { //Multiple files, file[] IE
			$fileCount = count($_FILES["myfile"]["name"]);
			for($i=0; $i < $fileCount; $i++) {
				//$fileName = $_FILES["myfile"]["name"][$i];
				
				$file_type = $_FILES["myfile"]["name"][$i];
				$file_type_length = strlen($file_type) - 4;
				$file_type = substr($file_type, $file_type_length);
				$file_type = strtolower(str_replace(".", "", $file_type));
				
				$fileName = str_ok(str_replace("." . $file_type, "", $_FILES["myfile"]["name"])) . "_" . $time . "." . $file_type;
			
				if (move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName)) {
					
					//Save l'image en base tel quelle.
					//$bdd->exec("INSERT INTO tbl_ent_dossiers (ED_ENT_ID, ED_Src, ED_Title) VALUES (". $_POST["id"] .", '". str_replace("../", "", $output_dir.$fileName) ."', '". str_ok(str_replace("." . $file_type, "", $_FILES["myfile"]["name"])) ."')");

					//Save l'image en base tel quelle.
					$dataAddImg  = $bdd->prepare("INSERT INTO tbl_ent_dossiers (ED_Src, ED_Title) VALUES (?, ?)");
					$dataAddImg->execute([str_replace("../", "", $output_dir.$fileName), $_FILES["myfile"]["name"]]);
					$dataAddImg->closeCursor();

					
				} else {
					//echo $output_dir.$fileName;
				}
			}
		}
		
		echo $_POST["id"];
		
	} else {
		echo "err";
	}
	
	function str_ok($str) {
		return str_replace("'", "''",str_replace("\n", "<br />", trim($str)));
	}
	
	function datetostr($date) {
		return substr($date, 6) . "-" .  substr($date, 3, 2) . "-" . substr($date, 0, 2);
	}
?>