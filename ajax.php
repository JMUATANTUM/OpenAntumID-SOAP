<?php

$NonceTokenToValidate = $_POST['nonce'];
$PrivacyRule = $_POST['privacyrule'];
$address=false;
$ReturnResult = "";
$json = "";
$FieldsToRecieve = "";

if (strlen($NonceTokenToValidate)>0) {
		// Use additional function(s)
        require_once dirname(__FILE__) . "/AidTools.php";
        // Set entrypoint of the AntumID-DigiID service       
        $MyAntumIDSoapService = 'https://www.antumid.be/services-digibyte/api/v1/messageService.wsdl';
        // Create a new instance of the SoapClient (Need to activate SoapClient on PHP server)
        $SoapClientObj = new SoapClient($MyAntumIDSoapService , array('cache_wsdl' => WSDL_CACHE_NONE ));
        // Create message object for using with soapclient object.
        $message = new stdClass();
        $message->AuthenticationRequestType = "action_validate_auth_openantumid|www.yourdomain.com";
        $message->AuthenticationRequestReturnType =  "";
        $message->AuthenticationRequestReturnFields = "";
        $message->AuthenticationRequestGUID = ""; // ASK YOUR GUID KEY, support@antumid.be
        $message->AuthenticationRequestClientIP = get_client_ip();
        $message->AuthenticationValidateTokenID = $NonceTokenToValidate;   
        $ReturnResult = $SoapClientObj->sendMessage($message);   
        $xml = "";      
        $CodeFound = "";
        try 
        {
            $xml = simplexml_load_string($ReturnResult); 
            $CodeFound = $xml->RESPONSE;
            if ($CodeFound=='ERR-200') {
             // Create session so the user could log in
             session_start();
             $_SESSION['xml_segment'] =  $ReturnResult;
            echo $CodeFound;
            } 
            if ($CodeFound=='ERR-404') {  echo "ERR-404"; }
            if ($CodeFound=='ERR-503') {  echo "ERR-503"; }
            if ($CodeFound=='ERR-505') {  echo "ERR-505"; }
          
        } catch (Exception $e) {
            $CodeFound = "ERR-500";
            echo $CodeFound;
            die;
       } finally { }
} 
