<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
if(isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute) {
        $_SESSION["SuccessMessage"]="Category deleted successfully! ";
        Redirect_to("Categories.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
        Redirect_to("Categories.php");
    }
}

?>