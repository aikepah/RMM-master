<?php

    $url = 'https://graph.facebook.com/567771703313563/feed';
    $request = 'message=testing12345&access_token=CAAHC2M6JbmkBAOK1JZBkit792FpIZBHbiNUybM1hZAuqR5l6LGjDdbVf741dcAmXJPYipp0foWcvZBF0yfuIJ5beQt2JJXzCHxD7l9wGw5Lmj62sZAZA2ChA7GzcWpTomZCBwHOV9gLHc7b2rQ4clWblbACif8uSIUcztaCjLc6eZCp7d7otuw4GeGTShkNsHhoZD';
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,            $url);   
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
//	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_POST,           true ); 
	curl_setopt($ch, CURLOPT_POSTFIELDS,    $request); 
	
	$response = curl_exec($ch);
	$err = curl_error($ch);
    
    curl_close($ch);
    
    echo '<p>post message</p>';
    var_dump($response);
    var_dump($err);



?>
