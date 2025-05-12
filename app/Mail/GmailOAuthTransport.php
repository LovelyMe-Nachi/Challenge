<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Illuminate\Mail\Mailable;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

class GmailOAuthTransport extends Transport
{
    protected $client_id;
    protected $client_secret;
    protected $app_password;

    // Constructor to accept the App Password
    public function __construct($client_id, $client_secret, $app_password)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->app_password = $app_password; // The Gmail App Password
    }

    // Send method to send the email
    public function send(Mailable $mailable, array $options = [])
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME'); // Your Gmail address
        $mail->Password = $this->app_password; // Use Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set up the email content
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($mailable->to[0]['address'], $mailable->to[0]['name']);
        $mail->Subject = $mailable->subject;
        $mail->Body = $mailable->render();

        // Send email
        $mail->send();
    }
}
