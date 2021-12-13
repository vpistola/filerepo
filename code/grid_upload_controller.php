<?php
/*
 * This is the controller responsible for the files upload 
 * the user can perform from the grid_details page.
 *
 */

require_once "functions.php"; 
//$valid_extensions = array('jpeg', 'jpg', 'png', 'pdf' , 'doc' , 'docx'); // valid extensions

$allowed_images = array('png', 'jpg', 'jpeg');
$allowed_files = array('pdf', 'doc', 'docx');
$upload_files = array();
$upload_images = array();
$path = 'uploads/'; // upload directory

//var_dump($_FILES['files']);
$f = $_FILES['files']['name'];
$recordid = $_POST['recordid'];

foreach($f as $fh) {
    $ext = pathinfo($fh, PATHINFO_EXTENSION);
    if (in_array($ext, $allowed_files)) {
        array_push($upload_files, $fh);
    } else {
        array_push($upload_images, $fh);
    }
}


$upload_files_processed = array_map('add_const_to_string', $upload_files);
$upload_images_processed = array_map('add_const_to_string', $upload_images);

// var_dump($upload_files_processed);
// echo "<br/>";
// var_dump($upload_images_processed);

foreach($upload_files_processed as $file)
{
    //var_dump($file);
    insert_data_files($recordid, 1, $file, "");
}

foreach($upload_images_processed as $image)
{
    //var_dump($image);
    insert_data_files($recordid, 2, $image, "");
}

//$files = array_filter($_FILES['files']['name']);

$no_files = count($f);
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


?>