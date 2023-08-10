<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login() ?>
<?php
// Fetching the existing Admin Data Start

$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
    $ExistingName = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
} 
// Fetching the existing Admin Data End
if(isset($_POST["Submit"])) {
    $AName = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio = $_POST["Bio"];
    $Image = $_FILES["Image"]["name"];
    $Target ="Images/".basename($_FILES["Image"]["name"]);


if(strlen($AHeadline)>30){
        $_SESSION["ErrorMessage"] = "Headline should be less than 30 characters";
        Redirect_to("MyProfile.php");
    }
    elseif(strlen($ABio)>500){
        $_SESSION["ErrorMessage"] = "Bio should be less than 500 characters";
        Redirect_to("MyProfile.php");
    }else{

//Query to update Admin Data in DB when everything is fine
        global  $ConnectingDB;

        if(!empty($_FILES["Image"]["name"])) {
            $sql = "UPDATE admins 
            SET aname='$AName', aheadline='$AHeadline', abio = '$ABio', aimage='$Image'
            WHERE id='$AdminId'";

        }else{
            $sql = "UPDATE admins 
            SET aname='$AName', aheadline='$AHeadline', abio = '$ABio'
            WHERE id='$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Details updated Successfully";
            Redirect_to("MyProfile.php");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to("Myprofile.php");
        }
    }
} //Ending of submit button if-condition
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
    <link rel="stylesheet" href="Css/style.css">
    <title>My Profile</title>
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
                        <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user text-success"></i> My
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a>
                    </li>
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
                <div class="col">
                    <div class="col-md-12">
                        <h1> <i class="fas fa-user text-success mr-2" style="color:#27aae1"></i>@<?php echo $ExistingUsername; ?></h1>
                        <small><?php echo $ExistingHeadline; ?></small>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Area -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3> <?php echo $ExistingName; ?> </h3>
                    </div>
                    <div class="card-body">
                        <img src="Images/<?php echo $ExistingImage; ?>" alt="" class="block img-fluid mb-3">
                        <div class="">
                            <?php echo $ExistingBio; ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Right Area -->
        <div class="col-md-9" style="min-height: 400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
            <div class="card bg-dark text-light">
                <div class="card-header bg-secondary text-light">
                    <h4>Edit Profile</h4>
                </div>
                  <div class="card-body">
                  <div class="form-group">
                   <input class="form-control" type="text" name="Name" id="title" placeholder="Your name here"value="">
                    </div>
                    <div class="form-group">
                   <input class="form-control" type="text" id="title" placeholder="Headline" Name="Headline">
                   <small class="text-muted">Add a professional headline like 'Enginner' at XYZ or 'Architect'</small>
                   <span class="text-danger">
                       Not more than 30 characters
                   </span>
                     </div>
                     <div class="form-group">
                     <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" cols="80" rows="8"></textarea>
                     </div>

                     <div class="form-group">
                     <div class="custom-file">
                     <input class="custom-file-input" type="File" name = "Image" id = "imageSelect" value="">
                     <label for="imageSelect" class="custom-file-label">Select Image</label>
                     </div>
                     </div>


                    <div class="row">
                    <div class="col-lg-6 mb-2" >
                        <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard </a>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <button type="submit" name="Submit"class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Publish
                        </button>
                    </div>

                </div>
                </div>
            </div>
        </form>
        </div>
        </div>

    </section>

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