<?php
ob_start();
session_start();
require_once 'header.php'; 

if (isset($_SESSION['user']) && !empty($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
}
else $loggedin = FALSE;

if (!$loggedin) {
    header('Location: login.php');
    ob_end_flush();
}
        
?>
        <!-- Responsive navbar-->
<?php include 'navbar.php' ?>

        <div class="container">
            <div class="text-center mt-5">
                <!-- <h1>Platform</h1> -->
                <p class="lead">Please enter data below</p>
            </div>
        
            <form method="POST" enctype="multipart/form-data" id="fileUploadForm">
                <div class="form-row">
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="inputEmail4">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                    </div>
                    
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="desc">Description</label>
                        <!-- <input type="text" class="form-control" id="desc" name="desc" placeholder="Password"> -->
                        <textarea class="form-control" id="desc" name="desc" rows="6"></textarea>  
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="3durl">3D-URL 1</label>
                        <input type="text" class="form-control" id="3durl1" name="3durl1" placeholder="3D-URL">
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="3durl">3D-URL 2</label>
                        <input type="text" class="form-control" id="3durl2" name="3durl2" placeholder="3D-URL">
                    </div>
                    
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="additionalinfourl">Additional Info URL</label>
                        <input type="text" class="form-control" id="additionalinfourl" name="additionalinfourl" placeholder="Additional-Info-URL">
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

                <!-- <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-outline-secondary upload_images" style="width: 150px">Upload images</button>
                    <label for="upload_images"><i><strong>(use only jpeg or png images)</strong></i></label>
                </div> -->

                <!-- <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-outline-secondary upload_files" style="width: 150px">Upload Files</button>
                    <label for="upload_files"><i><strong>(use only pdf, doc or docx files)</strong></i></label>
                </div> -->

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="formFileMultiple" class="form-label">Multiple files input</label>
                    <input class="form-control" type="file" id="formFileMultiple" name="files[]" multiple />
                </div>

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-outline-secondary" id="upload">Upload</button>
                    <label for="upload" class="form-label">(only jpg, png, pdf, doc and docx files are accepted)</label>
                </div>
            </form>
            
            </br>
            <p id="msg"></p>
            <div id="filelist"></div>
            </br>
            

            <?php include 'footer.php' ?>

        </div>
        

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
