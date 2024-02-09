<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Here :</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
      <div class="container-fluid">
       <header class="modal-header">
        <h4>SIGNIN:</h4>
       </header> 
       
      <form method="POST" action="auth.php">
          <div class="form-group">
            <label>Email | Phone:</label>
            <input type="text" name="uname" id="uname" required class="form-control">
          </div>
          <div class="form-group">
            <label>Password:</label>
            <input type="password" name="pwd1" id="pwd1" required class="form-control">
          </div>
          <div class="form-group">
            <button class="btn btn-sm btn-outline-primary">Login</button>
          </div>
</form>
<?php
                 if(isset($_SESSION['msg'])){
                    if($_SESSION['msg']=='login_error'){
                        echo "<div class='alert alert-danger'>Wrong Cridentials !!</div>";
                    }else if($_SESSION['msg']=='email_phone_error'){
                        echo "<div class='alert alert-warning'>Email or Phone doesnot register With Us !</div>";
                    }

                    unset($_SESSION['msg']);
                 }
       ?>
      </div>
    
</body>
</html>