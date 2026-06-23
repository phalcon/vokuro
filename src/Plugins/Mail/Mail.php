<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Plugins\Mail;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Injectable
{
    /**
     * Builds the e-mail message. Pure and unit-testable: all inputs are passed
     * in, nothing is read from the container.
     *
     * @param array  $to associative array of address => name
     * @param string $subject
     * @param string $html
     * @param string $fromEmail
     * @param string $fromName
     *
     * @return Email
     */
    public function buildMessage(
        array $to,
        string $subject,
        string $html,
        string $fromEmail,
        string $fromName
    ): Email {
        $email = (new Email())
            ->from(new Address($fromEmail, $fromName))
            ->subject($subject)
            ->html($html);

        foreach ($to as $address => $name) {
            $email->addTo(new Address((string) $address, (string) $name));
        }

        return $email;
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function getTemplate(string $name, array $params): string
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl,
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function (View $view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }

    /**
     * Sends e-mails based on predefined templates
     *
     * @param array  $to
     * @param string $subject
     * @param string $name
     * @param array  $params
     *
     * @return int Number of recipients the message was addressed to
     */
    public function send(array $to, string $subject, string $name, array $params): int
    {
        $mailSettings = $this->config->mail;
        $template     = $this->getTemplate($name, $params);

        $message = $this->buildMessage(
            $to,
            $subject,
            $template,
            (string) $mailSettings->fromEmail,
            (string) $mailSettings->fromName
        );

        $transport = new EsmtpTransport(
            (string) $mailSettings->smtp->server,
            (int) $mailSettings->smtp->port
        );
        $transport->setUsername((string) $mailSettings->smtp->username);
        $transport->setPassword((string) $mailSettings->smtp->password);

        (new Mailer($transport))->send($message);

        return count($to);
    }
}
