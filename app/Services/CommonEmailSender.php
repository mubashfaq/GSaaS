<?php

namespace App\Services;

use SendGrid;
use SendGrid\Mail\Mail;

class CommonEmailSender
{
    protected $template;
    protected $user_id;
    protected $workspace_id;
    protected $sendgrid;

    public function __construct($template, $user_id, $workspace_id)
    {
        $this->template =  $template;
        $this->user_id = $user_id;
        $this->workspace_id = $workspace_id;
          $this->sendgrid = new SendGrid(config('mail.password'));
        //  $this->sendgrid = new SendGrid('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');
    }

    public function send($to)
    {
        $email = new Mail();

        // Dynamic values based on your existing code
        $fromEmail = company_setting('mail_from_address', $this->user_id, $this->workspace_id);
        $fromName = $this->template->from;
        $subject = $this->template->subject;

        // Render your existing Blade view
        $htmlContent = view('email.common_email_template', ['content' => $this->template->content])->render();

        $email->setFrom($fromEmail, $fromName);
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/html", $htmlContent);

        try {
            $response = $this->sendgrid->send($email);
            return [
                'status' => $response->statusCode(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
