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
            
            echo "<table id='example' class='stripe' style='width:100%'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Title</th>";
            echo "<th>Description</th>";
            echo "<th>3D_URL_1</th>";
            echo "<th>3D_URL_2</th>";
            echo "<th>Additional Info URL</th>";
            echo "<th>Option 1</th>";
            echo "<th>Option 2</th>";
            // echo "<th>Files</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";   

            if($result = fetchData()){
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td style='width:7%'>" . $row['Id'] . "</td>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>" . $row['3durl1'] . "</td>";
                    echo "<td>" . $row['3durl2'] . "</td>";
                    echo "<td>" . $row['AdditionalInfoUrl'] . "</td>";
                    echo "<td>" . $row['Option1'] . "</td>";
                    echo "<td>" . $row['Option2'] . "</td>";
                    // echo "<td>" . $row['JsonData'] . "</td>"; ?>
                    <td><div style="display:flex">
                        <button type="button" name="update" id="<?php echo $row['Id']; ?>" class="btn btn-xs update" ><i class="fa fa-pencil-alt" aria-hidden="true"></i></button>
                        <button type="button" name="delete" id="<?php echo $row['Id']; ?>" class="btn btn-xs delete" ><i class="fa fa-trash" aria-hidden="true"></i></button></div>
                    </td>
                    
            <?php  echo "</tr>";
                }
            }

            ?>

            </table>

            <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="formid">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Edit</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title" class="col-form-label">Title*</label>
                                <input type="text" class="form-control" id="modal_title" name="modal_title" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="labels">Description*</label>
                                <input type="text" class="form-control" id="modal_desc" name="modal_desc" required>
                            </div>

                            <div class="form-group">
                                <label class="labels">3D URL 1*</label>
                                <input type="text" class="form-control" id="modal_3durl1" name="modal_3durl1" required>
                            </div>

                            <div class="form-group">
                                <label class="labels">3D URL 2*</label>
                                <input type="text" class="form-control" id="modal_3durl2" name="modal_3durl2" required>
                            </div>

                            <div class="form-group">
                                <label class="labels">Additional Info URL*</label>
                                <input type="text" class="form-control" id="modal_additional" name="modal_additional" required>
                            </div>

                            <div class="form-group">
                                <label class="labels">Option 1*</label>
                                <select class="form-control" id="modal_opt1" name="modal_opt1">
                                    <option value="">Choose...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="labels">Option 2*</label>
                                <select class="form-control" id="modal_opt2" name="modal_opt2">
                                    <option value="">Choose...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="labels">Json Data</label>
                                <textarea placeholder="Data..." class="form-control" id="model_jsondata" name="model_jsondata" rows="6" readonly></textarea>         
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="modal_id" id="modal_id" />
                            <input type="hidden" name="action" id="action" value="update" />
                            <input type="submit" name="save" id="save" class="btn btn-outline-secondary" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            
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
        <script src="js/scripts.js"></script>
        <script src="js/toastr.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script> -->
        
        <script>
            $(document).on('click', '.update', function () {
                var id = $(this).attr("id");
                window.location.href = './grid_details.php?id=' + id;
            });
        </script>
    </body>
</html>
