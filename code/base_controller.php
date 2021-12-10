<?php
require_once "functions.php"; 


// Upload event handler
//======================================================================================
$allowed_images = array('png', 'jpg');
$allowed_files = array('pdf', 'doc', 'docx');
$upload_files = array();
$upload_images = array();
$path = 'uploads/'; // upload directory
$attached_title = array();

$title = $_POST['title'];
$desc = $_POST['desc'];
$threedurl1 = $_POST['threedurl1'];
$threedurl2 = $_POST['threedurl2'];
$additionalinfourl = $_POST['additionalinfourl'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$f = $_FILES['files']['name'];
$no_files = count($f);

for($i = 0; $i < $no_files; $i++) {
	$index = 'desc' . ($i+1);
	array_push($attached_title, $_POST[$index]);
}

$data_id = insert_data($title, $desc, $threedurl1, $threedurl2, $additionalinfourl, $option1, $option2);


foreach($f as $key=>$fh) {
	$ext = pathinfo($fh, PATHINFO_EXTENSION);
	if (in_array($ext, $allowed_files)) {
		insert_data_files($data_id, 1, 'uploads/' . $fh, $attached_title[$key]);
		//array_push($upload_files, $fh);
	} else {
		insert_data_files($data_id, 2, 'uploads/' . $fh, $attached_title[$key]);
		//array_push($upload_images, $fh);
	}
}

$upload_files_processed = array_map('add_const_to_string', $upload_files);
$upload_images_processed = array_map('add_const_to_string', $upload_images);

// foreach($upload_files_processed as $key=>$file)
// {
// 	insert_data_files($data_id, 1, $file, $attached_title[$key]);
// }

// foreach($upload_images_processed as $key=>$image)
// {
// 	insert_data_files($data_id, 2, $image);
// }

for ($i = 0; $i < $no_files; $i++) {
	$tmpname = $_FILES["files"]["tmp_name"][$i];
	$name = $_FILES["files"]["name"][$i];
	if ( 0 < $_FILES['files']['error'][$i] ) {
		echo 'Error: ' . $_FILES['files']['error'][$i] . '<br>';
	}
	if (file_exists($path . $name)) {
		echo 'File already exists : '. $path . $tmpname;
	} else {
		move_uploaded_file($tmpname, $path . $name);
		echo 'File successfully uploaded :' . $path . $name . ' ';
	}
}

echo 'ok';
//======================================================================================


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


function fetchById($id)
{
	global $pdo;
	$row = array();
	$sql= "SELECT Id, Title, Description, 3durl1 as Threedurl1, 3durl2 as Threedurl2, AdditionalInfoUrl, Option1, Option2 FROM Data WHERE Id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(":id", $id, PDO::PARAM_INT);

	try {
		$stmt->execute();
		$row = $stmt->fetch();
	} catch (PDOException $err) {
		echo $err->getMessage();
	}

	echo json_encode($data);
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



?>