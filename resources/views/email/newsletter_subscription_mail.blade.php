<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Subscription Confirmation</title>
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

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #008aff;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .divider {
            border-top: 4px solid #008aff;
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
        <h1 style="color: white;">Welcome to Our Newsletter</h1>
    </div>

    <!-- Body -->
    <div class="email-body">
        <p><strong>Hi{{ isset($name) ? ' ' . $name : '' }},</strong></p>

        <p>Thank you for subscribing to our newsletter! We're excited to have you onboard. From now on, you'll receive the latest updates, offers, and news straight to your inbox.</p>

        <div class="divider"></div>

        <p>If you ever wish to unsubscribe, simply click the unsubscribe link at the bottom of any of our emails. But we hope you’ll stick around!</p>

        <p><strong>Subscribed on:</strong> {{ now()->format('F j, Y') }}</p>

        <p style="margin-top: 30px;"><strong>Cheers,<br>Team GSaaS</strong></p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        &copy; {{ now()->year }} GSaaS. All rights reserved.
    </div>

</div>
</body>
</html>
