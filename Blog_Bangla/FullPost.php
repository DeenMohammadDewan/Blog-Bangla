<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter =$_GET["id"]; ?>

<?php
if(isset($_POST["Submit"])) {
    $Name = $_POST["CommenterName"];
    $Email =$_POST["CommenterEmail"];
    $Comment =$_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Dhaka");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
// echo $DateTime;

    if(empty($Name)||empty($Email)||empty($Comment)) {

       $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
    elseif(strlen($Comment)>500){
        $_SESSION["ErrorMessage"] = "Comment length should be less than 500 characters";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }else{
        //Query to insert comment in DB when everything is fine
        $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .="VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':name',$Name);
        $stmt->bindValue(':email',$Email);
        $stmt->bindValue(':comment',$Comment);
        $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);

        $Execute = $stmt->execute();

        // var_dump($Execute);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Comment submitted Successfully";
            Redirect_to("FullPost.php?id={$SearchQueryParameter}");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to("FullPost.php?id={$SearchQueryParameter}");
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
    <title>Blog Bangla</title>
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

        <div class="container">
            <div class="row mt-4">
                <!-- Main Area Start -->
                <div class="col-sm-8">
                <h1>Blog Bangla ABC-Cars</h1>
                <h1 class="lead">By Creative XYZ</h1>

                <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>

                <?php
                global $ConnectingDB;
                // SQL query when search button is active
                if(isset($_GET["SearchButton"])){
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM posts
                    WHERE datetime LIKE :search 
                    OR title LIKE :search 
                    OR category LIKE :search 
                    OR post LIKE :search";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindVAlue(':search','%'.$Search.'%');
                    $stmt->execute();
                } 
                // The Default SQL Query
                else{

                $PostIdFromURL = $_GET["id"];
                
                if(!isset($PostIdFromURL)){
                    $_SESSION["ErrorMessage"] = "Bad Request!";
                    Redirect_to("Blog.php");
                }
                $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
                $stmt = $ConnectingDB->query($sql);
                $Result = $stmt->rowcount();
                if($Result!=1){
                    $_SESSION["ErrorMessage"] = "Bad Request!";
                    Redirect_to("Blog.php?page=1");

                }
                }
                while($DataRows=$stmt->fetch()){
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];
                ?>
                <div class="card">
                    <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max: height 450px;" class="img-fluid card-img-top">
                    <div class="card-body">
                        <h4 class="card-title"> <?php echo htmlentities($PostTitle); ?> </h4>
                        <small class="text-muted"> Category: <span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span>Written By <span class="text-dark"><a href="Profile.php?username=<?php echo $Admin; ?>"><?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                        
                        <hr>
                        <p class="card-text"> 
                            <?php 
                            echo nl2br($PostDescription);
                            ?>
                        </p>
                    </div>
                </div>
                <br>
                <?php } ?>

                <!-- Comment part start -->

                <!-- Fetching Existing Comment Start -->
                <span class="FieldInfo">Comments</span>
                <br><br>
                <?php 

                global $ConnectingDB;

                $sql = "SELECT * FROM comments 
                WHERE post_id ='$SearchQueryParameter' AND status='ON'";
                $stmt = $ConnectingDB->query($sql);
                while($DataRows=$stmt->fetch()){
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];
                ?>

                <div>
                        <div class="media CommentBlock" style="background-color: #F6F7F9;">
                        <img src="Images/comment.png" alt="" class="d-block img-fluid align-self-start" width="80px"; height="80px";>
                            <div class="media-body ml-2">
                                <h6 class="lead"><?php echo $CommenterName; ?></h6>
                                <p class="small"><?php echo $CommentDate; ?></p>
                                <p><?php echo $CommentContent; ?></p>
                            </div>
                        </div>
                </div>
                <hr>
                <?php } ?>


                <!-- Fetching Existing Comment End -->

                <div class="">
                    <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="FieldInfo"> Share your thoughts about this post</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-user"></i> </span>

                                    </div>
                                <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>

                                    </div>
                                <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="CommenterThoughts" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="">

                            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>

                            </div>
                        </div>
                    </div>


                </form>



                </div>

                <!-- Comment Part End -->

                </div>
                <!-- Main area End -->
                <!-- Side Area Start -->
                <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="Images/horlicks.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            xgiueyuyfwique09fb7u-0b7vu wppvubitpqywilytybovltylwl8yihfiowyhfqyrioqyhliurulhpinmdsnbafkaghwj
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">
                            Sign UP
                        </h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success btn-block text-center text-white mb-4" type="button" name="button">Join the Forum</button>
                        <button class="btn btn-danger btn-block text-center text-white mb-4" type="button" name="button">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" value="" placeholder="Enter your email">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm text-center text-white" type="button" name="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                        </div>
                        <div class="card-body">
                            <?php
                            global $ConnectingDB;
                            $sql = "SELECT * FROM category ORDER BY id desc";
                            $stmt = $ConnectingDB->query($sql);
                            while($DataRows = $stmt->fetch()){
                                $CategoryId = $DataRows["id"];
                                $CategoryName = $DataRows["title"];
                             ?>
                             <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
                             <?php } ?> 
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                    <h2 class="lead">
                        Recent Posts
                    </h2>
                </div>
                <div class="card-body">
                    <?php 
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                    while($DataRows = $stmt->fetch()){
                        $ID = $DataRows["id"];
                        $Title = $DataRows["title"];
                        $DateTime = $DataRows["datetime"];
                        $Image = $DataRows["image"];
                    ?>
                    <div class="media">
                        <img src="Uploads/<?php echo htmlentities($Image); ?>" alt="" class="d-block img-fluid align-self-start" width="90" height="94">
                        <div class="media-body ml-2">
                            <a href="FullPost.php?id=<?php echo htmlentities($ID); ?>" target="_blank"><h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
                            <p class="small"><?php echo htmlentities($DateTime); ?></p>
                        </div>
                    </div>
                    <hr>
                    <?php } ?>
                </div>
                </div>
                <!-- Side Are End -->
            </div>
        </div>
        </div>

    <!-- HEADER END -->

    <!-- Main Area -->



    <!-- End Main Area -->

<br>
    <!-- FOOTER -->

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center"> Test Project | <span id="year"></span> By A Beginner Level Learner
                        
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