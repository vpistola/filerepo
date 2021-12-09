<?php
session_start();
require_once 'header.php'; 
require_once 'functions.php';

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
            <p class='lead'>Record details (user : <strong>$user</strong>)</p>
        </div>
    </div>
_END;
//if ($loggedin) echo " $user, you are logged in";
//else echo ' please log in';

if(isset($_REQUEST['id']) && $_REQUEST['id']) {
    $id =  sanitizeString($_REQUEST['id']);
} else {
    die("You must give id parameter..");
}

if($result = fetchDataById($id)) {
    $active_data = $result;
}


?>

        <?php if($loggedin) { ?>
            <div class="container-fluid">
                <div class="text-center mt-5">
                    <!-- <h3>Record Details</h3>  -->
                    <!-- <p class="lead">File List</p> -->
                </div>
            
                <!-- <form method="POST" enctype="multipart/form-data" id="fileUploadForm"> -->
                
                <div class="form-row">
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="inputEmail4">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $active_data['Title']; ?>" placeholder="Title">
                    </div>
                    
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="desc">Description</label>
                        <!-- <input type="text" class="form-control" id="desc" name="desc" placeholder="Password"> -->
                        <textarea class="form-control" id="desc" name="desc" rows="6"><?php echo $active_data['Description']; ?></textarea>  
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="3durl">3D-URL 1</label>
                        <input type="text" class="form-control" id="3durl1" name="3durl1" value="<?php echo $active_data['Threedurl1']; ?>" placeholder="3D-URL">
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="3durl">3D-URL 2</label>
                        <input type="text" class="form-control" id="3durl2" name="3durl2" value="<?php echo $active_data['Threedurl2']; ?>" placeholder="3D-URL">
                    </div>
                    
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="additionalinfourl">Additional Info URL</label>
                        <input type="text" class="form-control" id="additionalinfourl" name="additionalinfourl" value="<?php echo $active_data['AdditionalInfoUrl']; ?>" placeholder="Additional-Info-URL">
                    </div>
                </div>
                
                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="option1">Option1</label>
                    <select class="form-control" id="option1" name="option1">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="option2">Option2</label>
                    <select class="form-control" id="option2" name="option2">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <input type="hidden" name="recordid" id="recordid" value="<?php echo $active_data["Id"]; ?>" />
                <input type="hidden" name="option1id" id="option1id" value="<?php echo $active_data["Option1"]; ?>" />
                <input type="hidden" name="option2id" id="option2id" value="<?php echo $active_data["Option2"]; ?>" />

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="save">Click below to save the changes</label>
                </div>

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-outline-secondary" id="save">Save</button>
                </div>

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="multiple_file_input" class="form-label">Click bellow to add more files to list</label>
                    <input class="form-control" type="file" id="multiple_file_input" name="file[]" multiple="multiple"/>
                </div>    

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <input type="submit" name="save" id="upld" class="btn btn-outline-secondary" value="Upload" />
                </div>
            <!-- </form> -->
  
            <br/>
            <div class="text-center mt-5">
                <!-- <h3>Record Details</h3>  -->
                <p class="lead">File List</p>
            </div>

            <!-- <div class="form-inline col-md-6" style="margin-bottom: 10px">
                <button type="submit" class="btn btn-outline-secondary" id="add">Add File</button>
            </div> -->

            <?php

            echo "<table id='example' class='stripe' style='width:100%'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>File</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";   

            if($result = fetchDataFiles($id)){
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td style='width:7%'>" . $row['Id'] . "</td>";
                    echo "<td>" . $row['JsonData'] . "</td>"; ?>
                    <td style='width: 7%'><div style='display: flex;'>
                        <button type="button" name="delete" id="<?php echo $row['Id']; ?>" class="btn btn-xs item_delete" ><i class="fa fa-trash" aria-hidden="true"></i></button></div>
                    </td>
                    
            <?php  echo "</tr>";
                }
            }

            ?>
            
            <!-- <div id="modal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="formid" action="grid_actions.php" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit</h4>
                            </div>
                            <div class="modal-body">
                                <label for="multiple_file_input" class="form-label">Multiple files input</label>
                                <input class="form-control" type="file" id="multiple_file_input" name="image_gallery[]" multiple="multiple"/>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="modal_id" id="modal_id" />
                                <input type="hidden" name="action" id="action" value="update" />
                                <input type="submit" name="save" ip="upld" class="btn btn-outline-secondary" value="Upload" />
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
                            </div>  
                        </div>
                    </form>
                </div>
            </div> -->

            <?php //include 'footer.php' ?>
        
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
        <script src="js/grid_details.js"></script>
        <!-- <script src="js/scripts.js"></script> -->
        
        <script src="js/toastr.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script> -->
        
        <script>
            var opt1 = $('#option1id').val();
            var opt2 = $('#option2id').val();
            $('#option1').val(opt1);
            $('#option2').val(opt2);
        </script>


    </body>
</html>
