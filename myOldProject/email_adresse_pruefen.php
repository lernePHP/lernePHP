<?php
// build API request
$APIUrl = 'https://api.email-validator.net/api/verify';
$Params = array('EmailAddress' => $email,
                'APIKey' => 'ev-47a756da7915e6948443742e998f94ba');
$Request = http_build_query($Params, '', '&');
$ctxData = array(
    'method'=>"POST",
    'header'=>"Connection: close\r\n".
    "Content-Type: application/x-www-form-urlencoded\r\n".
    "Content-Length: ".strlen($Request)."\r\n",
    'content'=>$Request);
$ctx = stream_context_create(array('http' => $ctxData));

//Initialisierung
$email_gueltig=0;	
	
// send API request
$result = json_decode(file_get_contents(
    $APIUrl, false, $ctx));

// check API result
if ($result && $result->{'status'} > 0) {
    switch ($result->{'status'}) {
        // valid addresses have a {200, 207, 215} result code
        // result codes 114 and 118 need a retry
        case 200:
        case 207:
        case 215:
                //echo "Address is valid.";
				$email_gueltig=1;
                break;
        case 114:
                // greylisting, wait 5min and retry
                break;
        case 118:
                // api rate limit, wait 5min and retry
                break;
        default:
                //echo "Address is invalid.";
                //echo $result->{'info'};
                //echo $result->{'details'};
				$email_gueltig=0;
                break;
    }
} 
?>



