<?php
/**
 * Class Helper for common task
 * @auhtor Siswo
 */
use Illuminate\Support\Facades\Mail as Mailer;

class MyHelpers
{
	/** Send Email function
	 * @param $to Array Recepient Email address
	 * @param $from String 'info','password','promo','marketing'
	 * @param $subject String Email subject
	 * @param $type String html,text default html
	 * @param $template String Email View
	 * @param $data Array if need data to display at view
	 */
	public static function send_mail( $to = array(), $from = 'info', $subject = "",  $type="html", $template = "", $data = array())
	{
		if( $subject !== "" || !empty($to) || $template !=="" ){
			Mailer::send($template,$data, function ($message) use ( $to, $from, $subject) {
				switch($from) {
					case 'info' :
							$message->from('verify@markibid', 'Markibid');
							break;
					case 'password' :
							$message->from('verify@markibid', 'Markibid');
							break;
					case 'promo' :
							$message->from('verify@markibid', 'Markibid');
							break;
					case 'marketing':
							$message->from('verify@markibid', 'Marketing');
							break;
					default :
							$message->from('verify@markibid', 'Admin Markibid');
							break;
				}
          		$message->subject($subject);
            	$message->to($to);
        	});
		}
	}
}
