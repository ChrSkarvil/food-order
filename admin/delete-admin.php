<?php 

    //Include constants.php file
    include('../config/constants.php');

    //1. Get the ID of admin to be deleted
    $id = $_GET['id'];

    //2. Create SQL Query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Check whether the Query executed successfully or not
    if($res==true)
    {
        //Query executed successfully and admin deleted
        //echo "Admin Deleted";
        //Create session variable to display message 
        $_SESSION['delete'] = '<div class="success">Admin Deleted Successfully.</div>';
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //Failed to delete admin
        //echo "Failed To Delete Admin";

        $_SESSION['delete'] = '<div class="error">Failed To Delete Admin.</div>';
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. Redirect to manage admin page with message (sucess/error)

?>