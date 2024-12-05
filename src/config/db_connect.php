
<?php 

$server = "localhost";
$username1 = "root";
$password = "";
$database = "eventhive";

$conn = mysqli_connect($server, $username1, $password, $database);
if(!$conn){
    echo "error";
}

?>

