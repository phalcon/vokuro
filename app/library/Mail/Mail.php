<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Mail;

use Phalcon\Mvc\View;
use Swift_Message as Message;
use Phalcon\Mvc\User\Component;
use Vokuro\Exception\Exception;
use Swift_SmtpTransport as Smtp;

/**
 * Sends e-mails based on pre-defined templates
 *
 * Vokuro\Mail\Mail
 * @package Vokuro\Mail
 */
class Mail extends Component
{
    protected $transport;

    protected $amazonSes;

    /**
     * Send a raw e-mail via AmazonSES
     *
     * @param string $raw
     * @return bool
     */
    private function amazonSESSend($raw)
    {
        if ($this->amazonSes == null) {
            $this->amazonSes = new \AmazonSES(
                [
                    'key'    => $this->config->amazon->AWSAccessKeyId,
                    'secret' => $this->config->amazon->AWSSecretKey
                ]
            );
            @$this->amazonSes->disable_ssl_verification();
        }

        $response = $this->amazonSes->send_raw_email(
            [
                'Data' => base64_encode($raw)
            ],
            [
                'curlopts' => [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ]
            ]
        );

        if (!$response->isOK()) {
            $this->logger->error('Error sending email from AWS SES: ' . $response->body->asXML());
        }

        return true;
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getTemplate($name, $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
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
     * @return bool|int
     * @throws Exception
     */
    public function send($to, $subject, $name, $params)
    {
        // Settings
        $mailSettings = $this->config->mail;

        $template = $this->getTemplate($name, $params);

        // Create the message
        $message = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom([
                $mailSettings->fromEmail => $mailSettings->fromName
            ])
            ->setBody($template, 'text/html');

        if (isset($mailSettings) && isset($mailSettings->smtp)) {
            if (!$this->transport) {
                $this->transport = Smtp::newInstance(
                    $mailSettings->smtp->server,
                    $mailSettings->smtp->port,
                    $mailSettings->smtp->security
                )
                ->setUsername($mailSettings->smtp->username)
                ->setPassword($mailSettings->smtp->password);
            }

            // Create the Mailer using your created Transport
            $mailer = \Swift_Mailer::newInstance($this->transport);

            return $mailer->send($message);
        } else {
            return $this->amazonSESSend($message->toString());
        }
    }
}
