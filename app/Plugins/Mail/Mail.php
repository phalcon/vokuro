<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Plugins\Mail;

use Phalcon\Mvc\View;
use Phalcon\Plugin;
use Swift_Mailer;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Plugin
{
    /**
     * Sends e-mails via AmazonSES based on predefined templates
     *
     * @param array $to
     * @param string $subject
     * @param string $name
     * @param array $params
     * @return int
     */
    public function send($to, $subject, $name, $params): int
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

        $transport = Smtp::newInstance(
            $mailSettings->smtp->server,
            $mailSettings->smtp->port,
            $mailSettings->smtp->security
        )
            ->setUsername($mailSettings->smtp->username)
            ->setPassword($mailSettings->smtp->password);

        return Swift_Mailer::newInstance($transport)->send($message);
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getTemplate(string $name, array $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function (View $view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }
}
