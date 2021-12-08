<?php 
ob_start();
session_start();
require_once "header.php";
require_once "functions.php";

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
}
else $loggedin = FALSE;

if ($loggedin) {
    header('Location: index.php');
    ob_end_flush();
}

if( isset($_POST['username']) && isset($_POST['password']) ) {

    $username = sanitizeString($_POST['username']);
    $password = sanitizeString($_POST['password']); 
    
    global $pdo;
    $row = array();
    $sql = "SELECT * FROM Users WHERE Username = :user and Password = :pass";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user", $username, PDO::PARAM_INT);
    $stmt->bindParam(":pass", $password, PDO::PARAM_INT);
    
    try {
        $stmt->execute();
        $row = $stmt->fetch();
    } catch(PDOException $err) {
        echo $err->getMessage();
    }

    if (!$row) die ("User/Password does not exist!");

    $user = $row['Username'];
    $_SESSION['user'] = $user;
    //header("Location : index.php");
    header('Location: index.php');
    
}
ob_end_flush();

?>

        <div class="container-fluid">
            <div class="text-center mt-5">
                <!-- <h1>Platform</h1> -->
                <!-- <p class="lead">File List</p> -->
            </div>

            <form action="login.php" method="post">
                <section class="vh-100">
                    <div class="container py-5 h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <h3 class="mb-5">Sign in</h3>

                                <div class="form-outline mb-4">
                                <input type="text" id="username" name='username' class="form-control form-control-lg" />
                                <label class="form-label" for="username">Username</label>
                                </div>

                                <div class="form-outline mb-4">
                                <input type="password" id="password" name='password' class="form-control form-control-lg" />
                                <label class="form-label" for="password">Password</label>
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check d-flex justify-content-start mb-4">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="form1Example3"
                                />
                                <label class="form-check-label" for="form1Example3"> Remember password </label>
                                </div>

                                <button class="btn btn-outline-secondary btn-lg btn-block" type="submit">Login</button>
                                <!-- <hr class="my-4"> -->

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </section>
            </form>

            <?php //include 'footer.php' ?>

        </div>    

        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
        
    </body>
</html>