<?php 
    //Include constants file
    include('../config/constants.php');

    //Check whether the id and image name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the vvalue and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if available
        if($image_name != "")
        {
            //Image is available - so remove it
            $path = "../images/category/".$image_name;
            //Remove the image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //Set the session message
                $_SESSION['remove'] = '<div class="error">Failed to remove category image.</div>';
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the process
                die();
            }
            else
            {

            }
        }

        //Delete data from database
        //SQL Query delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is deleted from database or not
        if($res==true)
        {
            //Set success message and redirect
            $_SESSION['delete'] = '<div class="success">Category deleted successfully.</div>';
            //Redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set fail message and redirect
            $_SESSION['delete'] = '<div class="error">Failed to delete category.</div>';
            //Redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }


    }
    else
    {
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>