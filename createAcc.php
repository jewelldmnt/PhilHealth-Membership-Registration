<?php
session_start();

include("db.php");
$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $pkQuery = "SELECT username 
                FROM loginCredentials
                WHERE username = '$username'";
    $pkResult = mysqli_query($connection, $pkQuery);

    $isUsernameExists = false;
    if (mysqli_num_rows($pkResult) > 0) {
        $isUsernameExists = true;
        $error = "Username already exist!";
    } else {
        if ($password == $confirmPassword){
            $query = "INSERT INTO loginCredentials (username, password) VALUES('$username', '$confirmPassword')";
            mysqli_query($connection, $query);
            header("location: loginAcc.php");
            die;
        }
        else {
            $error = "Password do not match!";
        }
    }
    $isUsernameExistsJson = json_encode($isUsernameExists);

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/style/css/create.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Register Form</title>
</head>

<body>
    <img src="/assets/create/PhilHealth2.png" class="ph">
    <div class="LoginBox">
        <a href="index.php"><button type="submit" class="back"><i class='bx bx-home'></i>&nbsp;Home</button></a>
        <img src="/assets/create/loginIcon.png" class="icon">
        <h1>Create Account</h1>
        <div id="error-message"><?php echo $error; ?></div>

        <form name="createacc" method="post">
            <p>Username</p>
            <input type="text" name="username" id="newuser" placeholder="Enter Username" required>
            
            <p>Password</p>
            <input type="password" name="password" id="myPassword" placeholder="Enter Password" required>
            <img src="/assets/create/eye-close.png" id="eyeicon" class="eye-icon">
            
            <p>Confirm Password</p>
            <input type="password" name="confirmPassword" id="conpass" placeholder="Enter Password" required>
            <img src="/assets/create/eye-close.png" id="coneyeicon" class="eye-icon">
            
            <input type="submit" id="createsub" class="login" value="Create Account">
            
            <a href="loginAcc.php"> Already have an account? Log in!</a>
        </form>

    </div>

    <script>var isUsernameExists = <?php echo $isUsernameExistsJson; ?>;</script>
    <script src="main.js"></script>
</body>
</html>