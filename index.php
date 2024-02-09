<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
    <?php if(isset($_SESSION['USER'])){ ?>    
    <div class="float-right">
                Welcome <?php echo $_SESSION['USER'];?>
                <a href="logout.php">Logout</a>
        </div>
        <?php }
          else {
            echo "<script>
               alert('UnAuthorized Access'); 
               window.location.href='login.php';
            </script>";
          }
        ?>
        <?php
           if(isset($_SESSION['msg'])){
            if($_SESSION['msg']=='update_success'){
                echo "<div class='alert alert-success'>One User Profile successfully Updated...</div>";
            }else if($_SESSION['msg']=='update_error'){
                echo "<div class='alert alert-warning'>Something went Wrong ! Please try again later...</div>";
            }else if($_SESSION['msg']=='delete_success'){
                 echo "<div class='alert alert-info'>One user profile has been removed...</div>";
            }else if($_SESSION['msg']=='delete_error'){
                echo "<div class='alert alert-danger'>Something Went Wrong ! Please Try Again Later...</div>";
            }
            unset($_SESSION['msg']);

           }
        
        ?>
          <h4>PHP -MYSQL Connectivity:</h4>
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Name:</th>
                    <th>Phone:</th>
                    <th>Email:</th>
                    <th>Account Pic:</th>
                    <th>Account Created:</th>
                </tr>
         
    <?php
        //PHP-5 approach 
       // define("HOST","127.0.0.1");
        //define("USERNAME","root");
        //define("PASSWORD","");
        //define("DATABASE","phpdb");
        //PHP-8 const modifier
        
        // const HOST='127.0.0.1';
         //const USERNAME='root';
         //const PASSWORD='';
         //const DATABASE='phpdb';
        //Reading The Database Cridentials from .env file.[Environment file]
          $env = parse_ini_file('.env');
         //Create the connection string.
        $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);

        //Checking the connectivity
        if($con->connect_error)
           die($con->connect_error);
        else {
            //Authorization code starts here ..........
            $SQL="";
            $isAdmin = ($_SESSION['USER-ROLE']=='admin') ? true : false;
            if($isAdmin){
            //echo "Successfully connected";
            $SQL="select * from users";
            }else {
                $SQL="select * from users where user_id=".$_SESSION['USER-ID'];

            }
            //End of Authorization code...

            //execute the SQL at MYSQL
            $resultSet = $con->query($SQL);
            //print_r($resultSet);
            //it will returned us mysqli result object 
            //which we need to fetch and produce the data inside of it to browser.
            /*FAQ State the difference between three functions.
              1)fetch_array() => can process the data by its index pos as well as by its name also
                                 $rows = $resultSet->fetch_array();
                                 echo $rows[1]; echo $rows['email'];
                                 fetch_array() => fetch_assoc()+fetch_row()
              2)fetch_assoc()=> can process the data by its column name as key associatively.
                                $rows = $resultSet->fetch_assoc();
                                echo $rows['name'];-->supported $rows[3];//Error.
              3)fetch_row()  => can process the data by its index pos only.
                                $rows = $resultSet->fetch_row();
                                echo $rows[1];//-->Supported $rows['email']//Error 

            */
            //print '<pre>';
            while($rows = $resultSet->fetch_assoc()){
                $created = date('d-m-y h:i:sA',
                strtotime($rows['created'])
               );

               // print_r($rows);
               //echo json_encode($rows);
               ?>
                    <tr>
                     <td><a href="view.php?id=<?php echo $rows['user_id'];?>">View</a></td>
                     <td><?php echo $rows['name'];?></td>
                     <td><?php echo $rows['phone'];?></td>
                     <td><?php echo $rows['email'];?></td>
                     <td><img src="<?php echo $rows['profile_pic'];?>" height="64px" width="64px" title="<?php echo $rows['name']?>'s Pic"/></td>
                     <td><?php echo $created;?></td>
                </tr>
         
               <?php
            }
        }
        //Closing the Database connection 
        $con->close();

    
    ?>
            </table>
         </div>
    
        </div>
</body>
</html>