<?php
$servername = "localhost";
$username = "admin";
$password = "1234";
$db_name = "casa_de_pariuri";
$conn = new mysqli($servername, $username, $password, $db_name, 3306);
if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
echo " ";

?>