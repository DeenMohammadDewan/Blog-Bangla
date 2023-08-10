<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php Confirm_Login() ?>
<?php
$SarchQueryParameter = $_GET['id'];
        //Fetching Existing content according to our
        global $ConnectingDB;
        $sql = "SELECT * FROM posts WHERE id='$SarchQueryParameter'";
        $stmt = $ConnectingDB -> query($sql);
        while($DataRows = $stmt->fetch()){
            $TitleToBeDeleted =  $DataRows['title'];
            $CategoryToBeDeleted =  $DataRows['category'];
            $ImageToBeDeleted =  $DataRows['image'];
            $PostToBeDeleted =  $DataRows['post'];
        }


// echo $ImageToBeDeleted;


if(isset($_POST["Submit"])) {

        //Query to delete post in DB when everything is fine
        global  $ConnectingDB;

        $sql = "DELETE FROM posts WHERE id='$SarchQueryParameter'";

        $Execute = $ConnectingDB->query($sql);


        if($Execute){
            $Target_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
            unlink($Target_Path_To_DELETE_Image);
            $_SESSION["SuccessMessage"] = "Post deleted Successfully";
            Redirect_to("Posts.php");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to("Posts.php");
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
    <title>Delete Post</title>
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
                        <h1> <i class="fas fa-edit" style="color:#27aae1"></i> Delete Post</h1>
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
        <form class="" action="DeletePost.php?id=<?php echo $SarchQueryParameter; ?>" method="post" enctype="multipart/form-data">
            <div class="card bg-secondary text-light mb-3">
                  <div class="card-body bg-dark">
                  <div class="form-group">
                        <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                        <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type tittle here" value="<?php echo $TitleToBeDeleted; ?>">
                     </div>
                    
                    <div class="form-group">
                        <spna class="FieldInfo">Existing Category: </spna>
                        <?php echo $CategoryToBeDeleted; ?>
                        <br>
                     </div>

                     <div class="form-group">
                     <span class="FieldInfo">Existing Image: </span>
                        <img class="mb-1" src="Uploads/<?php echo $ImageToBeDeleted; ?>"width="170px";height="70px";>
                     </div>
                     <div class="form-group">
                     <label for="Post"><span class="FieldInfo"> Post: </span></label>
                     <textarea disabled class="form-control" id="Post" name="PostDescription" cols="80" rows="8">
                     <?php echo $PostToBeDeleted; ?>
                     </textarea>
                     </div>

                    <div class="row">
                    <div class="col-lg-6 mb-2" >
                        <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard </a>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <button type="submit" name="Submit"class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Delete
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