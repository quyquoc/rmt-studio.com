<?php

namespace Modules\Frontend\Controllers;

class ContactController extends ControllerBase
{
	
	protected function initialize(){
		parent::initialize();
		$this->view->setTemplateAfter('templates');
	}

	public function indexAction(){

		require_once APPS_PATH . 'frontend/includes/menu.php';


    	if ($this->request->isPost() == true) {
	    		
			require_once PUBLIC_PATH . 'library/swiftmailer/lib/swift_required.php';

			//Settings
	        $mail_settings = $this->config->mail;
			
			// Create the SMTP configuration
			$transport = \Swift_SmtpTransport::newInstance(
								$mail_settings->smtp->server,
			                    $mail_settings->smtp->port,
			                    $mail_settings->smtp->security
	                );
	        $transport->setUsername($mail_settings->smtp->username);
	        $transport->setPassword($mail_settings->smtp->password);

			$form_data = $this->request->getPost();

			// Create the message
			$message = \Swift_Message::newInstance();
			$message->setTo(array($form_data['fromEmail']));
			$message->setSubject($form_data['title']);
			$message->setBody($form_data['content']);
			$message->setFrom($mail_settings->from_email, $mail_settings->from_name);

			// Send the email
			$mailer = \Swift_Mailer::newInstance($transport);
			$result = $mailer->send($message);
			if($result){
				$this->flash->success("Thank you, sent mail successful!");

				$tbl_contact = new \Modules\Frontend\Models\Contact();
				$tbl_contact->fullname 	= $form_data['fullName'];
				$tbl_contact->from_mail = $form_data['fromEmail'];
				$tbl_contact->title 	= $form_data['title'];
				$tbl_contact->content 	= $form_data['content'];
				$tbl_contact->status 	= '0';
				$tbl_contact->send_date = date('Y-m-d H:i:s');
				$tbl_contact->save();
			}else{
				$this->flash->error("Failed! Please send mail again!");
			}
    	}
	}
}
