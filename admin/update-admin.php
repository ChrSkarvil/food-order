<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br/> <br/>

        <?php 

            if(isset($_SESSION['update'])) //Checking whether the session is set or not
            {
                echo $_SESSION['update']; //Display the session message if set
                unset($_SESSION['update']); //Remove session message
            }

            if(isset($_GET['id']))
            {
                //1. Get the ID of selected admin
                $id=$_GET['id'];

                //2. Create SQL Query to get the details
                $sql1="SELECT * FROM tbl_admin WHERE id=$id";

                //3. Execute the Query
                $res1=mysqli_query($conn, $sql1);

                //Check whether the query is executed or not
                if($res1==true)
                {
                    //Check whether the data is available or not
                    $count = mysqli_num_rows($res1);
                    //Check whether we have admin data or not
                    if ($count==1)
                    {
                        //Get the details
                        //echo "Admin Available";
                        $row=mysqli_fetch_assoc($res1);

                        $full_name = $row['full_name'];
                        $username = $row['username'];
                    }
                    else
                    {
                        //Redirect to manage admin page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
            }
            else
            {
                //Redirect to manage category
                header("location:".SITEURL."admin/manage-admin.php");
            }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // echo "Button Clicked";
        //Get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        $sql2 = "SELECT * FROM tbl_admin WHERE (username='$username');";

        $res2=mysqli_query($conn, $sql2);

        if(mysqli_num_rows($res2) > 0) {

            $row = mysqli_fetch_assoc($res2);
            if($username==isset($row['username']))
            {
                $_SESSION['update'] = '<div class="error">Username already exsists</div>';
                header("location:".SITEURL."admin/update-admin.php?id=$id");
                $exist = true;
            }  
        }
        else
        {


        //Create a SQL Query to update admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username' 
        WHERE id='$id'
        ";

        //Execute the Query
        $res = mysqli_query($conn, $sql);


        //Check whether the query executed successfully or not
        if ($res==true)
        {
            //Query executed and admin updated
            $_SESSION['update'] = '<div class="success">Admin Updated Successfully.</div>';
            //Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else if ($res!=true && $exist == false)
        {
            //Failed to update admin
            $_SESSION['update'] = '<div class="error">Failed To Update Admin.</div>';
            //Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
}

?>

<?php include('partials/footer.php'); ?>