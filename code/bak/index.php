<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Entry Platform</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/toastr.min.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Insert</a></li>
                        <li class="nav-item"><a class="nav-link" href="api.php">Fetch</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>Platform</h1>
                <p class="lead">Please enter data below</p>
            </div>

            <form>
                <div class="form-row">
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="inputEmail4">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                    </div>
                    
                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="desc">Description</label>
                        <input type="text" class="form-control" id="desc" name="desc" placeholder="Password">
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 10px">
                        <label for="3durl">3D-URL</label>
                        <input type="text" class="form-control" id="3durl" name="3durl" placeholder="3D-URL">
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

                <div class="form-inline col-md-6" style="margin-bottom: 10px">
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" type="file" id="formFileMultiple" name="files[]" multiple />
                </div>

                
                <button type="submit" class="btn btn-outline-secondary" id="upload">Upload</button>
            </form>

            </br>
            <p id="msg"></p>
        </div>

        

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        
        <script src="js/jquery.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/toastr.min.js"></script>
    </body>
</html>
