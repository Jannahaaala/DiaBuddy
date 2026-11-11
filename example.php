<?php
$SERVER ="localhost";
$username="root";
$password="";
$db="project";


$conn = new mysqli($SERVER,$username,$password,$db);

if($conn->connect_error)
{
    die("Connection failed: ".$conn->connect_error );
}
echo "Connected";

?>