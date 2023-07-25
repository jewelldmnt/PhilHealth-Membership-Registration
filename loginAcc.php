<?php
/**
 * Handles the login form submission.
 * If the username and password are provided, it validates the credentials
 * against the login_credentials table in the database.
 * If the credentials are correct, the user is redirected to the index.php page.
 * Otherwise, an error message is displayed.
*/

session_start();
include("db.php");

$error = ""; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Retrieve user's record from the login_credentials table based on the provided username
        $query = "SELECT * 
                  FROM login_credentials
                  WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            // Verify the provided password with the hashed password stored in the database
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $user_data['password'];
                header("location: index.php");
                die;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Username does not exist!";
        }
    } else {
        $error = "Please enter both username and password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/style/css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Form</title>
</head>    

<body>
    
    <img src="/assets/login/PhilHealth2.png" class="ph">
    
    <div class="LoginBox">
        
        <a href="index.php"><button type="submit" class="back"><i class='bx bx-home'></i>&nbsp;Home</button></a>
            
        <img src="/assets/login/loginIcon.png" class="icon">
            <h1>Login Here</h1>
            <div id="error-message"><?php echo $error; ?></div>
            <form name="loginacc" method="post">
                <p>Username</p>
                <input type="text" name="username" id="myUsername" placeholder="Enter Username" required>
                
                <p>Password</p>
                <input type="password" name="password" id="myPassword" placeholder="Enter Password" required>
                <img src="/assets/login/eye-open.png" id="open-eye" class="eye-icon">
                
                <input type="submit" id="login-btn" class="login" onclick="isLogIn(true)" value="Log In">
            <br><br>
                <a href="createAcc.php"> Not a member yet? Click here to create an account!</a>
                
            </form>

    </div>
    
    <script src="main.js"></script>

</body>
</html>