<?php
/**
 * PHPMailer Test Script for CEMAC Trading
 */

// Include configuration and PHPMailer
require_once 'app/Config/Config.php';
require_once 'vendor/PHPMailer.php';
require_once 'vendor/SMTP.php';
require_once 'vendor/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>
<!DOCTYPE html>
<html>
<head>
    <title>PHPMailer Test - CEMAC Trading</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .info { background: #f0f8ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow: auto; }
    </style>
</head>
<body>
    <h2>📧 PHPMailer Test - CEMAC Trading</h2>
    <hr>
    
    <h3>1. Configuration Check</h3>
    <div class="info">
        <strong>SMTP Host:</strong> <?= Config::SMTP_HOST ?><br>
        <strong>SMTP Port:</strong> <?= Config::SMTP_PORT ?><br>
        <strong>Username:</strong> <?= Config::SMTP_USERNAME ?><br>
        <strong>Password:</strong> <?= str_repeat('*', strlen(Config::SMTP_PASSWORD)) ?><br>
        <strong>From Email:</strong> <?= Config::SMTP_FROM_EMAIL ?><br>
        <strong>Admin Emails:</strong> <?= implode(', ', Config::ADMIN_EMAILS) ?>
    </div>

    <h3>2. PHPMailer Test</h3>
    <?php
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host       = Config::SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = Config::SMTP_USERNAME;
        $mail->Password   = Config::SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = Config::SMTP_PORT;

        // Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
        $mail->Debugoutput = 'html';

        echo "<div class='info'><strong>Connecting to Gmail SMTP...</strong></div>";

        // Recipients
        $mail->setFrom(Config::SMTP_FROM_EMAIL, Config::SMTP_FROM_NAME);
        $mail->addAddress(Config::ADMIN_EMAILS[0]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'PHPMailer Test - CEMAC Trading';
        $mail->Body    = '<h2>🎉 PHPMailer Test Successful!</h2>
                         <p>This email was sent using PHPMailer from the CEMAC Trading contact system.</p>
                         <p><strong>Test Details:</strong></p>
                         <ul>
                             <li>Date: ' . date('Y-m-d H:i:s') . '</li>
                             <li>Server: ' . $_SERVER['SERVER_NAME'] . '</li>
                             <li>PHPMailer Version: 6.9.1</li>
                         </ul>
                         <p>Email configuration is working properly!</p>';
        
        $mail->AltBody = 'PHPMailer Test Successful! Email sent at ' . date('Y-m-d H:i:s');

        echo "<div class='info'><strong>Sending test email...</strong></div>";
        
        if ($mail->send()) {
            echo '<div class="success">✅ Message has been sent successfully!</div>';
            echo '<div class="info">Check your inbox at: ' . Config::ADMIN_EMAILS[0] . '</div>';
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        echo "<div class='error'>Exception: {$e->getMessage()}</div>";
    }
    ?>

    <h3>3. Debug Information</h3>
    <p>If the test failed, check the debug output above and the log file:</p>
    <div class="info">
        <strong>Log File:</strong> /logs/phpmailer_debug.log<br>
        <strong>Check for:</strong> Authentication errors, connection timeouts, or TLS issues
    </div>

    <h3>4. Common Issues & Solutions</h3>
    <div class="info">
        <strong>Authentication Failed:</strong> Check Gmail app password<br>
        <strong>Connection Timeout:</strong> Check firewall settings<br>
        <strong>TLS Errors:</strong> Verify port 587 is open<br>
        <strong>From Address Error:</strong> Must match authenticated Gmail account
    </div>

    <hr>
    <p>
        <a href="javascript:history.back()">← Go Back</a> | 
        <a href="?">🔄 Refresh Test</a> |
        <a href="<?= Config::APP_URL . Config::BASE_PATH ?>/en/">🏠 Home</a>
    </p>
</body>
</html>