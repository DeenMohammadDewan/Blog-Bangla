<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!-- Fetching Existing Data -->
<?php 
$SearchQueryParameter = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName',$SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1){
    while($DataRows=$stmt->fetch()){
    $ExistingName = $DataRows["aname"];
    $ExistingBio = $DataRows["abio"];
    $ExistingImage = $DataRows["aimage"];
    $ExistingHeadline = $DataRows["aheadline"];
    }
}
else{
    $_SESSION["ErrorMessage"]="Bad Request!";
    Redirect_to("Blog.php?page=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Profile</title>
</head>

<body>
   <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">blogbangla.xyz</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block" action="Blog.php">
                    <input class="form-control mr-2"type="text" name="Search" placeholder="Search here" value="">
                    <button class="btn btn-primary" name="SearchButton">Go</button>
                </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>

    <!-- NAVBAR END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                
                    <div class="col-md-6">
                        <h1> <i class="fas fa-user text-success mr-2" style="color:#27aae1"></i> <?php echo $ExistingName; ?> </h1>
                        <h3><?php echo $ExistingHeadline; ?></h3>
                    
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="Images/<?php echo $ExistingImage; ?>" alt="" class="d-block img-fluid mb-3 rounded-circle">
            </div>
            <div class="col-md-9" style="min-height:400px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead">
                            <?php echo $ExistingBio; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Main Area -->



    <!-- End Main Area -->


    <!-- FOOTER -->

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center"> Test Project | <span id="year"></span> By A Beginner Level Learner
                        &copy;
                    </p>
                    <p class="text-center small">
                        This project is only for study purpose <br>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- FOOTER END -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        $('#year').text(new Date().getUTCFullYear());
    </script>

</body>

</html>