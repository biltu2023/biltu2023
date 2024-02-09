<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container-fluid">
      <?php
          if(isset($_SESSION['msg'])){
              if($_SESSION['msg']=='success')
                {
                    echo "<div class='alert alert-success'>Signup Successfully Done ..</div>";

                } 
                else if($_SESSION['msg']=='error1'){
                    echo "<div class='alert alert-warning'>Something went wrong ... due to duplicate Phone or Email id....</div>";
                }else if($_SESSION['msg']=='error2'){
                    echo "<div class='alert alert-danger'>Password & Confirm PAssword combination doesnot matched..</div>";
                }else if($_SESSION['msg']=='error3'){
                    echo "<div class='alert alert-info'>Only Image files(*.jpg | *.jpeg|*.png|*.gif) is allowed...</div>";
                }

                unset($_SESSION['msg']);
          }
      
      ?> 
      <header class="modal-header">
        <h4>SignUP:</h4>
       </header>
       <div class="form-group">
            <form method="POST" enctype="multipart/form-data" action="submit.php">
            <div class="row">
        
            <div class="col">
                <label>FirstName:</label>
                <input type="text" name="f1" id="f1" required class="form-control">
            </div>
            <div class="col">
                <label>LastName:</label>
                <input type="text" name="l1" id="l1" required class="form-control">
            </div>
        </div>
       </div>
       <div class="form-group">
        <label>Phone:</label>
        <input type="number" name="ph" id="ph" required class="form-control">
       </div>
       <div class="form-group">
        <label>Email:</label>
        <input type="text" name="em" id="em" required class="form-control">
       </div>
       <div class="form-group">
        <label>Upload Profile Pic:</label>
        <input type="file" name="avatar" id="avatar" required class="form-control">

       </div>
       <div class="form-group">
        <label>Password:</label>
        <input type="password" name="pass1" id="pass1" required class="form-control">
       </div>
       <div class="form-group">
        <label>Confirm Password:</label>
        <input type="password" name="pass2" id="pass2" required class="form-control">
       </div>
       <div class="form-group">
        <button class="btn btn-sm btn-outline-primary">Submit</button> |
        <button type="reset" class="btn btn-sm btn-outline-danger">Reset</button>
    </div>
</form>
</div>
</body>
</html>