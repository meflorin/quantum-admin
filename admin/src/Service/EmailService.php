<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class EmailService
{
    const SMTP_HOST = 'smtp.mailgun.org';
    const SMTP_PORT = 587;
    const SMTP_USERNAME = 'postmaster@sandbox7bb94ce1bc3b4c7a95c768d8d8310124.mailgun.org';
    const SMTP_PASSWORD = '840d944acd8cc243643b8362b3a39d61-b3780ee5-3d355a48';
    const EMAIL_SENDER = 'fpaun23@gmail';

    private $request;
    private $sender;
    private $mailer;

    public function __construct(RequestStack $request_stack = null)
    {
        $this->request = $request_stack->getCurrentRequest();

        $transport = new \Swift_SmtpTransport(
            $this->request->server->get('SMTP_HOST', self::SMTP_HOST),
            intval($this->request->server->get('SMTP_PORT', self::SMTP_PORT))
        );
        $transport->setUsername(
            $this->request->server->get('SMTP_USERNAME', self::SMTP_USERNAME)
        );

        $transport->setPassword(
            $this->request->server->get('SMTP_PASSWORD', self::SMTP_PASSWORD)
        );

        $this->mailer = new \Swift_Mailer($transport);

        $this->sender = $this->request->server->get('EMAIL_SENDER', self::EMAIL_SENDER);

        /*
        $transport = new \Swift_SmtpTransport('smtp.mailgun.org', 587);
        $transport->setUsername('postmaster@sandbox7bb94ce1bc3b4c7a95c768d8d8310124.mailgun.org');
        $transport->setPassword('840d944acd8cc243643b8362b3a39d61-b3780ee5-3d355a48');
        $this->mailer = new \Swift_Mailer($transport);
        */

    }

    public function getMailer()
    {
        return $this->mailer;
    }

    public function getSender()
    {
        return $this->sender;
    }

}