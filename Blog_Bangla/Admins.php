<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login() ?>
<?php
if(isset($_POST["Submit"])) {
    $UserName = $_POST["Username"];
    $Name = $_POST["Name"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $Admin = "blogbangla";

    date_default_timezone_set("Asia/Dhaka");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;

    if(empty($UserName)||empty($Password)||empty($ConfirmPassword)) {
       $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("Admins.php");
    }
    elseif(strlen($Password)<4){
        $_SESSION["ErrorMessage"] = "Password should be greater than 3 characters";
        Redirect_to("Admins.php");
    }
    elseif($Password !== $ConfirmPassword){
        $_SESSION["ErrorMessage"] = "Password and Confirm Password should match";
        Redirect_to("Admins.php");
    }
    elseif(CheckUserNameExistsOrNot($UserName)){
        $_SESSION["ErrorMessage"] = "Username exists. Try another one! ";
        Redirect_to("Admins.php");
    }else{
        //Query to insert new admin in DB when everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
        $sql .="VALUES(:dateTime,:userName,:password,:aName,:adminName)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':userName',$UserName);
        $stmt->bindValue(':password',$Password);
        $stmt->bindValue(':aName',$Name);
        $stmt->bindValue(':adminName',$Admin);
        
        $Execute=$stmt->execute();

        if($Execute){
            $_SESSION["SuccessMessage"] = "New Admin with the name of ".$Name." Added Successfully";
            Redirect_to("Admins.php");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to("Admins.php");
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
    <title>Admin Page</title>
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
                        <h1> <i class="fas fa-user" style="color:#27aae1"></i> Manage Admins</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->

    <section class="container py-2 mb-4">
        <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form class="" action="Admins.php" method="post">
            <div class="card bg-secondary text-light mb-3">
                <div class="card-header">
                    <h1>Add New Admin</h1>
                </div>
                  <div class="card-body bg-dark">
                    <div class="form-group">
                        <label for="username"><span class="FieldInfo"> Username: </span></label>
                        <input class="form-control" type="text" name="Username" id="username">
                     </div>
                     <div class="form-group">
                        <label for="Name"><span class="FieldInfo"> Name: </span></label>
                        <input class="form-control" type="text" name="Name" id="Name">
                        <small class="text-muted">Optional</small>
                     </div>
                     <div class="form-group">
                        <label for="Password"><span class="FieldInfo"> Password: </span></label>
                        <input class="form-control" type="password" name="Password" id="Password">
                     </div>
                     <div class="form-group">
                        <label for="ConfirmPassword"><span class="FieldInfo"> Confirm Password: </span></label>
                        <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword">
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
         <h2>Existing Admins</h2>
        <table class="table table-stripped table-hover">
        <thead class="thead-dark">      
            <tr>
                <th>No.</th>
                <th>Date&Time</th>
                <th>Username</th>
                <th>Admin Name</th>
                <th>Added by</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php
           global $ConnectingDB;
           $sql = "SELECT * FROM admins ORDER BY id desc";
           $Execute = $ConnectingDB->query($sql);
           $SrNo = 0;
           while($DataRows=$Execute->fetch()) {
               $AdminId = $DataRows["id"];
               $DateTime = $DataRows["datetime"];
               $AdminUserName = $DataRows["username"];
               $AdminName = $DataRows["aname"];
               $AddedBy = $DataRows["addedby"];
               $SrNo++;
        ?>
        <tbody>
            <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                <td><?php echo htmlentities($DateTime); ?></td>
                <td><?php echo htmlentities($AdminUserName); ?></td>
                <td><?php echo htmlentities($AdminName); ?></td>
                <td><?php echo htmlentities($AddedBy); ?></td>
                <td><a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="btn btn-danger">Delete</a></td>
            </tr>
        </tbody>
        <?php } ?>
        </table>
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