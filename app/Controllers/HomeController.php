<?php
/**
 * Home Controller - Handles all main application requests
 */

// Include PHPMailer
require_once BASE_PATH . '/vendor/PHPMailer.php';
require_once BASE_PATH . '/vendor/SMTP.php';
require_once BASE_PATH . '/vendor/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class HomeController
{
    private $products;
    
    public function __construct()
    {
        $this->loadProducts();
    }
    
    /**
     * Load product data
     */
    private function loadProducts()
    {
        $this->products = [
            [
                'name' => "Graines d'Akpi",
                'description' => 'Produit naturel collecté des forêts surtout de l\'Est du Cameroun.',
                'season' => '-',
                'packaging' => 'Sac PP de 25 kg, prêt à l\'export.',
                'price' => '5750 FCFA/sac',
                'image' => 'akpi.jpeg'
            ],
            [
                'name' => 'Curcuma en gousse',
                'description' => 'Produit cultivé dans les environs du Mont Cameroun.',
                'season' => 'Décembre à février',
                'packaging' => '-',
                'price' => '-',
                'image' => 'curcuma.jpeg'
            ],
            [
                'name' => 'Ail naturel',
                'description' => 'Produit cultivé à l\'Ouest du Cameroun.',
                'season' => 'À partir de mars',
                'packaging' => 'Filets de 10, 20 ou 25 kg',
                'price' => '1000 à 1300 FCFA/kg selon le calibre',
                'image' => 'ail.jpeg'
            ],
            [
                'name' => 'Café Arabica',
                'description' => 'Origine : Extrême Nord du Cameroun et Tchad.',
                'season' => 'Décembre et janvier',
                'packaging' => 'Sac de 100 kg',
                'price' => '-',
                'image' => 'gomme-arabica.jpeg'
            ],
            [
                'name' => 'Fruit 4 côtés',
                'description' => 'Fruit naturel collecté des arbres à l\'Est et un peu au Sud du Cameroun.',
                'season' => 'Décembre et janvier',
                'packaging' => '-',
                'price' => '-',
                'image' => 'fruit4cotes.jpeg'
            ],
            [
                'name' => 'Grains de Sésame blanc',
                'description' => 'Produit naturel cultivé des champs à l\'Extrême Nord du Cameroun et du Tchad.',
                'season' => 'Décembre et janvier',
                'packaging' => 'Traité avec Sortex',
                'price' => '1200 à 1400 FCFA/kg selon la quantité',
                'image' => 'sesame.jpeg'
            ],
            [
                'name' => 'Gingembre frais et sec',
                'description' => 'Produit frais ou sec, collecté en janvier et février.',
                'season' => 'Janvier et février',
                'packaging' => '-',
                'price' => 'Frais : 800 à 1000 FCFA/kg selon calibre<br>Sec : 1300 à 1600 FCFA/kg selon la quantité',
                'image' => 'gingembre-frais.jpeg'
            ]
        ];
    }
    
    /**
     * Home page - Single page application
     */
    public function index()
    {
        $this->renderView('single-page', [
            'title' => __('home_title'),
            'meta_description' => __('meta_description'),
            'products' => $this->products
        ]);
    }
    
    /**
     * Handle contact form submission
     */
    public function submitContact()
    {
        // Create debug log for routing
        $logDir = $_SERVER['DOCUMENT_ROOT'] . '/new/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/routing_debug.log';
        
        $logEntry = "\n" . str_repeat("=", 60) . "\n";
        $logEntry .= "SUBMIT CONTACT CALLED\n";
        $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
        $logEntry .= "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
        $logEntry .= "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
        $logEntry .= "GET params: " . print_r($_GET, true) . "\n";
        $logEntry .= "POST params: " . print_r($_POST, true) . "\n";
        $logEntry .= str_repeat("-", 60) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        $result = $this->processContactForm();
        
        file_put_contents($logFile, "processContactForm result: " . print_r($result, true) . "\n", FILE_APPEND | LOCK_EX);
        
        if ($result['success']) {
            $_SESSION['contact_message'] = $result['message'];
            $_SESSION['contact_type'] = 'success';
        } else {
            $_SESSION['contact_message'] = $result['message'];
            $_SESSION['contact_type'] = 'error';
        }
        
        // Redirect to prevent resubmission
        $redirectUrl = baseUrl(Language::current() . '/contact');
        file_put_contents($logFile, "Redirecting to: $redirectUrl\n", FILE_APPEND | LOCK_EX);
        header('Location: ' . $redirectUrl);
        exit;
    }
    
    /**
     * API endpoint for contact form
     */
    public function apiContact()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode(['error' => 'Method not allowed']);
        }
        
        $result = $this->processContactForm();
        return json_encode($result);
    }
    
    /**
     * Process contact form data
     */
    private function processContactForm()
    {
        // Create debug log for form processing
        $logDir = $_SERVER['DOCUMENT_ROOT'] . '/new/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/form_processing_debug.log';
        
        $logEntry = "\n" . str_repeat("=", 60) . "\n";
        $logEntry .= "FORM PROCESSING ATTEMPT\n";
        $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
        $logEntry .= "POST data received: " . print_r($_POST, true) . "\n";
        $logEntry .= str_repeat("-", 60) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        $name = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));
        
        file_put_contents($logFile, "Processed values:\n", FILE_APPEND | LOCK_EX);
        file_put_contents($logFile, "Name: '$name'\n", FILE_APPEND | LOCK_EX);
        file_put_contents($logFile, "Email: '$email'\n", FILE_APPEND | LOCK_EX);
        file_put_contents($logFile, "Message: '$message'\n", FILE_APPEND | LOCK_EX);
        
        // Validation
        if (empty($name) || empty($email) || empty($message)) {
            file_put_contents($logFile, "VALIDATION FAILED: Empty fields\n", FILE_APPEND | LOCK_EX);
            return [
                'success' => false,
                'message' => __('form_required')
            ];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            file_put_contents($logFile, "VALIDATION FAILED: Invalid email\n", FILE_APPEND | LOCK_EX);
            return [
                'success' => false,
                'message' => __('invalid_email')
            ];
        }
        
        file_put_contents($logFile, "Validation passed, attempting to send email...\n", FILE_APPEND | LOCK_EX);
        
        // Send email using working Gmail SMTP method
        try {
            $adminEmailSent = $this->sendEmailSMTP($name, $email, $message);
            $confirmationEmailSent = $this->sendConfirmationEmail($name, $email);
            
            file_put_contents($logFile, "Admin email result: " . ($adminEmailSent ? "SUCCESS" : "FAILED") . "\n", FILE_APPEND | LOCK_EX);
            file_put_contents($logFile, "Confirmation email result: " . ($confirmationEmailSent ? "SUCCESS" : "FAILED") . "\n", FILE_APPEND | LOCK_EX);
            
            if ($adminEmailSent && $confirmationEmailSent) {
                file_put_contents($logFile, "Both emails sent successfully\n", FILE_APPEND | LOCK_EX);
                return [
                    'success' => true,
                    'message' => __('contact_success')
                ];
            } else if ($adminEmailSent) {
                file_put_contents($logFile, "Admin email sent, confirmation failed\n", FILE_APPEND | LOCK_EX);
                return [
                    'success' => true,
                    'message' => __('contact_success')
                ];
            } else {
                file_put_contents($logFile, "Both emails failed\n", FILE_APPEND | LOCK_EX);
                return [
                    'success' => false,
                    'message' => __('contact_error')
                ];
            }
        } catch (Exception $e) {
            $errorMsg = "EXCEPTION in processContactForm: " . $e->getMessage() . "\n";
            file_put_contents($logFile, $errorMsg, FILE_APPEND | LOCK_EX);
            error_log('Email sending failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => __('contact_error')
            ];
        }
    }
    
    /**
     * Send email using PHPMailer with proper Gmail SMTP
     */
    private function sendEmailSMTP($name, $email, $message)
    {
        // Create detailed log file for debugging
        $logDir = $_SERVER['DOCUMENT_ROOT'] . '/new/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/contact_form_debug.log';
        
        // Log the attempt
        $logEntry = "\n" . str_repeat("=", 60) . "\n";
        $logEntry .= "CONTACT FORM EMAIL ATTEMPT\n";
        $logEntry .= "Time: " . date('Y-m-d H:i:s') . "\n";
        $logEntry .= "Name: $name\n";
        $logEntry .= "Email: $email\n";
        $logEntry .= "Message length: " . strlen($message) . " chars\n";
        $logEntry .= str_repeat("-", 60) . "\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

        try {
            $mail = new PHPMailer(true);

            // Server settings - exactly matching the working test
            $mail->isSMTP();
            $mail->Host       = Config::SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = Config::SMTP_USERNAME;
            $mail->Password   = Config::SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = Config::SMTP_PORT;

            // Enable verbose debug output and capture it
            $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            $mail->Debugoutput = function($str, $level) use ($logFile) {
                file_put_contents($logFile, "DEBUG: " . $str . "\n", FILE_APPEND | LOCK_EX);
            };

            file_put_contents($logFile, "Configuration loaded successfully\n", FILE_APPEND | LOCK_EX);
            file_put_contents($logFile, "Host: " . Config::SMTP_HOST . "\n", FILE_APPEND | LOCK_EX);
            file_put_contents($logFile, "Port: " . Config::SMTP_PORT . "\n", FILE_APPEND | LOCK_EX);
            file_put_contents($logFile, "Username: " . Config::SMTP_USERNAME . "\n", FILE_APPEND | LOCK_EX);

            // Recipients - exactly matching the test
            $mail->setFrom(Config::SMTP_FROM_EMAIL, Config::SMTP_FROM_NAME);
            file_put_contents($logFile, "From set: " . Config::SMTP_FROM_EMAIL . "\n", FILE_APPEND | LOCK_EX);
            
            $mail->addAddress(Config::ADMIN_EMAILS[0]); // Use first admin email like test
            file_put_contents($logFile, "To set: " . Config::ADMIN_EMAILS[0] . "\n", FILE_APPEND | LOCK_EX);
            
            $mail->addReplyTo($email, $name);
            file_put_contents($logFile, "Reply-To set: $email\n", FILE_APPEND | LOCK_EX);

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = "🔔 Nouveau message - CEMAC Trading: Message de $name";
            
            // HTML email body
            $mail->Body = "
            <html>
            <head>
                <title>Nouveau Contact - CEMAC Trading</title>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
                    .header { background: linear-gradient(135deg, #2c5aa0, #4a90e2); color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; background: #f8f9ff; }
                    .info-card { background: white; border-radius: 8px; padding: 20px; margin: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                    .label { font-weight: bold; color: #2c5aa0; margin-bottom: 5px; }
                    .value { color: #333; margin-bottom: 15px; }
                    .footer { background: #2c3e50; color: white; padding: 20px; text-align: center; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>📧 Nouveau Contact CEMAC Trading</h1>
                    </div>
                    <div class='content'>
                        <div class='info-card'>
                            <div class='label'>👤 Nom:</div>
                            <div class='value'>" . htmlspecialchars($name) . "</div>
                            <div class='label'>📧 Email:</div>
                            <div class='value'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></div>
                            <div class='label'>💬 Message:</div>
                            <div class='value' style='background: #f1f3f4; padding: 15px; border-radius: 5px;'>" . nl2br(htmlspecialchars($message)) . "</div>
                            <div class='label'>🕒 Date:</div>
                            <div class='value'>" . date('d/m/Y à H:i:s') . "</div>
                        </div>
                    </div>
                    <div class='footer'>
                        <p><strong>CEMAC Trading - Système de Contact</strong></p>
                        <p>Villa N°125 Avenue Prince de Galle - Akwa - Douala - Cameroun | +237 678 12 12 32</p>
                    </div>
                </div>
            </body>
            </html>";
            
            // Alt body for non-HTML mail clients
            $mail->AltBody = "Nouveau message de contact CEMAC Trading\n\n";
            $mail->AltBody .= "Nom: $name\n";
            $mail->AltBody .= "Email: $email\n";
            $mail->AltBody .= "Message:\n$message\n\n";
            $mail->AltBody .= "Date: " . date('d/m/Y à H:i:s') . "\n";

            file_put_contents($logFile, "Email content prepared, attempting to send...\n", FILE_APPEND | LOCK_EX);
            
            $result = $mail->send();
            
            file_put_contents($logFile, "Send result: " . ($result ? "SUCCESS" : "FAILED") . "\n", FILE_APPEND | LOCK_EX);
            file_put_contents($logFile, str_repeat("=", 60) . "\n", FILE_APPEND | LOCK_EX);
            
            return $result;
            
        } catch (Exception $e) {
            $errorMsg = "EXCEPTION: " . $e->getMessage() . "\n";
            $errorMsg .= "File: " . $e->getFile() . "\n";
            $errorMsg .= "Line: " . $e->getLine() . "\n";
            $errorMsg .= "Stack trace:\n" . $e->getTraceAsString() . "\n";
            $errorMsg .= str_repeat("=", 60) . "\n";
            
            file_put_contents($logFile, $errorMsg, FILE_APPEND | LOCK_EX);
            error_log('PHPMailer Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send confirmation email to the person who submitted the form
     */
    private function sendConfirmationEmail($name, $email)
    {
        try {
            $mail = new PHPMailer(true);

            // Server settings - same as admin email
            $mail->isSMTP();
            $mail->Host       = Config::SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = Config::SMTP_USERNAME;
            $mail->Password   = Config::SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = Config::SMTP_PORT;

            // Recipients for confirmation
            $mail->setFrom(Config::SMTP_FROM_EMAIL, Config::SMTP_FROM_NAME);
            $mail->addAddress($email, $name); // Send to the person who submitted
            $mail->addReplyTo(Config::ADMIN_EMAILS[0], 'CEMAC Trading');

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = "✅ Confirmation de réception - CEMAC Trading";
            
            // HTML email body for confirmation
            $mail->Body = "
            <html>
            <head>
                <title>Confirmation de réception - CEMAC Trading</title>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
                    .header { background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; background: #f8f9ff; }
                    .info-card { background: white; border-radius: 8px; padding: 20px; margin: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                    .footer { background: #2c3e50; color: white; padding: 20px; text-align: center; font-size: 12px; }
                    .highlight { color: #27ae60; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>✅ Message bien reçu !</h1>
                    </div>
                    <div class='content'>
                        <div class='info-card'>
                            <p>Bonjour <strong>" . htmlspecialchars($name) . "</strong>,</p>
                            
                            <p>Nous vous confirmons la bonne réception de votre message envoyé le <span class='highlight'>" . date('d/m/Y à H:i') . "</span>.</p>
                            
                            <p>Notre équipe examinera votre demande et vous contactera dans les <strong>24 heures ouvrables</strong>.</p>
                            
                            <div style='background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                                <h3 style='margin-top: 0; color: #27ae60;'>📞 Besoin d'une réponse rapide ?</h3>
                                <p style='margin-bottom: 0;'>Contactez-nous directement au <strong>+237 678 12 12 32</strong> ou via WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                    <div class='footer'>
                        <p><strong>CEMAC Trading - Votre partenaire commercial</strong></p>
                        <p>Villa N°125 Avenue Prince de Galle - Akwa - Douala - Cameroun</p>
                        <p>📞 +237 678 12 12 32 | 📧 contact@cemactrading.com</p>
                    </div>
                </div>
            </body>
            </html>";
            
            // Alt body for confirmation
            $mail->AltBody = "Bonjour $name,\n\n";
            $mail->AltBody .= "Nous vous confirmons la bonne réception de votre message.\n";
            $mail->AltBody .= "Notre équipe vous contactera dans les 24 heures ouvrables.\n\n";
            $mail->AltBody .= "Pour une réponse rapide: +237 678 12 12 32\n\n";
            $mail->AltBody .= "CEMAC Trading\n";
            $mail->AltBody .= "Villa N°125 Avenue Prince de Galle - Akwa - Douala - Cameroun\n";

            return $mail->send();
            
        } catch (Exception $e) {
            error_log('Confirmation email error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * 404 Not Found page
     */
    public function notFound()
    {
        $this->renderView('404', [
            'title' => '404 - Page Not Found',
            'meta_description' => 'Page not found'
        ]);
    }
    
    /**
     * Generate sitemap
     */
    public function sitemap()
    {
        $baseUrl = Config::APP_URL;
        $languages = Config::SUPPORTED_LANGUAGES;
        
        $urls = [];
        $pages = ['', 'quotation', 'contact'];
        
        foreach ($languages as $lang) {
            foreach ($pages as $page) {
                $url = $baseUrl . '/' . $lang . ($page ? '/' . $page : '');
                $urls[] = [
                    'loc' => $url,
                    'lastmod' => date('Y-m-d'),
                    'changefreq' => $page === '' ? 'weekly' : 'monthly',
                    'priority' => $page === '' ? '1.0' : '0.8'
                ];
            }
        }
        
        include VIEWS_PATH . '/sitemap.php';
    }
    
    /**
     * Render a view with layout
     */
    private function renderView($view, $data = [])
    {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view
        include VIEWS_PATH . "/$view.php";
        
        // Get the content
        $content = ob_get_clean();
        
        // Include the layout
        include VIEWS_PATH . '/layout.php';
    }
}