<?php
     session_start();
     $userId = isset($_GET['id']) ? $_GET['id'] : '';

     //Database Cridentials
     //const HOST="127.0.0.1";
     //const USERNAME="root";
     //const PASSWORD="";
     //const DATABASE="phpdb";
     //Reading The Database Cridentials from .env file.[Environment file]
     $env = parse_ini_file('.env');
        
     if(!empty($userId)){

        //Then only database code will goes here ...

        $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);
        if($con->connect_error) die($con->connect_error);
        else {
            //echo "Connected ";
            $SQL="delete from users where user_id=$userId";
            $con->query($SQL);
            $rows = $con->affected_rows;
            if($rows ==1){
                echo "delete_success";
                $_SESSION['msg']="delete_success";
            }else{
                echo "delete_error";
                $_SESSION['msg']="delete_error";
            }
            $con->close();

            echo "<script>
                  window.location.href='index.php';
            </script>";
        }
     }
8
?>