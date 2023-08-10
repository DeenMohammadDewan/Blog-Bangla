<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login() ?>
<?php
if(isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target ="Uploads/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDescription"];
    $Admin =$_SESSION["UserName"];

    date_default_timezone_set("Asia/Dhaka");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;

    if(empty($PostTitle)) {
       $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("AddNewPost.php");
    }
    elseif(strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = "Post title should be greater than 5 characters";
        Redirect_to("AddNewPost.php");
    }
    elseif(strlen($PostText)>9999){
        $_SESSION["ErrorMessage"] = "Post Description should be less than 1000 characters";
        Redirect_to("AddNewPost.php");
    }else{
        //Query to insert post in DB when everything is fine
        global  $ConnectingDB;
        $sql = "INSERT INTO posts(datetime, title, category, author, image, post)";
        $sql .="VALUES(:dateTime, :postTitle ,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':postTitle',$PostTitle);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':imageName',$Image);
        $stmt->bindValue(':postDescription',$PostText);
        $Execute=$stmt->execute();
        
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Post with id: ".$ConnectingDB->lastInsertId()." Added Successfully";
            Redirect_to("AddNewPost.php");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to("AddNewPost.php");
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
    <title>My CMS</title>
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
                        <h1> <i class="fas fa-edit" style="color:#27aae1"></i> Add New Post</h1>
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
        <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
            <div class="card bg-secondary text-light mb-3">
                  <div class="card-body bg-dark">
                  <div class="form-group">
                        <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                        <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type tittle here">
                     </div>
                    
                    <div class="form-group">
                        <label for="CategoryTitle"><span class="FieldInfo"> Chose Category</span></label>
                        <select name="Category" id="CategoryTitle" class="form-control">
                            <?php
                            //Fetching All the Categories from Category Table
                            global $ConnectingDB;

                            $sql = "SELECT id,title FROM category";
                            $stmt = $ConnectingDB->query($sql);
                            while($DateRows = $stmt->fetch()) {
                                $Id = $DateRows["id"];
                                $CategoryName = $DateRows["title"];
                            
                            ?>
                            <option><?php echo $CategoryName; ?></option>
                           <?php } ?>
                        </select>
                     </div>

                     <div class="form-group">
                     <div class="custom-file">
                     <input class="custom-file-input" type="File" name = "Image" id = "imageSelect" value="">
                     <label for="imageSelect" class="custom-file-label">Select Image</label>
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="Post"><span class="FieldInfo"> Post</span></label>
                     <textarea class="form-control" id="Post" name="PostDescription" cols="80" rows="8"></textarea>
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