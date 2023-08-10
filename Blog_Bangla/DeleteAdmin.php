<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
if(isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute) {
        $_SESSION["SuccessMessage"]="Admin deleted successfully! ";
        Redirect_to("Admins.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
        Redirect_to("Admins.php");
    }
}

?>