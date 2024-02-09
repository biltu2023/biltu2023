<?php
      session_start();
      session_destroy();

      echo "<script>
             alert('you have successfully Logged Out !!');
             window.location.href='login.php';
      </script>";
?>