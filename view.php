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
    <?php 
      // const HOST = '127.0.0.1';
       //const USERNAME='root';
       //const PASSWORD='';
       //const DATABASE='phpdb';
       //Reading The Database Cridentials from .env file.[Environment file]
       $env = parse_ini_file('.env');
        
       $user=[]; //Empty array
       $id = isset($_GET['id']) ?  $_GET['id'] : '';
       if(!empty($id)){ 
       $con = new MYSQLi($env['HOST'],$env['USERNAME'],$env['PASSWORD'],$env['DATABASE']);
       if($con->connect_error)
          die($con->connect_error);
       else {

       // echo "Connected";
          $SQL="select * from users where user_id=".$id;
          $resultSet = $con->query($SQL);
          while($rows = $resultSet->fetch_assoc()){
                $created = date('d-m-y h:i:sA',
                                strtotime($rows['created'])
                               );
                               

                     


              $user =[
                     'USER-ID' =>$rows['user_id'],
                     'NAME'    =>$rows['name'],
                     'PHONE'   =>$rows['phone'],
                     'EMAIL'   =>$rows['email'],
                     'CREATED' =>$created,
                     'PROFILE-PIC'=>$rows['profile_pic']

              ];
             // print_r($user);
          }
    } 
       $con->close();
}else {
      echo "Not authorized to view this Page !";
}
    ?>
      <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Personal Info of <?php echo $user['NAME'];?>:</h4>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data" action="edit.php">
                <p>Name : <input type="text" name="editName" value="<?php echo $user['NAME'];?>"></p>
                <p>Phone : <input type="number" name="editPhone" value="<?php echo $user['PHONE'];?>"> </p>
                <p>Email : <input type="text" name="editEmail" value="<?php echo $user['EMAIL'];?>"></p>
                <p><img src="<?php echo $user['PROFILE-PIC'];?>" alt="No Image" title="<?php echo $user['NAME'];?>'s Pic" height="200px" width="200px">
                   <?php 
                       $_SESSION['old_image_path'] = $user['PROFILE-PIC'];
                       $_SESSION['USER-ID'] = $user['USER-ID'];

                   ?>  
                <input type="file" name="editAvatar">Change Acc Pic.
                <p>
                <p>Account Created at :<?php echo $user['CREATED'];?></p>
                <p>
                  <button class="btn btn-sm btn-outline-info">Update</button> |
                  <a href="delete.php?id=<?php echo $user['USER-ID'];?>"
                    onclick="return confirm('Do You want to Delete This Record?');" 
                  class="btn btn-sm btn-outline-danger">Delete</a>
                </p>
                </form>
                <a href="index.php">Back</a>
            </div>
        </div>
      </div>
</body>
</html>