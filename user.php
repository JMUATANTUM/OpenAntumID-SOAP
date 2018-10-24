<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenAntumID SOAP Validation Authentication - Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>     
<body>
    <div class="bounce animated login-clean">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <a href="#" class="forgot">
                <img class="justify-content-center align-items-center align-content-center align-self-center visible" src="assets/img/digibytelogin.png" width="50%" height="50%" data-bs-hover-animate="pulse" style="width:105px;">
                <br> 
                <br>Details received from Open AntumID SOAP Service:<br>
                <p align="left">
                <?php 
                if($_SESSION['xml_segment']==''){ header("Location: index.php"); }
                $ReturnResult = $_SESSION['xml_segment'];           
                $xml = simplexml_load_string($ReturnResult);                              
                echo "<br><center>Unique OpenAntumID-key to store: </center><br><br>";
                echo "<center><textarea rows='5' cols='20' readonly>";
                echo $xml->DIGIID;
                echo "</textarea></center>";
                ?>
            
                <?php                 
                // Destroy values after this page loading (for security reasons)
                session_destroy();                
                ?>           
</p> 

 



</a>
<a href="#" class="forgot"><img class="justify-content-center align-items-center align-content-center align-self-center visible" src="assets/img/digibytelogin3.png" data-bs-hover-animate="pulse" style="width:146px;"><br><br><br></a></form>



    </div>
                
  <center> <a class="btn btn-primary" role="button" href="..\">Back to API demo page</a><br><br>Created by Antum 2018</center>  



    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>

</body>
</html>