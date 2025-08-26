<?php
// File: resources/views/email/reseller_application_confirmation.blade.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Application Confirmation - GSaaS</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .highlight-box {
            background-color: #f8fafc;
            border-left: 4px solid #0ea5e9;
            padding: 20px;
            margin: 20px 0;
        }
        .next-steps {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .btn {
            display: inline-block;
            background-color: #0ea5e9;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Application Received Successfully!</h1>
        </div>
        
        <div class="content">
            <h2>Dear {{ $name }},</h2>
            
            <p>Thank you for your interest in becoming a GSaaS reseller partner! We're excited about the possibility of working together.</p>
            
            <div class="highlight-box">
                <h3>✅ Your application has been received</h3>
                <p><strong>Company:</strong> {{ $company_name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Application Date:</strong> {{ now()->format('F j, Y') }}</p>
            </div>
            
            <div class="next-steps">
                <h3>🚀 What happens next?</h3>
                <ul>
                    <li><strong>Review Process:</strong> Our partnership team will review your application within 2-3 business days</li>
                    <li><strong>Initial Assessment:</strong> We'll evaluate your business profile and partnership potential</li>
                    <li><strong>Follow-up:</strong> If approved, we'll schedule a call to discuss partnership terms and onboarding</li>
                    <li><strong>Onboarding:</strong> Successful partners receive training materials and access to our partner portal</li>
                </ul>
            </div>
            
            <p>While we review your application, feel free to explore our solutions and think about how GSaaS can benefit your target market.</p>
            
            <div class="contact-info">
                <h3>Questions about your application?</h3>
                <p><strong>Partnership Team</strong><br>
                Email: <a href="mailto:partnerships@gsaas.com.au">partnerships@gsaas.com.au</a><br>
                Phone: <a href="tel:+611619876543">+61 161 987 6543</a><br>
                Hours: Monday - Friday, 9:00 AM - 6:00 PM AEST</p>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated confirmation email. Please do not reply to this email.</p>
            <p>&copy; {{ now()->year }} GSaaS. All rights reserved.</p>
            <p>GSaaS - Your Partner in Business Transformation</p>
        </div>
    </div>
</body>
</html>