<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Message_manager extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// Load MongoDB library instead of native db driver if required
		//$this->config->item('use_mongodb', 'ion_auth') ?
		//$this->load->library('mongo_db') :

		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->helper('language');
	}

	//redirect if needed, otherwise display the user list
	function index()
	{
		//if(!$this->ion_auth->logged_in())
		//{
			//redirect them to the login page
		//	redirect('auth/login', 'refresh');
		//}
		//$data = array();
		echo 'message_manager';
	}
    
    function check_email()
    {
      $imap = imap_open("{pop.secureserver.net:995/novalidate-cert/pop3/ssl}", "contact@rmm-mail.com", "rmm123Contact");
      if(!$imap)
      {
        echo 'error opening connection';
        return;
      }  
      $count = imap_num_msg($imap);
      if(!$count)
        return;
      for($i = 1; $i <= $count; $i++)
      {
        $emailHeader = imap_headerinfo($imap,$i);
        $emailBody = imap_body($imap,$i);
        $replyData = array(
          'email_address' => $emailHeader->toaddress,
          'email_subject' => $emailHeader->subject,
          'email_header' => json_encode($emailHeader),
          'email_body' => $emailBody,
        );
        if($emailHeader->subject == 'Delivery Status Notification (Failure)')
        {
          $startPos = strpos($emailBody,'following recipients:');
          if($startPos === false)
          {
              echo "couldn't find email address - ".$i;
          }
          else
          {
            $startPos += 21;
            $endPos = strpos($emailBody,'---',$startPos);
            $emailAddress = trim(substr($emailBody,$startPos,$endPos-$startPos));
            if(strlen($emailAddress))
            {
                $nsQuery = $this->db->get_where('nosend_emails',array('email_address'=>$emailAddress));
                if(!$nsQuery->num_rows())
                {
                  $dbData = array(
                      'email_address'=>$emailAddress,
                      'description'=>'undeliverable email - 1',
                  );
                  $this->db->insert('nosend_emails',$dbData);
                }  
                $dbData = array(
                    'email_address'=>null,
                );
                $replyData['unsubscribed'] = 1;
                $this->db->update('contacts',$dbData,array('email_address'=>$emailAddress));
            }
          } 
        }
        else if(substr($emailHeader->subject,0,14) == 'Undeliverable:')
        {
          $startPos = strpos($emailBody,'recipients or groups:');
          if($startPos === false)
          {
              echo "couldn't find email address - ".$i;
          }
          else
          {
            $startPos += 21;
            $endPos = strpos($emailBody,'The e-mail address',$startPos);
            $emailAddress = trim(substr($emailBody,$startPos,$endPos-$startPos));
            if(strlen($emailAddress))
            {
                $nsQuery = $this->db->get_where('nosend_emails',array('email_address'=>$emailAddress));
                if(!$nsQuery->num_rows())
                {
                  $dbData = array(
                      'email_address'=>$emailAddress,
                      'description'=>'undeliverable email - 2',
                  );
                  $this->db->insert('nosend_emails',$dbData);
                }  
                $dbData = array(
                    'email_address'=>null,
                );
                $this->db->update('contacts',$dbData,array('email_address'=>$emailAddress));
                $replyData['unsubscribed'] = 1;
            }
          } 
        }
        else if(substr($emailHeader->subject,0,21) == 'Email Feedback Report')
        {
          $startPos = strpos($emailBody,'unsubscribe_email');
          if($startPos === false)
          {
              echo "couldn't find email address - ".$i;
          }
          else
          {
            $startPos += 18;
            $endPos = strpos($emailBody,'/',$startPos);
            $contactId = trim(substr($emailBody,$startPos,$endPos-$startPos));
            $contactId = preg_replace("/[^0-9]/", "", $contactId);
            if(strlen($contactId))
            {
                $contactQuery = $this->db->get_where('contacts',array('contact_id'=>$contactId));
                if(!$contactQuery->num_rows())
                {
                  continue;
                }
                $emailAddress = $contactQuery->row()->email_address;
                if(!$emailAddress)
                {
                  continue;
                }
                $nsQuery = $this->db->get_where('nosend_emails',array('email_address'=>$emailAddress));
                if(!$nsQuery->num_rows())
                {
                  $dbData = array(
                      'email_address'=>$emailAddress,
                      'description'=>'spam complaint',
                  );
                  $this->db->insert('nosend_emails',$dbData);
                }  
                $dbData = array(
                    'email_address'=>null,
                );
                $replyData['unsubscribed'] = 1;
                $this->db->update('contacts',$dbData,array('email_address'=>$emailAddress));
            }
          }
        }
        else
        {
          //TODO: save emails here to be displayed to customer
        }
        $this->db->insert('email_replies',$replyData);
        imap_delete($imap,$i);
      }
      imap_expunge($imap);  
      imap_close($imap);
    }
    
    function test_email()
    {
      require_once(FCPATH.'application/third_party/ses.php');
      $ses = new SimpleEmailService('AKIAJJDGPOVWJXW4FEHA', 'srEHdt/kEh3ApNRhKoCLyaV7EOC6gBkL0L8wNrDO');
      $m = new SimpleEmailServiceMessage();
      $m->addTo('troy@restaurantmoneymachine.com');
      $m->addTo('tmmrtx@gmail.com');
      $m->setFrom('RMM <troy@restaurantmoneymachine.com>');
      $m->setSubject('SES Test Email3');
      $m->setMessageFromString('Test message');
      $ses->sendEmail($m);
      
      echo 'done2';
    
    }
    
    function assign_twilio_numbers($userid)
    {
        if(!$userid)
            return;
        $countQuery = $this->db->query("select utp.twilio_number, count(distinct c.mobile_phone) as mobile_count from user_text_phones as utp left join contacts as c on (utp.twilio_number = c.twilio_number and utp.main_user_id = c.main_user_id) where utp.main_user_id = ".$userid." group by utp.twilio_number order by mobile_count asc");
        if(!$countQuery->num_rows())
        {
          return; //there's no numbers assigned, so can't send text
        }
        $countList = $countQuery->result_array();
        $assignQuery = $this->db->query("select * from contacts where main_user_id=".$userid." and (twilio_number is null or twilio_number = '') and mobile_phone is not null and mobile_phone != '' group by mobile_phone");
        if($assignQuery->num_rows())
        {
          $assign_list = $assignQuery->result();
          foreach($assign_list as $contact)
          {
              $iLoc = -1;
              for($i=0; $i<count($countList);$i++)
              {
                  if($iLoc == -1 || $countList[$i]['mobile_count'] < $countList[$iLoc]['mobile_count'])
                  {
                      $iLoc = $i;
                  }
              }
              $dbData = array(
                  'twilio_number' => $countList[$iLoc]['twilio_number'],
              );
              $this->db->update('contacts',$dbData,array('main_user_id'=>$userid,'mobile_phone'=>$contact->mobile_phone));
              $countList[$iLoc]['mobile_count'] = $countList[$iLoc]['mobile_count'] + 1;
          }
        }
    
    }
    
	function send_text_message($userId,$contactId,$toNumber,$fromNumber,$message)
	{
        require_once(FCPATH.'application/third_party/twilio-php/Services/Twilio.php');

        $account_sid = 'AC054fe6e551a13f868ec822d4288d854f'; 
        $auth_token = '7e67b139e61a6e26a5b985db95cae5e5'; 
        $client = new Services_Twilio($account_sid, $auth_token); 

		//$from = '8014712698';
		//$toNumber = '8013581158';
        
        if(!strlen($toNumber))
            return;
        if(!strlen($fromNumber))
            return;
        $query = $this->db->query("select * from users where user_id=".$userId);
        $user = $query->row();
		if(!isset($user))
        {
            return;
        }
        $contactQuery = $this->db->query("select * from contacts where contact_id=".$contactId);
        $contact = $contactQuery->row();
        if(!isset($contact))
        {
            return;
        }
        if(!$contact->text_message_status)
        {
            $firstMessage = "Thank you %firstname% for subscribing to text promotions from %textname%, to stop receiving them, reply 'stop'. Std msg and data rates may apply";
    		$firstMessage = str_replace('%firstname%',$contact->first_name,$firstMessage);
    		$firstMessage = str_replace('%textname%',$user->text_name,$firstMessage);
    		$client->account->messages->create(array( 
            	'To' => $toNumber, 
	            'From' => $fromNumber, 
	            'Body' => $firstMessage,   
            ));
            
            $dbData = array(
                text_message_status => 1,
            );
            $this->db->update('contacts',$dbData,array('contact_id'=>$contact->contact_id));
        }
        
  		$message = str_replace('%firstname%',$contact->first_name,$message);
  		$message = str_replace('%lastname%',$contact->last_name,$message);
        
  		$client->account->messages->create(array( 
          	'To' => $toNumber, 
            'From' => $fromNumber, 
            'Body' => $message,   
          ));

		/*
        if($response->IsError)
        {
            $this->db->insert('event_log',array(
                'event_description' => 'Text message send error: from: '.$fromNumber.' to: ' .$toNumber .' - '. $response->ErrorMessage,
            ));
            return -1;
        }
        */
        return 1;
		
	}
    
    function rec_text_message($data=null)
    {
        if(!isset($_POST) || empty($_POST))
		{
			return;
		}
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $textData = array(
            'from_phone' => $_POST['From'],
            'to_phone' => $_POST['To'],
            'text_message_body' => $_POST['Body'],
            'twilio_message_id' => $_POST['MessageSid'],
        );
        $this->db->insert('text_message_log',$textData);
        if(isset($_POST['Body']) && (stripos($_POST['Body'],'stop') !== false || stripos($_POST['Body'],'unsubscribe') !== false || stripos($_POST['Body'],'off') !== false || stripos($_POST['Body'],'remove') !== false || stripos($_POST['Body'],'quit') !== false || stripos($_POST['Body'],'no more') !== false || stripos($_POST['Body'],'do not') !== false))
        {
            $to_phone = substr($_POST['To'],-10);
            $from_phone = substr($_POST['From'],-10);
            //$query = $this->db->get_where('users',array('twilio_number'=>$to_phone));
            //if(!$query->num_rows())
            //{
            //    return;
            //}
            //$user = $query->row();
// TODO: need to change this back once we get the number thing straightened out
//            $query = $this->db->get_where('contacts',array('main_user_id'=>$user->main_user_id,'mobile_phone'=>$from_phone));
            $query = $this->db->get_where('contacts',array('mobile_phone'=>$from_phone));
            if(!$query->num_rows())
            {
                return;
            }
            $this->db->insert('event_log',array(
                'event_description' => 'Recipient unsubscribed to text messages: '.$from_phone,
                'event_data' => json_encode($textData),
            ));
            foreach($query->result() as $contact)
            {
              $this->db->update('contacts',array('mobile_phone'=>null),array('contact_id'=>$contact->contact_id,'mobile_phone'=>$from_phone));
            }
        }
    }
    
    function send_email_message($userId,$contactId,$toEmail,$subject,$message,$messageBody)
    {
        $query = $this->db->query("select * from users where user_id=".$userId);
        $user = $query->row();
		if(!isset($user))
        {
            return;
        }
        $contactQuery = $this->db->query("select * from contacts where contact_id=".$contactId);
        $contact = $contactQuery->row();
        $nsQuery = $this->db->get_where('nosend_emails',array('email_address'=>$toEmail));
        if($nsQuery->num_rows())
        {
            // it's on the no send list, don't send the email and remove it from contacts list so we don't keep trying to send it
              $dbData = array(
                  'email_address'=>null,
              );
              //$this->db->update('contacts',$dbData,array('email_address'=>$toEmail));
            return;
        }
// temporary cut and paste to make this go through rmgmail
	  $first_emails = array(
	      array($contact->first_name,$contact->last_name,$contact->email_address,$contact->contact_id,$contact->mobile_phone),
	  );
	  $postUrl = 'https://www.rmgmail.com/sendrmmemail.php';
	  $postFields = array(
		'contacts' => urlencode(json_encode($first_emails)),
		'emailsubject' => urlencode($subject),
		'emailbody' => urlencode($message),
		'emailfrom' => urlencode($user->first_from_email),
		'company' => urlencode($user->company),
	    'email_enable_text_invitation' => urlencode($user->email_enable_text_invitation),
		'key' => '245rrmkido',
	  );
	  $fields_string = '';
	  //url-ify the data for the POST
	  foreach($postFields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	  rtrim($fields_string, '&');
	  
	  //open connection
	  $ch = curl_init();
	  
	  //set the url, number of POST vars, POST data
	  curl_setopt($ch,CURLOPT_URL, $postUrl);
	  curl_setopt($ch,CURLOPT_POST, count($postFields));
	  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	  
	  //execute post
	  $result = curl_exec($ch);
	  $error = curl_error($ch);
	  //var_dump($result);
	  //var_dump($error);
	  //close connection
	  curl_close($ch);
	  
	  return;

		if($user->email_enable_text_invitation && !$contact->mobile_phone)
        {
            $message = str_replace('%textinvitation%','<div>Did you know we have more special promotions available via text messages? <a id="subscribetexts" href="http://www.rmm-mail.com/rmm/index.php/contacts/text_signup/%supportid%" style="color: #0000FF">Click here to subscribe.</a></div>',$message);
        }
        else
        {
            $message = str_replace('%textinvitation%','',$message);
        }

		$message = str_replace('%supportid%',$contactId.'/'.urlencode($toEmail),$message);
		$message = str_replace('%email%',$toEmail,$message);
		if(isset($contact))
        {
    		$message = str_replace('%firstname%',$contact->first_name,$message);
    		$message = str_replace('%lastname%',$contact->last_name,$message);
        }
        //$headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //$message = '<html><body>'.$message.'</body></html>';
        //var_dump($toEmail);
        //var_dump($subject);
        //var_dump($message);
        //var_dump($headers);
        //mail($toEmail,$subject,$message);
        //mail($toEmail,$subject,$message,$headers);



        require_once(FCPATH.'application/third_party/ses.php');
        
        $ses = new SimpleEmailService('AKIAJJDGPOVWJXW4FEHA', 'srEHdt/kEh3ApNRhKoCLyaV7EOC6gBkL0L8wNrDO');
        
        $m = new SimpleEmailServiceMessage();
        $m->addTo($toEmail);
        $m->setFrom($user->company.' <'.$user->from_email.'>');
        $m->setSubject($subject);
        $m->setMessageFromString($messageBody,$message);
        $ses->sendEmail($m);
        


/*
        $this->load->library('email');
        
        $this->email->from('your@example.com', 'Your Name');
        $this->email->to('someone@example.com'); 
        $this->email->cc('another@another-example.com'); 
        $this->email->bcc('them@their-example.com'); 
        
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');	
        
        $this->email->send();
*/
    }

	function unsubscribe_email($contactId=null,$emailAddress=null)
	{
		if(!$contactId || !$emailAddress)
			return;
        $data = array();
        $data['message'] = "";
        $emailAddress = urldecode($emailAddress);
        $query = $this->db->get_where('contacts',array('contact_id'=>$contactId,'email_address'=>$emailAddress));
        if(!$query->num_rows())
        {
    		$data['message'] = 'You have already unsubscribed from this email list.';
            $this->load->view('email_unsubscribe', $data);
            return;
        }
        if($this->input->get('confirm'))
        {
            $contact = $query->row();
            $eData = array(
                'contact_id' => $contactId,
                'email_address' => $emailAddress,
            );
            $this->db->insert('event_log',array(
                'event_description' => 'Recipient unsubscribed to email list: '.$emailAddress,
                'event_data' => json_encode($eData),
            ));
            $this->db->update('contacts',array('email_address'=>null),array('main_user_id'=>$contact->main_user_id,'email_address'=>$emailAddress));
            $dbData = array(
                'email_address'=>$emailAddress,
                'description'=>'unsubscribed',
                'main_user_id'=>$contact->main_user_id,
            );
            $this->db->insert('nosend_emails',$dbData);
       		$data['message'] = 'You have been successfully removed from the email list.';
        }
        else
        {
            $data['message'] = '<div>Are you sure you wish to unsubscribe to this email list?</div> <div><a href="'.current_url().'?confirm=1">Yes, please unsubscribe me</a></div>';
            
        }
   		$this->load->view('email_unsubscribe', $data);

	}
    
    function post_twitter($userId, $message, $image = null) {
        $query = $this->db->query("select * from users where user_id=" . $userId);
        $user = $query->row();
        if (!isset($user) || !isset($user->twitter_token) || !isset($user->twitter_secret)) {
            return;
        }
        $tmhOAuth = new tmhOAuth(array(
            'consumer_key' => 'skN6wo6LuAQUXWhk3liw',
            'consumer_secret' => 'uuxCmdY0omdMsReJB3jlqkAEROcOzeUZestdJtVDwM',
            'token' => $user->twitter_token,
            'secret' => $user->twitter_secret,
        ));
        if ($image !== null && $image !== '') {

            $basePath = FCPATH . 'udata/';
            $image = $basePath . $image;
            $response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update_with_media'), array(
                'status' => $message,
                'media[]' => "@{$image}"
            ), true, true);
        } else {
            $response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
                'status' => $message
            ));
        }
    }


    function post_facebook($userId, $message, $image = null) {
        $query = $this->db->query("select * from users where user_id=" . $userId);
        $user = $query->row();
        if (!isset($user) || !isset($user->facebook_page_id) || !isset($user->facebook_page_token)) {
            return;
        }
        if ($image !== null && $image !== '') {
            $basePath = base_url() . 'udata/';
            $url = 'https://graph.facebook.com/me/photos';
            $request = 'url=' . $basePath . $image . '&message=' . $message . '&access_token=' . $user->facebook_page_token;
        } else {
            $url = 'https://graph.facebook.com/' . $user->facebook_page_id . '/feed';
            $request = 'message=' . $message . '&access_token=' . $user->facebook_page_token;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        //	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        var_dump($response);
        var_dump($err);
    }
    
    function check_messages()
    {
        $query = $this->db->query("select m.*, u.user_timezone from messages as m left join users as u on (m.main_user_id = u.user_id) where m.message_status in (0,1) and scheduled_date >= '".date('Y-m-d')." 00:00:00' and scheduled_date <= '".date('Y-m-d')." 23:59:59' and (sent_date is null or sent_date < '".date('Y-m-d')." 00:00:00')"); 
	    $serverZone = date_default_timezone_get();
        foreach($query->result() as $row)
        {
	        if($row->user_timezone)
	        {
	            date_default_timezone_set($row->user_timezone);
	        }
			else // they should never not have a timezone set, but if they don't lets revert back to the server timezone
			{
	            date_default_timezone_set($serverZone);
			}
	        $dateDiff = strtotime($row->scheduled_date)-time(); //number of seconds that it's currently off from the scheduled datetime
			if($dateDiff < 1800 && $dateDiff >= -1800) // 60sec * 30min = 1800, if it's within a half hour then fire it off, just to give us a buffer
			{
				$this->send_message($row->message_id);
			}
        }
    }
    
	function check_birthday_anniversary()
	{
		//birthday that is either 2 days away or 2 weeks
		$query = $this->db->query("select c.*, u.auto_birthday_template, u.auto_birthday_subject, u.auto_birthday_body from users as u left join contacts as c on (u.main_user_id = c.main_user_id) where u.auto_enable_birthday = 1 and u.auto_birthday_template is not null and u.auto_birthday_subject is not null and u.auto_birthday_body is not null and c.birthday is not null and ((month(c.birthday) = month(adddate(curdate(), interval 2 day)) and day(c.birthday) = day(adddate(curdate(), interval 2 day))) or (month(c.birthday) = month(adddate(curdate(), interval 14 day)) and day(c.birthday) = day(adddate(curdate(), interval 14 day))) ) order by c.main_user_id");
		if($query->num_rows())
		{
	        $userId = null;
			$emailBody = null;
			$emailText = null;
	        foreach($query->result() as $contact)
	        {
				//send birthday email
				if($contact->main_user_id != $userId)
				{
					$userId = $contact->main_user_id;
					$emailBody = $this->format_email_body($contact->auto_birthday_body,$contact->main_user_id,$contact->auto_birthday_template);
					if(preg_match_all('/(?<=%expireDateAfter)[0-9]+(?=%)/i',$emailBody,$matches))
					{
						foreach($matches[0] as $match)
						{
							$newDate = date_create($contact->birthday);
							$newDate = date_add($newDate,date_interval_create_from_date_string($match.' days'));
							$newDate = date_date_set($newDate,date_format(date_create(),'Y'),date_format($newDate,'m'),date_format($newDate,'d'));
							$dateStr = date_format($newDate,'l F j, Y');
							$emailBody = str_ireplace('%expireDateAfter'.$match.'%',$dateStr,$emailBody);
						}			
					}
					$emailText = strip_tags($contact->auto_birthday_body);
				}	            	
                $this->db->insert('message_log',array('contact_id'=>$contact->contact_id,'email_address'=>$contact->email_address,'message_status'=>5,'description'=>'Birthday'));
				$this->send_email_message($contact->main_user_id,$contact->contact_id,$contact->email_address,$contact->auto_birthday_subject,$emailBody,$emailText);
	        }
		}
		//anniversary that is either 2 days away or 2 weeks
		$query = $this->db->query("select c.*, u.auto_anniversary_template, u.auto_anniversary_subject, u.auto_anniversary_body from users as u left join contacts as c on (u.main_user_id = c.main_user_id) where u.auto_enable_anniversary = 1 and u.auto_anniversary_template is not null and u.auto_anniversary_subject is not null and u.auto_anniversary_body is not null and c.anniversary is not null and ((month(c.anniversary) = month(adddate(curdate(), interval 2 day)) and day(c.anniversary) = day(adddate(curdate(), interval 2 day))) or (month(c.anniversary) = month(adddate(curdate(), interval 14 day)) and day(c.anniversary) = day(adddate(curdate(), interval 14 day))) ) order by c.main_user_id");
		if($query->num_rows())
		{
	        $userId = null;
			$emailBody = null;
			$emailText = null;
	        foreach($query->result() as $contact)
	        {
				//send anniversary email
				if($contact->main_user_id != $userId)
				{
					$userId = $contact->main_user_id;
					$emailBody = $this->format_email_body($contact->auto_anniversary_body,$contact->main_user_id,$contact->auto_anniversary_template);
					if(preg_match_all('/(?<=%expireDateAfter)[0-9]+(?=%)/i',$emailBody,$matches))
					{
						foreach($matches[0] as $match)
						{
							$newDate = date_create($contact->anniversary);
							$newDate = date_add($newDate,date_interval_create_from_date_string($match.' days'));
							$newDate = date_date_set($newDate,date_format(date_create(),'Y'),date_format($newDate,'m'),date_format($newDate,'d'));
							$dateStr = date_format($newDate,'l F j, Y');
							$emailBody = str_ireplace('%expireDateAfter'.$match.'%',$dateStr,$emailBody);
						}			
					}
					$emailText = strip_tags($contact->auto_anniversary_body);
				}	            	
                $this->db->insert('message_log',array('contact_id'=>$contact->contact_id,'email_address'=>$contact->email_address,'message_status'=>5,'description'=>'Anniversary'));
				$this->send_email_message($contact->main_user_id,$contact->contact_id,$contact->email_address,$contact->auto_anniversary_subject,$emailBody,$emailText);
	        }
		}
	}
	
	function format_email_body($emailMessage = null,$userId = null,$templateId = null)
	{
        if(!$userId)
			return;
        $userQuery = $this->db->query("select * from users where user_id=".$userId);
        $user = $userQuery->row();
        
	    if($templateId)
	    {
    		$queryTemplate = $this->db->query("select * from email_templates as et where et.email_template_id = ".$templateId);
    		$template = $queryTemplate->row();
	        $emailBody = $template->email_body;
	    }
	    else
	    {
	        $emailBody = '<html><body>%secondbody%</body></html>';
	    }
		if($emailMessage)
		{
	        $emailBody = str_replace('%secondbody%',$emailMessage,$emailBody);
		}
		else 
		{
			$emailBody = str_replace('%secondbody%','',$emailBody);
		}
		if($user->email_enable_contact_update)
	    {
	        $emailBody = str_replace('%updatecontact%','<br>To update your contact information, <a id="updatecontact" href="http://www.rmm-mail.com/rmm/index.php/contacts/contact_update/%supportid%" style="color: #0000FF">click here.</a>',$emailBody);
	    }
	    else
	    {
	        $emailBody = str_replace('%updatecontact%','',$emailBody);
	    }
		
		$emailBody = str_replace('%fourthbody%','<span style="font-weight: bold;"></span><br><span style="font-weight: normal;">'.$user->hours_text.'</span>',$emailBody);
		$emailBody = str_replace('image.einovie.com','image.rmm-mail.com',$emailBody); // this is to avoid cross domain headaches when editing the template in einovie.com domain
		if(preg_match_all('/(?<=%expireDate)[0-9]+(?=%)/i',$emailBody,$matches))
		{
			foreach($matches[0] as $match)
			{
				var_dump($match);
				$dateStr = date('l F j, Y',strtotime('+'.$match.' day'));
				var_dump($dateStr);
				$emailBody = str_ireplace('%expireDate'.$match.'%',$dateStr,$emailBody);
			}			
		}
		return $emailBody;
	}
    
    function ajax_send_message($messageId = null)
    {
        if(!$messageId)
        {
            echo 'ERROR: unknown message id';
            return;
        }
		if(!$this->ion_auth->logged_in())
		{
            echo 'ERROR: you must login to send a message';
			return;
		}
		$user = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$query = $this->db->get_where('messages',array('message_id'=>$messageId,'main_user_id'=>$user->main_user_id));
        if($query->num_rows() <= 0)
        {
            echo 'ERROR: message not found.';
            return;
        }
        $message = $query->row();
        if(!$message->scheduled_date)
        {
            ignore_user_abort(true);
            // for some reason ignore_user_abort wasn't working until we queried it's status
            $result = ignore_user_abort();
            set_time_limit(86400);
            $this->send_message($messageId);
        }
    }

    function send_message($messageId = null)
    {
		if(!$messageId)
		{
			echo 'ERROR: no message_id entered.';
			return;
		}
        set_time_limit(86400);
		$query = $this->db->query("select * from messages where message_id=".$messageId);
		//$data['message_data'] = $query->result_array();
        if($query->num_rows() <= 0)
        {
            echo 'ERROR: message not found.';
            return;
        }
        $message = $query->row();
        $userQuery = $this->db->query("select * from users where user_id=".$message->main_user_id);
        $user = $userQuery->row();
        $contactGroup = '';
        if($message->contact_group_id)
        {
            $cgQuery = $this->db->get_where('contact_groups',array('contact_group_id'=>$message->contact_group_id));
            if($cgQuery->num_rows())
            {
                $contactGroup = $cgQuery->row()->group_query;
            }
        }
        if($message->message_type_id==1) //facebook / twitter post
        {
            // post to facebook and twitter
            $this->post_twitter($message->main_user_id,$message->twitter_post,$message->image);
            $this->post_facebook($message->main_user_id,$message->facebook_post,$message->image);
            $newStatus = 5;
            $this->db->update('messages',array('sent_date'=>date('Y-m-d'),'message_status'=>$newStatus),array('message_id'=>$messageId));
            echo 'Message Sent';
            return;
        }
        $emailBody = null;
        if($message->message_type_id==3) // email
        {
       		if(isset($message->email_body_html))
			{
				$emailBody = $message->email_body_html;
			}
			else
			{
				$emailBody = "";
			}
			$emailBody = $this->format_email_body($emailBody,$message->main_user_id,$message->email_template_id);    		

            $sendTimeframeStatus = 0;
            if($message->send_timeframe)
            {
       		    $query2a = $this->db->query("select count(distinct email_address) as num_contacts from contacts as c where c.main_user_id=".$message->main_user_id . $contactGroup);
                $totalContacts = $query2a->row()->num_contacts;
                $numContacts = round($totalContacts / $message->send_timeframe);
                if($numContacts < 1)
                    $numContacts = 1;
                $sendTimeframeStatus = $message->send_timeframe_status+1;
                if($sendTimeframeStatus == $message->send_timeframe)
                {
                    $newStatus = 5;
                    $limitText = "";
                }
                else
                {
                    $newStatus = 1;
                    $limitText = "limit ".$numContacts;
                }
       		   $query2 = $this->db->query("select c.* from contacts as c left join message_log as ml on (c.email_address = ml.email_address and ml.message_id=".$messageId.") where c.main_user_id=".$message->main_user_id . $contactGroup." and ml.sent_date is null group by c.email_address ".$limitText);
               $contact_list = $query2->result();
            }
            else
            {
               $newStatus = 5;
       		   $query2 = $this->db->query("select * from contacts as c where c.main_user_id=".$message->main_user_id . $contactGroup." group by email_address");
               $contact_list = $query2->result();
            }
            $first_emails = array();
            foreach($contact_list as $contact)
            {
                if(isset($contact->email_address) && strlen($contact->email_address))
                {
                    $this->db->insert('message_log',array('message_id'=>$message->message_id,'contact_id'=>$contact->contact_id,'email_address'=>$contact->email_address,'message_status'=>5));
                    if(!$contact->email_status)
                    {
                        $first_emails[] = array($contact->first_name,$contact->last_name,$contact->email_address,$contact->contact_id,$contact->mobile_phone);
                        $dbData = array(
                            'email_status' => 1, 
                        );
                        $this->db->update('contacts',$dbData,array('contact_id'=>$contact->contact_id));
                    }
                    else
                    {
                        $first_emails[] = array($contact->first_name,$contact->last_name,$contact->email_address,$contact->contact_id,$contact->mobile_phone);
                        //$this->send_email_message($message->main_user_id,$contact->contact_id,$contact->email_address,$message->email_subject,$emailBody,strip_tags($message->email_body_html));
                    }
                }
                // send them 50 at a time
                if(count($first_emails)>50)
                {
                  $postUrl = 'https://www.rmgmail.com/sendrmmemail.php';
                  $postFields = array(
            			'contacts' => urlencode(json_encode($first_emails)),
            			'emailsubject' => urlencode($message->email_subject),
            			'emailbody' => urlencode($emailBody),
            			'emailfrom' => urlencode($user->first_from_email),
            			'company' => urlencode($user->company),
                        'email_enable_text_invitation' => urlencode($user->email_enable_text_invitation),
            			'key' => '245rrmkido',
    			  );
                  $fields_string = '';
                  //url-ify the data for the POST
                  foreach($postFields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                  rtrim($fields_string, '&');
                  
                  //open connection
                  $ch = curl_init();
                  
                  //set the url, number of POST vars, POST data
                  curl_setopt($ch,CURLOPT_URL, $postUrl);
                  curl_setopt($ch,CURLOPT_POST, count($postFields));
                  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                  
                  //execute post
                  $result = curl_exec($ch);
                  $error = curl_error($ch);
                  //var_dump($result);
                  //var_dump($error);
                  //close connection
                  curl_close($ch);
                  $first_emails = array();
                
                }
            }
            if(count($first_emails))
            {
              $postUrl = 'https://www.rmgmail.com/sendrmmemail.php';
              $postFields = array(
        			'contacts' => urlencode(json_encode($first_emails)),
        			'emailsubject' => urlencode($message->email_subject),
        			'emailbody' => urlencode($emailBody),
        			'emailfrom' => urlencode($user->first_from_email),
        			'company' => urlencode($user->company),
                    'email_enable_text_invitation' => urlencode($user->email_enable_text_invitation),
        			'key' => '245rrmkido',
			  );
              $fields_string = '';
              //url-ify the data for the POST
              foreach($postFields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
              rtrim($fields_string, '&');
              
              //open connection
              $ch = curl_init();
              
              //set the url, number of POST vars, POST data
              curl_setopt($ch,CURLOPT_URL, $postUrl);
              curl_setopt($ch,CURLOPT_POST, count($postFields));
              curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
              curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
              
              //execute post
              $result = curl_exec($ch);
              $error = curl_error($ch);
              //var_dump($result);
              //var_dump($error);
              //close connection
              curl_close($ch);
            }
        }
        else if($message->message_type_id==2) // text message
        {
          // first assign any contacts without a twilio number to one
          $this->assign_twilio_numbers($message->main_user_id);
          
          $sendTimeframeStatus = 0;
          if($message->send_timeframe)
          {
     		  $query2a = $this->db->query("select count(distinct mobile_phone) as num_contacts from contacts where main_user_id=".$message->main_user_id);
              $totalContacts = $query2a->row()->num_contacts;
              $numContacts = round($totalContacts / $message->send_timeframe);
              if($numContacts < 1)
                  $numContacts = 1;
              $sendTimeframeStatus = $message->send_timeframe_status+1;
              if($sendTimeframeStatus == $message->send_timeframe)
              {
                  $newStatus = 5;
                  $limitText = "";
              }
              else
              {
                  $newStatus = 1;
                  $limitText = "limit ".$numContacts;
              }
     		 $query2 = $this->db->query("select c.* from contacts as c left join message_log as ml on (c.mobile_phone = ml.mobile_phone and ml.message_id=".$messageId.") where c.main_user_id=".$message->main_user_id." and ml.sent_date is null group by c.mobile_phone ".$limitText);
             $contact_list = $query2->result();
          }
          else
          {
             $newStatus = 5;
     		 $query2 = $this->db->query("select * from contacts where main_user_id=".$message->main_user_id." group by mobile_phone");
             $contact_list = $query2->result();
          }
          
          $sorted_contacts = array();
          $unassigned_contacts = array();
          foreach($contact_list as $contact)
          {
            if(!$contact->twilio_number)
            {
                $unassigned_contacts[] = $contact;
            }
            else
            {
                if(!array_key_exists($contact->twilio_number,$sorted_contacts) || !is_array($sorted_contacts[$contact->twilio_number]))
                {
                    $sorted_contacts[$contact->twilio_number] = array();
                }
                $sorted_contacts[$contact->twilio_number][] = $contact;
            }
          }
          $contactsLeft = 1;
          $i = 0;
          while($contactsLeft)
          {
            $contactsLeft = 0;
            foreach($sorted_contacts as $sList) //each phone number needs approximately a 20 second delay between each message, if we have more phone numbers, the delay time is reduced
            {
              if(isset($sList[$i]))
              {
                $contactsLeft++;
                $contact = $sList[$i];
                if(isset($contact->mobile_phone) && strlen($contact->mobile_phone) && $contact->twilio_number)
                {
                    $this->db->insert('message_log',array('message_id'=>$message->message_id,'contact_id'=>$contact->contact_id,'mobile_phone'=>$contact->mobile_phone,'message_status'=>5));
                    $sendResult = $this->send_text_message($message->main_user_id,$contact->contact_id,$contact->mobile_phone,$contact->twilio_number,$message->text_message);
                }
              }
            }
            sleep(20);
            $i++;
          }
        
        }
        
        
        $dbData = array(
            'sent_date'=>date('Y-m-d'),
            'message_status'=>$newStatus,
        );
        if($sendTimeframeStatus)
            $dbData['send_timeframe_status'] = $sendTimeframeStatus;
        $this->db->update('messages',$dbData,array('message_id'=>$messageId));
        echo 'Message Sent';
        
        
    }

}
