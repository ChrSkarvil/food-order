<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br/> <br/>

        <?php 
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Display the session message if set
                unset($_SESSION['add']); //Remove session message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name=full_name placeholder="Your Name..." required> 
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name=username placeholder="Your Username..." required>
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name=password placeholder="Your Password..." required>
                    </td>
                </tr>

                <tr>
                    <td colspan=2>
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php 
    //Process the value from form and save it in database
    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button clicked
        // echo "Button Clicked";

        //1. Get the data from form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password'])); //Password encryption with md5

        $sql2 = "SELECT * FROM tbl_admin WHERE (username='$username');";

        $res2=mysqli_query($conn, $sql2);

        if(mysqli_num_rows($res2) > 0) {

            $row = mysqli_fetch_assoc($res2);
            if($username==isset($row['username']))
            {
                $_SESSION['add'] = '<div class="error">Username already exsists</div>';
                header("location:".SITEURL.'admin/add-admin.php');
                $exist = true;
            }  
        }
        else
        {
            //2. SQL Query to  save the data into database
            $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
            ";

            //3. Executing Query and saving data into database
            $res = mysqli_query($conn, $sql) or die(mysqli_error());        



        
        
        

        //4. Check whether the (Query is executed) data is inserted or not and display appropiate message
        if($res==TRUE)
        {
            //Data inserted
            //echo "Data Inserted";
            //Create a session variable to display message
            $_SESSION['add'] = '<div class="success">Admin Added Successfully</div>';
            //Redirect page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else if($res!=true && $exist==false)
        {
            //Failed to insert data
            //echo "Failed To Insert Data";
            //Create a session variable to display message
            $_SESSION['add'] = '<div class="error">Failed To Add Admin</div>';
            //Redirect page to manage admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }

    }
    
?>