<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/config.php'; 
setCorsHeaders(); 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    jsonError('Method not allowed', 405); 
} 

$input = json_decode(file_get_contents('php://input'), true); 
$name = trim($input['name'] ?? ''); 
$email = trim($input['email'] ?? ''); 
$phone = trim($input['phone'] ?? ''); 
$country = trim($input['country'] ?? ''); 
$course = trim($input['course'] ?? ''); 
$message = trim($input['message'] ?? ''); 
$source = trim($input['source'] ?? '');

if (!$name || !$email || !$phone) { 
    jsonError('Name, email and phone are required'); 
} 

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
    jsonError('Invalid email address'); 
} 

$db = getDB(); 
$stmt = $db->prepare("INSERT INTO leads (name, email, phone, country, course, message) VALUES (?, ?, ?, ?, ?, ?)"); 
$stmt->bind_param('ssssss', $name, $email, $phone, $country, $course, $message); 

if ($stmt->execute()) { 
    
    
    if ($source === 'landing_ads') {
        $exc = __DIR__ . '/lib/PHPMailer/Exception.php';
        $php = __DIR__ . '/lib/PHPMailer/PHPMailer.php';
        $smt = __DIR__ . '/lib/PHPMailer/SMTP.php';
        
        if (file_exists($exc) && file_exists($php) && file_exists($smt)) {
            require_once $exc;
            require_once $php;
            require_once $smt;
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host        = 'localhost';
                $mail->SMTPAuth    = false;
                $mail->SMTPAutoTLS = false;
                $mail->Port        = 25;
                $mail->Timeout     = 5;
                
                $mail->setFrom('admissions@educationopedia.com', 'Educationopedia Admissions');
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = 'Application Successful - Educationopedia 2026';
                $mail->Body = "<div style='font-family:sans-serif;max-width:500px;margin:auto;'>
                    <h2 style='color:#ea580c;'>Hello $name,</h2>
                    <p>Thank you for your interest in studying MBBS abroad! Your application for the <strong>2026 intake</strong> has been successfully registered with us.</p>
                    <p>Our admission counselors will review your profile and contact you shortly on <strong>$phone</strong> to discuss your scholarship options and the next steps.</p>
                    <p>If you have urgent questions, feel free to call us at +91 91161 11639.</p>
                    <br/>
                    <p>Best Regards,<br/><strong>The Educationopedia Team</strong></p>
                </div>";
                $mail->send();
            } catch (Exception $e) {
                
            }
        }
    }

    jsonResponse(['success' => true, 'message' => 'Your enquiry has been submitted. We will contact you shortly.']); 
} else { 
    jsonError('Failed to save enquiry. Please try again.', 500); 
}
