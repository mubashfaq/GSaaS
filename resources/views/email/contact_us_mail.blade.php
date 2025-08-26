<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Contact Form Confirmation</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            background-color: #f2f4f6;
            color: #555555;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background-color: #008aff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px 40px;
        }
        .email-footer {
            background-color: #f2f4f6;
            padding: 15px 40px;
            font-size: 12px;
            text-align: center;
            color: #999999;
        }
        .logo {
            max-width: 120px;
            margin: 0 auto 20px;
        }
        h1 {
            font-size: 22px;
            margin: 20px 0;
            color: #333333;
        }
        p {
            font-size: 14px;
            line-height: 24px;
            margin: 10px 0;
        }
        .message-summary {
            background-color: #f8f9fa;
            border-left: 4px solid #008aff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
            color: #333;
        }
        .divider {
            border-top: 2px solid #008aff;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-body, .email-footer {
                padding: 20px;
            }
            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <img class="logo" src="{{ get_file(sidebar_logo()) }}" alt="Logo">
        <h1 style="color: white;">Thank You for Contacting Us!</h1>
    </div>
    
    <!-- Body -->
    <div class="email-body">
        <p><strong>Hi {{ $name }},</strong></p>

        <p>Thank you for reaching out to us! Your message has been successfully received, and our support team will get back to you as soon as possible.</p>

        <div class="message-summary">
            <p><span class="label">Name:</span> {{ $name }}</p>
            <p><span class="label">Email:</span> <a href="mailto:{{ $email }}">{{ $email }}</a></p>
            @if(!empty($phone))
            <p><span class="label">Phone:</span> <a href="tel:{{ $phone }}">{{ $phone }}</a></p>
            @endif
            <p><span class="label">Date:</span> {{ now()->format('M d, Y \a\t g:i A') }}</p>
        </div>

        <div class="divider"></div>

        <p><strong>Your Message:</strong></p>
        <div class="message-summary">
            {!! nl2br(e($message)) !!}
        </div>

        <p>If you have any urgent inquiries, feel free to reply to this email directly.</p>

        <p>We appreciate your interest and will be in touch soon.</p>

        <p style="margin-top: 30px;"><strong>– The GSaaS Support Team</strong></p>
    </div>
    
    <!-- Footer -->
    <div class="email-footer">
        This is an automated confirmation from your GSaaS contact form.<br>
        &copy; {{ now()->year }} GSaaS. All rights reserved.
    </div>
</div>
</body>
</html>
