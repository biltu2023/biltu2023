<?php
  session_start();
  print_r($_POST);

  $uName = $_POST['uname'];
  $passWord = $_POST['pwd1'];

  //Database Cridentials 
  //const HOST ='127.0.0.1';
  //const USERNAME='root';
  //const PASSWORD='';
  //const DATABASE='krishnadb';
  //Reading The Database Cridentials from .env file.[Environment file]
  $env = parse_ini_file('.env');
        
  function page_redirect($loc){
      echo "
         <script>window.location.href='$loc';</script>
      ";
  }

  $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);

  if($con->connect_error) die($con->connect_error);
  else {
    echo "Connected";
    $SQL="select * from users where email='$uName' OR phone='$uName'";
    $resultSet = $con->query($SQL);
    if($rows = $resultSet->fetch_assoc()){
         // print_r($rows);
         $db_hashed_pass = $rows['pass1'];
         $isTrue = password_verify($passWord,$db_hashed_pass);
         if($isTrue){
            //echo "Success";
            $_SESSION['msg']='login_success';
            $_SESSION['USER'] = $rows['name'];
            $_SESSION['USER-ID']=$rows['user_id'];
            $_SESSION['USER-ROLE']=$rows['role'];
            $_SESSION['IP']   = $_SERVER['REMOTE_ADDR'];
            date_default_timezone_set('Asia/Kolkata');
            $_SESSION['login_time'] = date('d-m-y h:i:sA'); 
            page_redirect('index.php');
        }else{
            //echo "Wrong  Crindentials !";
            $_SESSION['msg']="login_error";

         }
        }
    else{
       // echo "Email or Phone doesnot register with US !";
           $_SESSION['msg']="email_phone_error";
    }
    $con->close();

  }
    page_redirect('login.php');

?>