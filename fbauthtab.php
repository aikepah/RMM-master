<?php

if(isset($_GET['tabs_added']))

{

    $pageId = null;

    foreach($_GET['tabs_added'] as $key => $result)

    {

        $pageId = $key;

    }

    //var_dump($_GET);

    //var_dump($pageId);

    header('Location: http://www.einovie.com/rmm/index.php/social_media/authorize_facebook_tab/'.$pageId);

}





?>