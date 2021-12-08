<?php
$host = 'api_mysql';
$data = 'api';
$user = 'user';
$pass = 'user';
$chrs = "utf8mb4";
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts =
[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

global $pdo;

try 
{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $ex) 
{
    //throw new PDOException($ex->getMessage(), (int)$ex->getCode());
    echo $ex->getMessage();
}


function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query)
{
    global $pdo;
    return $pdo->query($query); 
}


function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
    
    session_destroy();
}


function sanitizeString($var)
{
    global $pdo;
    
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    $result = $pdo->quote($var);     // This adds single quotes

    return str_replace("'", "", $result);   // So now remove them
}



function fetchDataAsDropDown()
{
    global $pdo;
    $sectionHTML = '';
    $sql = "SELECT * from Data ORDER BY Id DESC";	
    $stmt = $pdo->query($sql);
    
    try {
        $result = $stmt->fetchAll();
    } catch(PDOException $err) {
        echo $err->getMessage();
    }

    foreach($result as $row) {
        $sectionHTML .= '<option value="'.$row["Id"].'">'.$row["Description"].'</option>';	
    }

    return $sectionHTML;
}



function fetchDataById($id_ref)
{
    global $pdo;
    $row = array();
    $id = $id_ref;
    $sql= "SELECT Id, Title, Description, 3durl1 as Threedurl1, 3durl2 as Threedurl2, AdditionalInfoUrl, Option1, Option2 FROM Data WHERE Id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $row = $stmt->fetch();
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
    
    return $row;
}


function fetchData() 
{
    global $pdo;
    $result = array();
    $sql = "SELECT * from Data ORDER BY Id DESC";
    // $sql = <<<EOD
    // select 
    // d.Id,
    // d.Title,
    // d.Description,
    // d.3durl1,
    // d.3durl2,
    // d.AdditionalInfoUrl,
    // d.Option1,
    // d.Option2,
    // df.JsonData
    // from Data d
    // inner join DataFiles df on df.DataId=d.Id
    // EOD;
    $stmt = $pdo->query($sql);
    
    try {
        $result = $stmt->fetchAll();
    } catch(PDOException $err) {
        echo $err->getMessage();
    }

    return $result;
}


function fetchDataFiles($id_ref) 
{
    global $pdo;
    $id = $id_ref;
    $data = array();
    $sql = "select * from DataFiles where DataId=:dataid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":dataid", $id, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $data = $stmt->fetchAll();
    } catch(PDOException $err) {
        echo $err->getMessage();
    }

    return $data;
}






?>