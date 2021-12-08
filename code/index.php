<?php
session_start();
require_once 'header.php'; 

if (isset($_SESSION['user']) && !empty($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
}
else $loggedin = FALSE;
      
include_once 'navbar.php';

if ($loggedin) {
    $user = $_SESSION['user'];
} else {
    $user = "please log in";
}

echo <<< _END
    <div class='container-fluid'>
        <div class='text-center mt-5'>
            <p class='lead'>Welcome to the platform, <strong>$user</strong></p>
        </div>
    </div>;
_END;
//if ($loggedin) echo " $user, you are logged in";
//else echo ' please log in';

?>

        <?php if($loggedin) { ?>
            <div class="container-fluid">
                <div class="text-center mt-5">
                    <!-- <h1>Platform</h1> 
                    <p class="lead">File List</p> -->
                </div>
            
            <?php
            
            include_once 'functions.php';
            $html = "";
            
            if($result = fetchData()){
                foreach ($result as $row) {
                    $file_paths = array();
                    $image_paths = array();

                    if ($row['JsonDataText']) {
                        $file_names = $row['JsonDataText'];
                        $file_paths = explode(";", $file_names);
                    }
                    
                    if ($row['JsonDataImages']) {
                        $image_names = $row['JsonDataImages'];
                        $image_paths = explode(";", $image_names);
                    }
                    //print_r($file_paths);
                    // $pdf_ext = strpos($file_names, '.pdf');
                    // $doc_ext = strpos($file_names, '.doc');
                    // $jpeg_ext = strpos($image_names, '.jpeg');
                    // $png_ext = strpos($image_names, '.png');
                    
                    $html .= "<div class='card' style='width: 40rem;'>
                    <div class='card-body'>
                    <h5 class='card-title'>" . $row['Title'] . "</h5>
                    <p class='card-text'>" . $row['Description'] . "</p>";

                    foreach($image_paths as $ipath) {
                        $html .= "
                        <img src='" . $ipath . "' class='card-img-top'></a>
                        Image : ". pathinfo($ipath, PATHINFO_FILENAME) ."." . pathinfo($ipath, PATHINFO_EXTENSION) . " <a href='" . $ipath . "' class='btn btn-outline-secondary'>View</a><br>
                        ";
                    }

                    foreach($file_paths as $fpath) {
                        $html .= "
                        File : ". pathinfo($fpath, PATHINFO_FILENAME) ."." . pathinfo($fpath, PATHINFO_EXTENSION) . " <a href='" . $fpath . "' class='btn btn-outline-secondary'>View</a><br>
                        ";
                    }

                    $html .= "
                    <p class='card-text'> 3D-URL-1 : " . $row['3durl1'] . "</p>
                    <p class='card-text'> 3D-URL-2 : " . $row['3durl2'] . "</p>
                    </div>
                    </div>
                    <hr>
                    ";


                }
            }
            
            echo $html;
            ?>

        </div>
        <?php 
        } else {
            echo "<div></div>";
        }
        ?>
        
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/toastr.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script> -->
        
    </body>
</html>
