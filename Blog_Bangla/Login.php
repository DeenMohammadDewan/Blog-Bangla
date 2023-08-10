<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
if(isset($_SESSION["UserId"])){
    Redirect_to("Dashboard.php");
}

    if(isset($_POST['Submit'])){
        $UserName = $_POST["Username"];
        $Password = $_POST["Password"];

        if(empty($UserName)||empty($Password)){
            $_SESSION["ErrorMessage"]="All fields must be filled out";
            Redirect_to("Login.php");
        }else{
            //code for checking username and password from database
            $Found_Account = Login_Attempt($UserName,$Password);
            if($Found_Account){ 
                $_SESSION["UserId"] = $Found_Account["id"];
                $_SESSION["UserName"] = $Found_Account["username"];
                $_SESSION["AdminName"] = $Found_Account["aname"];

                $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["AdminName"]."!";
                if(isset($_SESSION["TrackingURL"])){
                    Redirect_to($_SESSION["TrackingURL"]);
                }else{
                Redirect_to("Dashboard.php");
                }
            }else{
            $_SESSION["ErrorMessage"] = "Wrong Username/Password";
            Redirect_to("Login.php");

            }
        }
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
    <title>Login</title>
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
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area Start -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
            <br><br><br>
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome Back!</h4>
                    </div>
                    <div class="card-body bg-dark">
                    
                    <form class="" action="Login.php" method="post">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username: </span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="Username" id="username" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="FieldInfo">Password: </span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="Password" id="password" class="form-control" value="">
                            </div>
                        </div>
                        <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                    </form>
                </div>
            </div>

            </div>

        </div>
    </section>



    <!-- Main Area End -->


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