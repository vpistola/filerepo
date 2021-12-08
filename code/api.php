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
        <link href="css/json-viewer.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    </head>
    <body>
        <pre id="json" style="white-space: pre-wrap"></pre>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var jsonViewer = new JSONViewer();

                data = { 
                    action: "fetch"
                };

                $.ajax({
                    type: "POST",
                    url: "./actions.php",
                    data: data,
                    success: function ( response ) {
                        var res = JSON.parse(response);
                        var obj = [];

                        console.log(res);
                        res.forEach(function (arrayItem){
                            if (arrayItem.JsonDataText != "") {
                                var jdtext = arrayItem.JsonDataText.split(";");
                                delete arrayItem.JsonDataText;
                                arrayItem.JsonDataText = jdtext;
                            } else if (arrayItem.JsonDataImages != "") {
                                var jdimage = arrayItem.JsonDataImages.split(";");
                                delete arrayItem.JsonDataImages;
                                arrayItem.JsonDataImages = jdimage;
                            }
                            obj.push(arrayItem);
                        });

                        //console.log(obj);
                        document.querySelector("#json").appendChild(jsonViewer.getContainer());
                        jsonViewer.showJSON(obj);
                    },
                    error: function (response) {
                        console.error(response);
                    }
                });
            });
        </script>

        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <!-- <script src="js/scripts.js"></script> -->
        <script src="js/json-viewer.js"></script>

    </body>
</html>
