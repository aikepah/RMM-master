<?php

// https://www.facebook.com/dialog/oauth?client_id=495711410548329&response_type=code&redirect_uri=https://www.einovie.com/fb2.php

// app token access_token=495711410548329|up16b6mGDQ8hvpJbdNlXkZdn-VQ 



if(isset($_GET)&& isset($_GET['code']) && !isset($_GET['access_token']))

{

    $user_arr = explode("_",$_GET['userid']);

    $url = 'https://graph.facebook.com/oauth/access_token?client_id=495711410548329&redirect_uri=https://www.einovie.com/rmm/fbauth.php?userid='.$_GET['userid'].'&client_secret=c5fabf1c6f825e04b67439eefca8ef65&code='.$_GET['code'];



	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL,            $url);   

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 

//	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

	//curl_setopt($ch, CURLOPT_POST,           true ); 

	//curl_setopt($ch, CURLOPT_POSTFIELDS,    $request); 

	

	$response = curl_exec($ch);

	$err = curl_error($ch);

    //var_dump($response);

    curl_close($ch);

    

    $params = array();

    foreach (explode('&', $response) as $p) 

    {

        $arr = explode('=', $p);

        if(isset($arr[1]))

            $params[$arr[0]] = $arr[1];

    }

}

else

{

    die();

}



if(isset($params['access_token']))

{

    $url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=495711410548329&client_secret=c5fabf1c6f825e04b67439eefca8ef65&fb_exchange_token='.$params['access_token'];



	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL,            $url);   

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 

//	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

	//curl_setopt($ch, CURLOPT_POST,           true ); 

	//curl_setopt($ch, CURLOPT_POSTFIELDS,    $request); 

	

	$response = curl_exec($ch);

	$err = curl_error($ch);

    

    curl_close($ch);

    

    $params = array();

    foreach (explode('&', $response) as $p) 

    {

        $arr = explode('=', $p);

        if(isset($arr[1]))

            $params[$arr[0]] = $arr[1];

    }

    // this access_token is the long-term token

    

    $url = 'https://graph.facebook.com/debug_token?input_token='.$params['access_token'].'&access_token=495711410548329|up16b6mGDQ8hvpJbdNlXkZdn-VQ';



	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL,            $url);   

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 

//	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

	//curl_setopt($ch, CURLOPT_POST,           true ); 

	//curl_setopt($ch, CURLOPT_POSTFIELDS,    $request); 

	

	$response = curl_exec($ch);

	$err = curl_error($ch);

    

    curl_close($ch);

    //var_dump($response);

    $startsAt = strpos($response, '"user_id":') + strlen('"user_id":');

    if($startsAt==-1)

        return;

    $endsAt = strpos($response, ',', $startsAt);

    $userid = substr($response, $startsAt, $endsAt - $startsAt);

    //var_dump($userid);

    

    $url = 'https://graph.facebook.com/'.$userid.'/accounts?access_token='.$params['access_token'];

    $request = 'access_token='.$params['access_token'];

	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL,            $url);   

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 

//	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

	//curl_setopt($ch, CURLOPT_POST,           true ); 

	//curl_setopt($ch, CURLOPT_POSTFIELDS,    $request); 

	

	$response = curl_exec($ch);

	$err = curl_error($ch);

    

    curl_close($ch);

    

    //var_dump($response);

    //var_dump($err);

    

    $response_data = json_decode($response);

    

    //var_dump($response_data);

    //var_dump($_GET);

    $pageToken = null;

    foreach($response_data->data as $page)

    {

        if($page->id==$user_arr[1])

        {

           $pageToken = $page->access_token; 

        }

    }

    

    //var_dump($pageToken);

    

    $url = 'https://www.einovie.com/rmm/index.php/social_media/authorize_facebook';

    $request = 'userid='.$user_arr[0].'&facebook_user_id='.$userid.'&facebook_token='.$params['access_token'].'&facebook_page_token='.$pageToken;

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

    

    header('Location: http://www.einovie.com/rmm/index.php/social_media');

    

}





?>