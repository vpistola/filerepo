<?php
    require_once "functions.php"; 

    if(!empty($_POST['action']) && $_POST['action'] == 'fetch') {
		fetch();
	}

	if(!empty($_POST['action']) && $_POST['action'] == 'fetchbyid') {
		$id = $_POST['id'];
		fetchById($id);
	}

	if(!empty($_POST['action']) && $_POST['action'] == 'update') {
		$id = $_POST['modal_id'];
		$title = $_POST['modal_title'];
		$desc = $_POST['modal_desc'];
		$threedurl1 = $_POST['modal_3durl1'];
		$threedurl2 = $_POST['modal_3durl2'];
		$additionalinfourl = $_POST['modal_additional'];
        $option1 = $_POST['modal_opt1'];
		$option2 = $_POST['modal_opt2'];

		update($id, $title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2);
	}

	if(!empty($_POST['action']) && $_POST['action'] == 'delete') 
	{
		$id = $_POST['id'];
		deleteById($id);
	}


	if (isset($_FILES['file']) && !empty($_FILES['file'])) 
	{
		$allowed_images = array('png', 'jpg');
		$allowed_files = array('pdf', 'doc', 'docx');
		$upload_files = array();
		$upload_images = array();

		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$threedurl1 = $_POST['3durl1'];
		$threedurl2 = $_POST['3durl2'];
		$additionalinfourl = $_POST['additionalinfourl'];
        $option1 = $_POST['option1'];
		$option2 = $_POST['option2'];
		$files = $_POST['formFileMultiple'];

		//$data_id = insert_data($title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2);
		
		//$f : array(1) { [0]=> array(2) { [0]=> string(17) "Vourvoukeli_3.JPG" [1]=> string(17) "Vourvoukeli_4.JPG" } }
		$f = $files; //array_filter([$_FILES['file']['name']]);
		echo $f;

		foreach($f[0] as $fh) {
			$ext = pathinfo($fh, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed_files)) {
				array_push($upload_files, $fh);
			} else {
				array_push($upload_images, $fh);
			}
		}

		//$upload_files_processed = implode(";", array_map('add_const_to_string', $upload_files));
		//$upload_images_processed = implode(";", array_map('add_const_to_string', $upload_images));

		$upload_files_processed = array_map('add_const_to_string', $upload_files);
		$upload_images_processed = array_map('add_const_to_string', $upload_images);

		//var_dump($upload_files);
		//var_dump($upload_images);
		
		foreach($upload_files_processed as $file)
		{
			//var_dump($file);
			//insert_data_files($data_id, 1, $file);
		}

		foreach($upload_images_processed as $image)
		{
			//var_dump($image);
			//insert_data_files($data_id, 2, $image);
		}

		// $f[0] : { [0]=> string(17) "Vourvoukeli_3.JPG" [1]=> string(17) "Vourvoukeli_4.JPG" }
		// $files0 = array_map('add_const_to_string', $f[0]);
		// $files = implode(";", $files0);
		// //upload($title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2, process_filename($files));
		
		echo $no_files = count($_FILES["file"]['name']);
		// for ($i = 0; $i < $no_files; $i++) {
		// 	$tmpname = process_filename($_FILES["file"]["tmp_name"][$i]);
		// 	$name = process_filename($_FILES["file"]["name"][$i]);
		// 	if ($_FILES["file"]["error"][$i] > 0) {
		// 		echo "Error: " . $_FILES["file"]["error"][$i] . "<br>";
		// 	} else {
		// 		if (file_exists('uploads/' . $name)) {
		// 			echo 'File already exists : uploads/' . $_FILES["file"]["name"][$i];
		// 		} else {
		// 			//array_push($json_data, $name);
		// 			move_uploaded_file($tmpname, 'uploads/' . $name);
		// 			echo 'File successfully uploaded : uploads/' . $name . ' ';
		// 		}
		// 	}
		// }
		//echo upload($title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2, process_filename($upload_files_processed), process_filename($upload_images_processed));
		
	} else if (empty($_POST['action'])){
		echo 'Please choose at least one file';
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


	//===================================================================================
	function fetch()
	{
		global $pdo;
		$result = array();
		$sql= "SELECT * FROM Data";
		$stmt = $pdo->query($sql);
		
		try {
			$result = $stmt->fetchAll();
		} catch(PDOException $err) {
			echo $err->getMessage();
		}

		echo json_encode($result);
	}


	function insert_data($title_ref, $desc_ref, $threedurl1_ref, $threedurl2_ref, $additionalinfourl_ref, $option1_ref, $option2_ref)
	{
		global $pdo;
		$title = $title_ref;
		$desc = $desc_ref;
		$threedurl1 = $threedurl1_ref;
		$threedurl2 = $threedurl2_ref;
		$additionalinfourl = $additionalinfourl_ref;
		$option1 = $option1_ref;
		$option2 = $option2_ref;
		$sql = "INSERT INTO Data(Title, Description, 3durl1, 3durl2, AdditionalInfoUrl, Option1, Option2) VALUES(:title, :descr, :threedurl1, :threedurl2, :additionalinfourl, :option1, :option2)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":title", $title, PDO::PARAM_STR);
		$stmt->bindParam(":descr", $desc, PDO::PARAM_STR);
		$stmt->bindParam(":threedurl1", $threedurl1, PDO::PARAM_STR);
		$stmt->bindParam(":threedurl2", $threedurl2, PDO::PARAM_STR);
		$stmt->bindParam(":additionalinfourl", $additionalinfourl, PDO::PARAM_STR);
		$stmt->bindParam(":option1", $option1, PDO::PARAM_INT);
		$stmt->bindParam(":option2", $option2, PDO::PARAM_INT);

		try {
			$stmt->execute();
			$retid = $pdo->lastInsertId();
		} catch(PDOException $err) {
			echo $err->getMessage();
		}

		return $retid;
	}


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
		$stmt->bindParam(":uploadedfile", $uploadedfile, PDO::PARAM_STR);

		try {
			$stmt->execute();
			$retid = $pdo->lastInsertId();
		} catch(PDOException $err) {
			echo $err->getMessage();
		}

		return $retid;
	}



	function delete_data_by_id($id){
		global $pdo;
		$sql = "DELETE FROM Data WHERE Id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":id". $id, PDO::PARAM_INT);

		try {
			$stmt->execute();
		} catch(PDOException $err) {
			echo $err->getMessage();
		}
	}

	//===================================================================================


	// function fetch()
	// {
	// 	global $connection;
	// 	$sql= "SELECT * FROM Data";
	// 	$result = mysqli_query($connection, $sql);	
	// 	$data= array();
	// 	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	// 		$data[]=$row;            
	// 	}
	// 	echo json_encode($data);
	// }

	// function fetchById($id)
	// {
	// 	global $connection;
	// 	$sql= "SELECT Id, Title, Description, 3durl1 as Threedurl1, 3durl2 as Threedurl2, AdditionalInfoUrl, Option1, Option2, JsonDataText, JsonDataImages FROM Data WHERE Id=$id";
	// 	$result = mysqli_query($connection, $sql);	
	// 	$data= array();
	// 	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	// 		$data[]=$row;            
	// 	}
	// 	echo json_encode($data);
	// }


	// function upload($title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2, $name, $name2)
	// {
	// 	global $connection;
	// 	$sql = "INSERT INTO Data(Title, Description, 3durl1, 3durl2, AdditionalInfoUrl, Option1, Option2, JsonDataText, JsonDataImages) VALUES('$title', '$desc', '$threedurl1', '$threedurl2', '$additionalinfourl', '$option1', '$option2', '$name', '$name2')";
	// 	mysqli_query($connection, $sql) or die(mysqli_error($connection));
	// }



	// function update($id, $title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2)
	// {
	// 	global $connection;
	// 	$sql = "UPDATE Data SET Title = '$title', Description = '$desc', 3durl1 = '$threedurl1', 3durl2 = '$threedurl2', AdditionalInfoUrl = '$additionalinfourl', Option1 = $option1, Option2 = $option2 WHERE Id = $id";
	// 	mysqli_query($connection, $sql) or die(mysqli_error($connection));
	// }


	// function deleteById($id){
	// 	global $connection;
		
	// 	if($id) {
	// 		$sql = "DELETE FROM Data WHERE Id = $id";		
	// 		mysqli_query($connection, $sql);		
	// 	}
	// }


?>