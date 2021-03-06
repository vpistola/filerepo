<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul id="menu" class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" id="home-nav" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" id="grid-nav" aria-current="page" href="grid.php">View Records</a></li>
                <li class="nav-item"><a class="nav-link" id="upload-nav" aria-current="page" href="upload.php">Upload</a></li>
                <li class="nav-item"><a class="nav-link" href="api.php">FetchAPI</a></li>
                <?php
                if ($loggedin) {
                    echo "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout</a></li>";        
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";        
                }
                ?>
            </ul>
        </div>
    </div>
</nav>