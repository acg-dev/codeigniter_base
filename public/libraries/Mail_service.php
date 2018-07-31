<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/third_party/PHPMailer/PHPMailerAutoload.php');
require_once(APPPATH.'/third_party/PHPMailer/class.smtp.php');

class Mail_service
{
	private $from, $to, $subject, $message, $attachment, $embedImage, $mail_type; 
	public function send(){
		if(!empty($this->from) && !empty($this->to) && !empty($this->subject) && !empty($this->message)){
			$mailer = new PHPMailer();
			
			$mailer->FromName =$this->from[1];
			$mailer->From = $this->from[0];
			$mailer->CharSet = "UTF-8";
			$mailer->IsHTML(true);
			
			/* SMTP
			$mailer->IsSMTP();
			$mailer->SMTPSecure = 'tls';
			$mailer->SMTPAuth = true;
			$mailer->Host = 'smtp-relay.sendinblue.com';
			$mailer->Port = 587;
			$mailer->Username = '';
			$mailer->Password = '';
			$mailer->SMTPOptions = array(
								    'ssl' => array(
								         'verify_peer' => false,
								        'verify_peer_name' => false,
								        'allow_self_signed' => true
								    ),
								);
			*/

			if(!empty($this->attachment))
				$mailer->AddAttachment($this->attachment);
			
			if(!empty($this->embedImage)){
				foreach ($this->embedImage as $key => $value) {
					$mailer->AddEmbeddedImage($value[0],$value[1],$value[2],$value[3],$value[4]);
				}
			}

			$tos = array();


			if(is_array($this->to)){
				 $keys = array_keys($this->to);
				 if(is_array($this->to[$keys[0]])){
						$tos = $this->to;
				}else{
					foreach($this->to as $row)
						$tos[] = array('email' => $row, 'name' => '');
				}
			}else
				$tos[] = array('email' => $this->to, 'name' => '');


			foreach ($tos as $to) {	
				$subject = str_replace('[%user_name%]', $to['name'], $this->subject);
				$body =  str_replace('[%user_name%]', $to['name'], $this->message);
				$mailer->Subject = $subject;
				$mailer->Body =  $body;
				$mailer->AddAddress($to['email']);


				if(!$mailer->Send()){
					return false;
				}

				$mailer->ClearAllRecipients();
				$mailer->ClearReplyTos();
		
			}

			$mailer->ClearAttachments();
			$mailer->ClearCustomHeaders();
			return true;
		}
		return false;
	}
	
	public function SetMailType($type){$this->mail_type = $type;}
	public function setFrom($email, $name){$this->from = array($email, $name);}
	public function setTo($to){$this->to = $to;}
	public function setSubject($subject){$this->subject = $subject;}
	public function setMessage($message){$this->message = $message;}
	public function setAttachment($attachment){$this->attachment = $attachment;}
	public function setEmbeddedImage($images){$this->embedImage = $images;}
}