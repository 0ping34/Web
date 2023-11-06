<?php
include("conexiune.php")
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="Styles/style.css">
</head>
<body>
<div id="form">
    <h1>Login </h1>
    <form name="form"  action="logare.php" method="POST">
        <label style="color: white;">User: </label>
        <input type="text" id="user" name="user"><br><br>
        <label style="color: white;">Password</label>
        <input type="password" id="pass" name="pass"><br><br>
        <div>
            <input type="submit" id="btn" value="Login" name="submit"/>
        </div>
        <div style="text-align:right;">
            <input type="button" id="reset" value="Reset" onClick="window.location.reload();" />
        </div>
    </form>
</div>
<script>
    document.getElementById('reset').onclick = function() {
        location.reload();
    }
</script>
</body>
</html>
