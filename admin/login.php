<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br> <br>

        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br><br>


        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"> <br> <br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter your password"><br> <br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- Login form ends here -->

    </div>

</body>
</html>

<?php 

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Process for login
        //1. Get the data from login form
        // $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // $password = md5($_POST['password']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username ='$username' AND password='$password'";

        //3. Execute the Query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User available and login success
            $_SESSION['login'] = '<div class="success">Login Successful</div>';
            $_SESSION['user'] = $username; //To check whether the user is logged in or not and logout will unset it

            //Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not available and login fail
            $_SESSION['login'] = '<div class="error text-center">Username or Password did not match</div>';
            //Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/login.php');
        }

    }

?>