<?php
    session_start();
   //print_r($_POST);

   function hashPass($pwd){
         $hash = password_hash($pwd,PASSWORD_BCRYPT);
         return $hash;
        }
   function misMatchPass($pw1,$pw2){
       if ($pw1 == $pw2)
          return true;
       else 
          return false;   
   }

   //Database Cridentials 
  // const HOST = "127.0.0.1";
   //const USERNAME='root';
   //const PASSWORD='';
   //const DATABASE='phpdb';
   //Reading The Database Cridentials from .env file.[Environment file]
   $env = parse_ini_file('.env');
        
   $name       =  $_POST['f1'].' '.$_POST['l1'];
   $phone      =  $_POST['ph'];
   $email      =  $_POST['em'];
   $pass1      =  $_POST['pass1'];
   $pass2      =  $_POST['pass2'];


   //Accepting incoming file
   $fileName  = time()."-".$_FILES['avatar']['name'];
   $fileSize  = $_FILES['avatar']['size'];
   $fileType  = $_FILES['avatar']['type'];
   $fileTmp   = $_FILES['avatar']['tmp_name'];
   $fileError = $_FILES['avatar']['error'];
   $destination="./uploads/".$fileName;
   if($fileType=='image/jpg' 
     ||$fileType=='image/jpeg'
     ||$fileType=='image/png' 
     ||$fileType=='image/gif'
   ){
       move_uploaded_file($fileTmp,$destination);
       //file upload successfull
       //Database code will goes here ...
       if(misMatchPass($pass1,$pass2)){
         $hash1 =hashPass($pass1);

        //Database code execute
         $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);
         if($con->connect_error) die($con->connect_error);
         else {
         // echo "Connected to db";
          $SQL="insert into users(name,phone,email,profile_pic,pass1)
                values('$name','$phone','$email','$destination','$hash1');
          ";   
          //Execute the SQL.
          $con->query($SQL);
          /*
          affected_rows is only applicable for INSERT,DELETE,UPDATE statements,
          it returns 1 if the statement gets executed properly , otherwise
          returns zero.
          it is not compitable with select statement as it returns resultSet
          which we need to process either by fetch_array,fetch_Assoc or fetch_rows.
  
          */
          $rows = $con->affected_rows;
          $con->close();
  
          if($rows ==1){
              //echo "Signup successfull";
              $_SESSION['msg']="success";
          }else{
              //echo "Error Something went wrong !";
              $_SESSION['msg']='error1';
          }
      }
         
         
      }else{
        //echo "Password & Confirm Password combination dosnot matched....";
            $_SESSION['msg']='error2';
  
     }
      echo "<script>
            window.location.href='signup.php';
      </script>";
        

   }else {
       $_SESSION['msg']="error3";
       echo "<script>
       window.location.href='signup.php';
 </script>";
   }

   
   
?>