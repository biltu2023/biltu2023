<?php
   session_start();
  // print '<pre>';
   #Incoming text based data 
    // print_r($_POST);
   #Incoming File based Data
     //print_r($_FILES);
     //Database Cridentials
      //const HOST = "127.0.0.1";
      //const USERNAME='root';
      //const PASSWORD='';
      //const DATABASE='phpdb';
      //Reading The Database Cridentials from .env file.[Environment file]
      $env = parse_ini_file('.env');
        


     $editName    = $_POST['editName'];
     $editPhone   = $_POST['editPhone'];
     $editEmail   = $_POST['editEmail'];
     $userId      = $_SESSION['USER-ID'];
     //Global Variable....
     $imagePathToEdit ='';


     if($_FILES['editAvatar']['error']!=0){
        echo "User wont change the Image";
        echo "Old Image Path will be send to Database which is ".$_SESSION['old_image_path'];
        $imagePathToEdit = $_SESSION['old_image_path'];
        unset($_SESSION['old_image_path']);
        
     }else {
         echo "User has changed the Image";
         $fileName = time()."-".$_FILES['editAvatar']['name'];
         $fileTmp  = $_FILES['editAvatar']['tmp_name'];
         $destination = "./uploads/".$fileName;
         move_uploaded_file($fileTmp,$destination);
         echo "File gets uploaded";
         $imagePathToEdit = $destination;


     }

      //Create the Database connection in order to update ....
      $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);

      if($con->connect_error) die($con->connect_error);
      else {
        //echo "Connected successfully !";
        $SQL="update users set
              name='$editName',
              phone='$editPhone',
              email='$editEmail',
              profile_pic='$imagePathToEdit'
              where user_id=$userId
        ";
        $con->query($SQL);
        $rows = $con->affected_rows;
        if($rows ==1){
            echo "success";
            $_SESSION['msg']="update_success";
        }else{
            echo "update_error";
            $_SESSION['msg']="update_error";
        }

        $con->close();
       
        echo "<script>
              window.location.href='index.php';
        </script>";
    }
      

    


?>