<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation of Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .success-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #155724;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #0073e6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .contact-section {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .contact-item {
            margin: 10px 0;
            padding: 10px;
            background: #ffffff;
            border-left: 3px solid #0073e6;
            padding-left: 15px;
        }
        .contact-label {
            font-weight: bold;
            color: #0073e6;
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .contact-value {
            font-size: 16px;
            color: #333;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .timeline {
            margin: 20px 0;
            padding: 15px;
            background: #fff9e6;
            border-left: 4px solid #ffc107;
            border-radius: 4px;
        }
        .timeline-item {
            margin: 10px 0;
            padding-left: 25px;
            position: relative;
        }
        .timeline-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Request Confirmed!</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Dr. Aldo Avellaneda - Spine Surgery</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="font-size: 16px; color: #333;">
                Hello <strong><?php echo htmlspecialchars($fullName); ?></strong>!
            </p>

            <div class="success-box">
                <strong>Your appointment request has been received successfully.</strong>
                <p style="margin: 10px 0 0 0;">
                    A nurse coordinator will contact you within the next 24 business hours.
                </p>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #0073e6;">Your Request Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p style="margin: 0;"><strong>Preferred Language:</strong> <?php echo $preferredLanguage === 'spanish' ? 'Español' : 'English'; ?></p>
            </div>

            <div class="timeline">
                <p style="margin: 0 0 10px 0; font-weight: bold;">What happens next?</p>
                <div class="timeline-item">
                    You will receive a call or email within the next 24 business hours
                </div>
                <div class="timeline-item">
                    We will coordinate with you the best date and time for your consultation
                </div>
                <div class="timeline-item">
                    We will perform an initial evaluation of your case
                </div>
                <div class="timeline-item">
                    We will offer you the most appropriate treatment plan
                </div>
            </div>

            <h3 style="color: #0073e6; margin-top: 30px;">Direct Contact Methods</h3>
            <div class="contact-section">
                <div class="contact-item">
                    <span class="contact-label">Phone or WhatsApp</span>
                    <span class="contact-value">
                        <a href="https://wa.me/+1234567890" style="color: #28a745; text-decoration: none;">
                            +1 (234) 567-890
                        </a>
                    </span>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Direct Email</span>
                    <span class="contact-value">
                        <a href="mailto:contacto@draldoavellaneda.com" style="color: #0073e6; text-decoration: none;">
                            contacto@draldoavellaneda.com
                        </a>
                    </span>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Office Hours</span>
                    <span class="contact-value">
                        Monday to Friday: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 1:00 PM
                    </span>
                </div>
            </div>

            <p style="text-align: center; color: #666; margin: 30px 0 0 0; font-size: 14px;">
                If you have any urgent questions, please don't hesitate to contact us directly.<br>
                We are here to help you.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                <strong>Dr. Aldo Avellaneda</strong><br>
                Spine Surgery Specialist
            </p>
            <p style="margin: 0; color: #999;">
                This is an automated email. Please do not reply to this message.<br>
                Use the contact information provided above.
            </p>
        </div>
    </div>
</body>
</html>
