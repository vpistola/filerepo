<?php
    require_once "functions.php"; 

	if(!empty($_POST['action']) && $_POST['action'] == 'save') {
		echo update();
	}

    if(!empty($_POST['action']) && $_POST['action'] == 'delete_file') {
		echo delete_file();
	}

    if(!empty($_POST['action']) && $_POST['action'] == 'upload') {
		echo a();
	}


    function add_const_to_string($str)
	{
		return 'uploads/' . $str;
	}

	function process_filename($f) 
	{
		$f_array = explode(" ", $f);
		$f_processed = implode("_", $f_array);
		return $f_processed;
	}

    
    function a() {
		$allowed_images = array('png', 'jpg');
		$allowed_files = array('pdf', 'doc', 'docx');
		$upload_files = array();
		$upload_images = array();

        $recordid = $_POST['recordid'];
		$files = $_POST['formFileMultiple'];
		
		$f = array();
		$f = explode(";", json_decode($files)); //array_filter([$_FILES['file']['name']]);

		foreach($f as $fh) {
			$ext = pathinfo($fh, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed_files)) {
				array_push($upload_files, $fh);
			} else {
				array_push($upload_images, $fh);
			}
		}

		// var_dump($upload_files);
		// echo "<br/>";
		// var_dump($upload_images);
		// echo "<br/>";
	
		$upload_files_processed = array_map('add_const_to_string', $upload_files);
		$upload_images_processed = array_map('add_const_to_string', $upload_images);

		// var_dump($upload_files_processed);
		// echo "<br/>";
		// var_dump($upload_images_processed);
		
		foreach($upload_files_processed as $file)
		{
			//var_dump($file);
			insert_data_files($recordid, 1, $file);
		}

		foreach($upload_images_processed as $image)
		{
			//var_dump($image);
			insert_data_files($recordid, 2, $image);
		}

		$no_files = count($f);
		for ($i = 0; $i < $no_files; $i++) {
			$tmpname = $f[$i];
			$name = $f[$i];
			if (file_exists('uploads/' . $name)) {
				echo 'File already exists : uploads/' . $f[$i];
			} else {
				move_uploaded_file($tmpname, 'uploads/' . $name);
				echo 'File successfully uploaded : uploads/' . $name . ' ';
			}
		}
	}


    
    //========================Functions for Data========================

    function update()
	{
		global $pdo;
        $id = $_POST['id'];
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $threedurl1 = $_POST['threedurl1'];
        $threedurl2 = $_POST['threedurl2'];
        $additionalinfourl = $_POST['additionalinfourl'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];

		$sql = <<<EOD
        UPDATE Data SET 
        Title = :title, 
        Description = :desc, 
        3durl1 = :threedurl1, 
        3durl2 = :threedurl2, 
        AdditionalInfoUrl = :additionalinfourl, 
        Option1 = :option1, 
        Option2 = :option2 
        WHERE Id = :id
        EOD;
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
        $stmt->bindParam(":threedurl1", $threedurl1, PDO::PARAM_STR);
        $stmt->bindParam(":threedurl2", $threedurl2, PDO::PARAM_STR);
        $stmt->bindParam(":additionalinfourl", $additionalinfourl, PDO::PARAM_STR);
        $stmt->bindParam(":option1", $option1, PDO::PARAM_STR);
        $stmt->bindParam(":option2", $option2, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
        
	}

    //========================End of Functions for Data========================



    //========================Functions for Data Files========================

    function insert_data_files($dataid_ref, $typeid_ref, $file_ref)
	{
		global $pdo;
		$dataid = $dataid_ref;
		$typeid = $typeid_ref;
		$file = $file_ref;
		
		$sql = "INSERT INTO DataFiles(DataId, TypeId, JsonData) VALUES(:dataid, :typeid, :uploadedfile)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":dataid", $dataid, PDO::PARAM_INT);
		$stmt->bindParam(":typeid", $typeid, PDO::PARAM_INT);
		$stmt->bindParam(":uploadedfile", $file, PDO::PARAM_STR);

		try {
			$stmt->execute();
			$retid = $pdo->lastInsertId();
		} catch(PDOException $err) {
			echo $err->getMessage();
		}

		return $retid;
	}

    function delete_file() 
    {
        global $pdo;
        $id = $_POST['id'];
        $sql = "delete from DataFiles where Id = :id";
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    //========================End of Functions for Data Files========================


?>