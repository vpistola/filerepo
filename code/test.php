<?php

if (!empty($_FILES)) {
$newitemid = $curid;
$originalfilename = $_FILES['file']['name'];
$inserted_media_id=insert_file($userAreaId,$file_type_id,$newitemid,$originalfilename,"");
if($inserted_media_id>0){
$mainext = strtolower(pathinfo($originalfilename, PATHINFO_EXTENSION));
if ($file_type_id == 1) {
if ($mainext == 'png' || $mainext == 'gif' || $mainext == 'jpg') {
$mimetypes = $config_multimedia_allowed_mime_types;
} else {
$errormainup = true;
$errorMsg = "<span style='color:red'>Not proper file extension for main image!</span>";
}
}
$filesize=$_FILES['file']['size'];
$max_file_size = 30 * 1024 * 1024;
if ($filesize > 0 && $filesize < $max_file_size) {
$uploaded_file_full = $newitemid."_".$inserted_media_id.".".$mainext;
if($file_type_id==1){
$uploaded_main_image_file_thumb= $newitemid."_".$inserted_media_id."_thumb.".$mainext;
}
//Check if folder exists
$poi_dir = $Config_upload_dir . '\\1\\' . $newitemid;
if (!file_exists($poi_dir)) {
mkdir($poi_dir);
}
//Check if folder is empty and if yes delete all existing
if (!is_dir_empty($poi_dir)) {
delete_files_in_folder($poi_dir);
}
} else {
$errormainup = true;
$errorMsg = "<span style='color:red'>Not proper image file size!</span>";
}
if(!$errormainup){
try {
$res2 = upload_file_new($_FILES['file'], $poi_dir, $uploaded_file_full, $allowed_types, true, 'File uploading');
if ($res2 == 0) {
if ($file_type_id == 1) {
if (!($mainext == 'jpg' || $mainext == 'jpeg')){
$ic = new Image_converter();
if (!($ic->convert_image('jpg', $poi_dir, $originalfilename, 100))) {
$errorMsg = "<span style='color:red'>Error in format conversion of image!</span>";
}
$originalfilename = str_replace(".$mainext", ".jpg", $originalfilename);
}
$imagefile = $newitemid . "_" . $inserted_media_id . ".jpg";
$imagefile_small = $newitemid . "_" . $inserted_media_id . "_small.jpg";
$imagefile_thumb = $newitemid . "_" . $inserted_media_id . "_thumb.jpg";
$real_file_name=$imagefile_small;
//copy("$poi_dir/$originalfilename", "$poi_dir/$imagefile");
list($width, $height) = getimagesize("$Config_upload_dir/1/$newitemid/$originalfilename");
//Creating resizes
make_thumb("$poi_dir/$originalfilename", "$poi_dir/$imagefile_small", "320");
make_thumb("$poi_dir/$originalfilename", "$poi_dir/$imagefile_thumb", "75");
//Delete created jpg copy of original file
if (!($mainext == 'jpg' || $mainext == 'jpeg')) {
unlink("$poi_dir/$originalfilename");
}
}else{
$real_file_name=$newitemid . "_" . $inserted_media_id . ".".$mainext;
//copy("$poi_dir/$originalfilename", "$poi_dir/$real_file_name");
$width=0;
$height=0;
}
copy("$poi_dir/$originalfilename", "$poi_dir/$real_file_name");
$url_img_path = 'instance_images\\1\\' . $newitemid . '\\' . $real_file_name;
$result=update_file($inserted_media_id, $url_img_path, $width, $height);
if($result){
create_empty_file_captions($inserted_media_id,$langs_array);
}



}
}catch(Exception $err1) {
echo $err1->getMessage();
}
}else{
echo $errorMsg;
}
}
}


?>