<?php
include("conexiune.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Try to connect using the provided username and password
    try {
        $conn = new mysqli('localhost', $username, $password, 'casa_de_pariuri');
        header("Location: welcome.php");
    } catch(mysqli_sql_exception $e) {
        echo  '<script>
                window.location.href = "index.php";
                alert("Utilizator sau parola incorecta")
               </script>';
    }
}
?>
?>

