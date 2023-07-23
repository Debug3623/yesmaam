<?php
namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email 
{
	private $host = '';
	private $mail = null;
	// help@@nurse.yesmaam.ae
	// %M2hdAz0kB@J7MuO

	public function __construct()
	{
		$this->mail = new PHPMailer(true);
	}

	public function sendMail($to, $subject, $body)
	{
		try {
			//$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
			//$this->mail->isSMTP();
          	/*
			$this->mail->Host       = 'smtp.zoho.in';                     //Set the SMTP server to send through
		    $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $this->mail->Username   = 'admin@yesmaam.ae'; //'help@nurse.yesmaam.ae';                     //SMTP username
		    $this->mail->Password   = 'A9qBsw5UVbqk'; //'xUzQ78yRLtBT';                               //SMTP password
		    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption STARTTLS ENCRYPTION_SMTPS
		    $this->mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		    //Recipients
		    $this->mail->setFrom('admin@yesmaam.ae', 'Yesmaam');
		    $this->mail->addAddress('vidur.sharmapp@gmail.com', 'Vidur Sharma');     //Add a recipient
			$this->mail->addAddress('admin@yesmaam.ae', 'Amar Agrawal');
		    //Content
		    $this->mail->isHTML(true);                                  //Set email format to HTML
		    $this->mail->Subject = 'Here is the subject';
		    $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		    $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $this->mail->send();
		    echo 'Message has been sent';
            */
          
          	$email = \Config\Services::email();
			$config['protocol'] = 'smtp';
            //$config['mailPath'] = '/usr/sbin/sendmail';
            $config['charset']  = 'iso-8859-1';
            $config['SMTPHost']	= 'smtp.zoho.in';
            $config['SMTPUser']	= 'admin@yesmaam.ae';
            $config['SMTPPass']	= 'A9qBsw5UVbqk';
            $config['SMTPPort']	= 465;
          	$config['SMTPCrypto'] = 'ssl';
          	$config['mailType'] = 'html';

            $email->initialize($config);
          	//foreach($to as $r) {
            $email->setTo($to);
            //}
            $email->setFrom('admin@yesmaam.ae', 'YesMaam');

            //$email->setTo('vidur.sharmapp@gmail.com');
            //$email->setCC('another@another-example.com');
            //$email->setBCC('them@their-example.com');

            $email->setSubject($subject);
            $email->setMessage($body);

            return $email->send();
		}
		catch(\Exception $e) {
			die($e->getMessage());
		}
	}

	public function sendMail3($to, $subject, $body)
	{
		try {
			$to = 'amagrawal0090@gmail.com';
			$subject = 'Testing';
			$message = 'Hello';

			$config['protocol'] = 'sendmail';
			$config['mailPath'] = '/usr/sbin/sendmail';
			$config['charset']  = 'iso-8859-1';
			$config['wordWrap'] = true;
			$config['SMTPHost'] = 'http://yesmaam.ae';
			$config['SMTPUser'] = 'noreply@yesmaam.ae';
			$config['SMTPPass'] = 'Solutions@123';
			$config['SMTPPort'] = 465;
			$config['mailType'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['validate'] = true;

			
			$email = \Config\Services::email();
			$email->initialize($config);
			$email->setTo($to);
			$email->setFrom('noreply@yesmaam.ae', 'Confirm Registration');
			
			$email->setSubject($subject);
			$email->setMessage($message);
			dd($email->send());
       		if ($email->send())
			{
           		echo 'Email successfully sent';
       		}
			else
			{
           		$data = $email->printDebugger(['headers']);
           		print_r($data);
       		}
           
         
   
		}
		catch(\Exception $e) {
			die($e->getMessage() . '-' . $e->getLine());
		}
	}

	public function sendMail2($to, $subject, $body)
	{
		$mail = new PHPMailer(true);
		try {

			$mail->SMTPDebug = 2;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'yesmaam.ae';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'noreply@yesmaam.ae';                     //SMTP username
			$mail->Password   = 'Solutions@123';                               //SMTP password
			$mail->SMTPSecure = 'ssl'; //PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 465;     
			$mail->setFrom('noreply@yesmaam.ae');
    		$mail->addAddress('amagrawal0090@gmail.com', 'Amar Agrawal');     		//Add a recipient 
			$mail->addAddress('info@rdgakola.ac.in', 'Amar Agrawal');
			$mail->isHTML(true);                                  		//Set email format to HTML
			$mail->Subject = 'Here is the subject';
			$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			echo 'Message has been sent';    




			// $to = 'info@rdgakola.ac.in';
			// $subject = 'Testing';
			// $message = 'Hello';

			// $config['protocol'] = 'sendmail';
			// $config['mailPath'] = '/usr/sbin/sendmail';
			// $config['charset']  = 'iso-8859-1';
			// $config['wordWrap'] = true;
			// $config['SMTPHost'] = 'yesmaam.ae';
			// $config['SMTPUser'] = 'noreply@yesmaam.ae';
			// $config['SMTPPass'] = 'Solutions@123';
			// $config['SMTPPort'] = 465;
			// $config['mailType'] = 'html';
			// $config['charset'] = 'iso-8859-1';
			// $config['validate'] = true;

			
			// $email = \Config\Services::email();
			// $email->initialize($config);
			// $email->setTo($to);
			// $email->setFrom('noreply@yesmaam.ae', 'Confirm Registration');
			
			// $email->setSubject($subject);
			// $email->setMessage($message);
			// //dd($email->send());
       		// if ($email->send())
			// {
           	// 	echo 'Email successfully sent';
       		// }
			// else
			// {
           	// 	$data = $email->printDebugger(['headers']);
           	// 	print_r($data);
       		// }
           
			// if(mail('amagrawal0090@gmail.com', 'Test', "Hello, How Are", "from:noreply@yesmaam.ae")) {
			// 	echo "Mail Sent";
			// }
			// else {
			// 	echo "Error sending Email";
			// }
   
		}
		catch(\Exception $e) {
			die($e->getMessage() . '-' . $e->getLine());
		}
	}

}