<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail as SendGridMail;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $toEmail;

    public function __construct($toEmail)
    {
        $this->toEmail = $toEmail;
    }

//   public function build()
//     {
//         $renderedView = view('email.test_mail')->render();
//         $email = new \SendGrid\Mail\Mail();
//         $email->setFrom('your_verified_email@example.com', 'Your App Name');
//         $email->setSubject('Regarding testing purpose mail send.');
//         $email->addTo($this->toEmail);
//         $email->addContent("text/html", $renderedView);
    
//         $sendgrid = new \SendGrid('your_sendgrid_api_key');
    
//         try {
//             $response = $sendgrid->send($email);
//             // Optionally log or return response here
//         } catch (\Exception $e) {
//             // Log or handle error
//         }
    
//         // 👇 REMOVE Laravel build return to stop "Invalid view" error
//         return null;
//     }

    public function build()
    {
        return $this->view('email.test_mail')->subject('Ragarding to testing purpose mail send.');
    }

}
