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
                    $id = $row['Id'];
                    $files = array();
                    $images = array();

                    $dfiles = fetchDataFiles($id);
                    
                    $html .= "<div class='container'>
                    <h5 class='card-title'>" . $id . ". " . $row['Title'] . "</h5>
                    <p class='card-text'>" . $row['Description'] . "</p>";

                    

                    // var_dump($dfiles);
                    foreach($dfiles as $file) {
                        $f = $file['JsonData'];
                        if (strpos($f, '.pdf') || strpos($f, '.doc') || strpos($f, '.docx')) {
                            array_push($files, $f);    
                        } else {
                            array_push($images, $f);
                        }
                    }

                    if ($images) {
                        $html .= "<div class='row'>";
                        foreach($images as $img) {
                            $html .= "<div class='col'>
                            <a href='" . $img . "'>
                            <img src='" . $img . "' class='card-img-top' style='width: 25%' title='". pathinfo($img, PATHINFO_FILENAME) . "." . pathinfo($img, PATHINFO_EXTENSION) . "'>
                            </a>
                            </div>
                            ";
                        }
                        $html .= "</div>";
                    }

                    if ($files) {
                        $html .= "<div class='row'>";
                        foreach($files as $fi) {
                            $html .= "<div class='col'>
                            File : ". pathinfo($fi, PATHINFO_FILENAME) ."." . pathinfo($fi, PATHINFO_EXTENSION) . " <a href='" . $fi . "' class='btn btn-light btn-sm'>View</a>
                            </div>
                            ";
                        }
                        $html .= "</div>";
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
           
            <?php include 'footer.php' ?>
       
            <!-- Image : ". pathinfo($img, PATHINFO_FILENAME) ."." . pathinfo($img, PATHINFO_EXTENSION) . " <a href='" . $img . "' class='btn btn-light btn-sm'>View</a> -->

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
        <script src="js/scripts_novalidation.js"></script>
        <script src="js/toastr.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script> -->
        
    </body>
</html>
