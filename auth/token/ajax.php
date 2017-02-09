<?php
/**
* snending ajax Response user is valid or not 
* @author Ayaj.Mulani
* @since date
* @paradiso
*/


/**
* Commended because this a insecurity featured
* @author Andres Ag.
* @since April 12 of 2016
* @paradiso
*/

/*
define('AJAX_SCRIPT', true);
require_once('../../config.php');
$action =required_param('action', PARAM_RAW);
if($action==='check_user'){
  GLOBAL $DB;
  $username = required_param('username', PARAM_RAW);
  $confirmed = required_param('confirmed', PARAM_RAW);
  $deleted = required_param('deleted', PARAM_RAW);
  $suspended = required_param('suspend', PARAM_RAW);
  
  $user_name=   $DB->record_exists('user', array('username' => $username,'confirmed' => $confirmed,'deleted' => $deleted,'suspended' => $suspended)) ;
//Ayaj Mulani User Name Balnk condition 
  if($username=='')
  {
     $response['blank'] = 2;
      echo json_encode($response); 
  }
  elseif($user_name==true )
  {
      $response['correct'] = 1;
      echo json_encode($response);
  }
 else {
      $response['wrong'] = 0;
      echo json_encode($response);
  }
  
  
}
*/

/**
* Ajax validation for password
* @author Ayaj.Mulani
* @since March 7 of 2016
* @paradiso
*/


/**
* Commended because this a insecurity featured
* @author Andres Ag.
* @since April 12 of 2016
* @paradiso
*/
/*
if($action==='check_password')
{
    //$username = required_param('username', PARAM_RAW);
    
  GLOBAL $DB;
  $username = required_param('username', PARAM_RAW);
  $confirmed = required_param('confirmed', PARAM_RAW);
  $deleted = required_param('deleted', PARAM_RAW);
  $suspended = required_param('suspend', PARAM_RAW);
  $password = required_param('password', PARAM_RAW);
  
  $user_name=   $DB->record_exists('user', array('username' => $username,'confirmed' => $confirmed,'deleted' => $deleted,'suspended' => $suspended)) ;
    if($username=='')
    {
        $response['username_blank'] = 3;
        echo json_encode($response);
    }
    elseif($user_name!=true)
    {
        $response['username_wrong'] = 7;
        echo json_encode($response); 
    }
    elseif($password=='')
    {
        $response['blank'] = 5;
        echo json_encode($response); 
    }
    elseif (!$user = authenticate_user_login($username, $password, true)) 
    {
        $response['wrong'] = 2;
        echo json_encode($response);
    }
    else 
    {
        $response['correct'] = 1;
        echo json_encode($response);
    }
}
*/
?>
