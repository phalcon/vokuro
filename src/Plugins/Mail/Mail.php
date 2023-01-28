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
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

use function sprintf;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Injectable
{
    /**
     * Sends e-mails based on predefined templates
     *
     * @param array  $to
     * @param string $subject
     * @param string $name
     * @param array  $params
     *
     * @return void
     */
    public function send(
        array $to,
        string $subject,
        string $name,
        array $params
    ): void {
        // Settings
        $mailSettings = $this->config->mail;
        $template     = $this->getTemplate($name, $params);

        $mailUsername = $mailSettings->smtp->username;
        if (true !== empty($mailUsername)) {
            $mailUsername .= ':' . $mailSettings->smtp->password;
        }

        // Create the message
        $message = new Email();
        $message
            ->subject($subject)
            ->from(new Address($mailSettings->fromEmail, $mailSettings->fromName))
            ->to(...$to)
            ->text($template)
        ;

        $dsn       = sprintf(
            'smtp://%s@%s:%s',
            $mailUsername,
            $mailSettings->smtp->server,
            $mailSettings->smtp->port
        );
        $transport = Transport::fromDsn($dsn);

        (new Mailer($transport))->send($message);
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function getTemplate(string $name, array $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl,
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function (View $view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }
}
