<?php

namespace Vokuro\Mail;

use Phalcon\Mvc\User\Component,
	Swift_Message as Message,
	Swift_SmtpTransport as Smtp,
	Vokuro\Models\Users,
	Phalcon\Mvc\View;

require_once __DIR__ . '/../../../vendor/Swift/swift_required.php';
require_once __DIR__ . '/../../../vendor/AWSSDKforPHP/sdk.class.php';

/**
 * Vokuro\Mail\Mail
 *
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Component
{

	protected $_transport;

	protected $_amazonSes;

	protected $_directSmtp = false;

	/**
	 * Send a raw e-mail via AmazonSES
	 *
	 * @param string $raw
	 */
	private function _amazonSESSend($raw)
	{

		if ($this->_amazonSes == null) {
			$this->_amazonSes = new \AmazonSES($this->config->amazon->AWSAccessKeyId, $this->config->amazon->AWSSecretKey);
			$this->_amazonSes->disable_ssl_verification();
		}

		$response = $this->_amazonSes->send_raw_email(array(
			'Data' => base64_encode($raw)
		), array(
			'curlopts' => array(
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0
			)
		));

		if (!$response->isOK()) {
			throw new Exception('Error sending email from AWS SES: ' . $response->body->asXML());
		}

		return true;
	}

	/**
	 * Applies a template to be used in the e-mail
	 *
	 * @param string $name
	 * @param array $params
	 */
	public function getTemplate($name, $params)
	{

		$parameters = array_merge(array(
			'publicUrl' => $this->config->application->publicUrl,
		), $params);

		return $this->view->getRender('emailTemplates', $name, $parameters, function($view){
			$view->setRenderLevel(View::LEVEL_LAYOUT);
		});

		return $view->getContent();
	}

	/**
	 * Sends e-mails via AmazonSES based on predefined templates
	 *
	 * @param array $to
	 * @param string $subject
	 * @param string $name
	 * @param array $params
	 */
	public function send($to, $subject, $name, $params)
	{

		//Settings
		$mailSettings = $this->config->mail;

		$template = $this->getTemplate($name, $params);

		// Create the message
		$message = Message::newInstance()
  			->setSubject($subject)
  			->setTo($to)
  			->setFrom(array(
  				$mailSettings->fromEmail => $mailSettings->fromName
  			))
  			->setBody($template, 'text/html');

  		if ($this->_directSmtp) {

	  		if (!$this->_transport) {
				$this->_transport = Smtp::newInstance(
					$mailSettings->smtp->server,
					$mailSettings->smtp->port,
					$mailSettings->smtp->security
				)
		  			->setUsername($mailSettings->smtp->username)
		  			->setPassword($mailSettings->smtp->password);
		  	}

		  	// Create the Mailer using your created Transport
			$mailer = \Swift_Mailer::newInstance($this->_transport);

			return $mailer->send($message);

		} else {
			return $this->_amazonSESSend($message->toString());
		}

	}

}