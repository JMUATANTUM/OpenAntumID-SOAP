<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenAntumID SOAP Validation Authentication</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<?php
          // Use additional function(s)
          require_once dirname(__FILE__) . "/AidTools.php";
          // Set entrypoint of the AntumID-DigiID service
          $MyAntumIDSoapService = 'https://www.antumid.be/services-digibyte/api/v1/messageService.wsdl';
          // Create a new instance of the SoapClient (Need to activate SoapClient on PHP server)
          $SoapClientObj = new SoapClient($MyAntumIDSoapService , array('cache_wsdl' => WSDL_CACHE_NONE ));
          // Create message object for using with soapclient object.
          $message = new stdClass();
          $message->AuthenticationRequestType = 'action_create_auth';
          $message->AuthenticationRequestReturnType =  '';
          $message->AuthenticationRequestReturnFields = '';       
          $message->AuthenticationRequestGUID = ''; // ASK YOUR GUID KEY, support@antumid.be
          $message->AuthenticationRequestClientIP = get_client_ip(); // Check for ip later
          $message->AuthenticationValidateTokenID = ''; // Empty for create auth.        
          $ReturnResult = $SoapClientObj->sendMessage($message);
          $json = json_decode($ReturnResult, true);
          $DigiIDQrCodeImage = $json['QRIMAGE'];
          $DigiIDUrl = $json['URLCALLBACK'];
          $DigiIDNonceCode = $json['NONCE'];
          $ClientIP = $json['CLIENTIP'];
?>
<body>
<div class="bounce animated login-clean">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <a href="#" class="forgot">
                <img class="justify-content-center align-items-center align-content-center align-self-center visible" src="assets/img/openantumidsoap.png" width="50%" height="50%" data-bs-hover-animate="pulse" style="width:105px;">
                <br><h8>Use the Digi-ID function of the DigiByte Wallet or Tap on the QR.</h8><br>
            </a>
     
        
        <a href="<?php echo $DigiIDUrl; ?>"> <img class="justify-content-center align-items-center align-content-center align-self-center" src="<?php echo $DigiIDQrCodeImage; ?>" width="250" height="250" data-aos="fade"></a>     
        <p align="center"><small>Please note this QR code is temporarily usable, refresh this page if necessary.</small></p>
       

        
        <a href="#" class="forgot"><img class="justify-content-center align-items-center align-content-center align-self-center visible" src="assets/img/digibytelogin3.png" data-bs-hover-animate="pulse" style="width:146px;"><br><br><br></a>
        
        
        </form>

       
</div>

  <center> <a class="btn btn-primary" role="button" href="..\">Back to API demo page</a><br><br>Created by Antum 2018</center>  
                
<script type="text/javascript">
            // Interval function to check if users has scanned or tapped the QR-Code with the DigiID.
            setInterval(function() {
                var r = new XMLHttpRequest();
                  r.open("POST", "ajax.php", true);
                r.onreadystatechange = function () {
                    if (r.readyState != 4 || r.status != 200) return;
                   if(r.responseText!='false') {   
                       var str = r.responseText;
                       if (str.includes('ERR-200')) { window.location = 'user.php'; }                    
                       if (str.includes('ERR-404')) { window.location = 'unknow.php'; }
                       if (str.includes('ERR-503')) { window.location = 'disabled.php'; }
                       if (str.includes('ERR-505')) { window.location = 'service.php'; }
                   }
                };
                r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');            
                r.send("nonce=<?php echo $DigiIDNonceCode; ?>");
            }, 4000);
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>
</html>