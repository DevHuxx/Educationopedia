<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { ob_end_clean(); exit(0); }

require 'config.php';
$db = getDB();

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true) ?? [];

function sendJson($payload) {
    ob_end_clean();
    echo json_encode($payload);
    exit;
}

if ($action === 'register') {
    $name           = trim($data['name'] ?? '');
    $email          = trim($data['email'] ?? '');
    $phone          = trim($data['phone'] ?? '');
    $father_name    = trim($data['father_name'] ?? '');
    $father_phone   = trim($data['father_phone'] ?? '');
    $dob            = trim($data['dob'] ?? '');
    $city           = trim($data['city'] ?? '');
    $state          = trim($data['state'] ?? '');
    $class_comp     = trim($data['class_completed'] ?? '');
    $neet_status    = trim($data['neet_status'] ?? '');
    $neet_score     = trim($data['neet_score'] ?? '');
    $target_country = trim($data['target_country'] ?? '');
    $target_course  = trim($data['target_course'] ?? '');
    $photo_base64   = $data['photo_base64'] ?? '';

    if (!$name || !$email || !$phone) {
        sendJson(['success' => false, 'error' => 'All fields are required.']);
    }

    $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

    $photo_path = null;
    if ($photo_base64 && strpos($photo_base64, 'data:image') === 0) {
        $upload_dir = __DIR__ . '/uploads/exam_photos/';
        if (!is_dir($upload_dir)) @mkdir($upload_dir, 0755, true);
        $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo_base64));
        $filename = 'candidate_' . time() . '_' . rand(1000, 9999) . '.jpg';
        if ($img_data && @file_put_contents($upload_dir . $filename, $img_data)) {
            $photo_path = '/backend/uploads/exam_photos/' . $filename;
        }
    }

    $sql = "INSERT INTO exam_candidates
        (name, email, phone, password, father_name, father_phone, dob, city, state,
         class_completed, neet_status, neet_score, target_country, target_course, photo_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($sql);
    if (!$stmt) {
        sendJson(['success' => false, 'error' => 'Prepare failed: ' . $db->error]);
    }

    $stmt->bind_param(
        'sssssssssssssss',
        $name, $email, $phone, $password,
        $father_name, $father_phone, $dob, $city, $state,
        $class_comp, $neet_status, $neet_score,
        $target_country, $target_course, $photo_path
    );

    try {
        if (!$stmt->execute()) {
            sendJson(['success' => false, 'error' => 'Email already registered or Execute failed.']);
        }
    } catch (\mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            sendJson(['success' => false, 'error' => 'This email address is already registered.']);
        } else {
            sendJson(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } catch (\Exception $e) {
        sendJson(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()]);
    }

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
            
            $mail->setFrom('exams@educationopedia.com', 'Educationopedia Exams');
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Your Scholarship Exam Credentials by Educationopedia';
            $mail->Body = "<div style='font-family:sans-serif;max-width:500px;margin:auto;'>
                <h2 style='color:#4f46e5;'>Hello $name,</h2>
                <p>Your registration for the <strong>Educationopedia Scholarship Exam</strong> is successful!</p>
                <div style='background:#f0f0ff;border-radius:12px;padding:20px;margin:20px 0;'>
                    <p style='margin:0 0 8px;'><b>Email:</b> $email</p>
                    <p style='margin:0;font-size:20px;'><b>Password:</b> <span style='color:#4f46e5;letter-spacing:2px;'>$password</span></p>
                </div>
                <a href='https://educationopedia.com/exam/login' style='display:inline-block;background:#4f46e5;color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:bold;'>Start Exam &rarr;</a>
                <p style='color:#888;font-size:12px;margin-top:20px;'>Educationopedia Team</p>
            </div>";
            $mail->send();
        } catch (\Exception $e) {
        }
    }

    sendJson(['success' => true, 'message' => 'Registration successful! Check your email for credentials.']);

} elseif ($action === 'login') {
    $email    = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');
    $stmt = $db->prepare("SELECT id, name, status, start_time FROM exam_candidates WHERE email = ? AND password = ?");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user) {
        if ($user['status'] === 'completed') {
            sendJson(['success' => false, 'error' => 'You have already completed the exam.']);
        }
        if ($user['status'] === 'registered') {
            $db->query("UPDATE exam_candidates SET status = 'started', start_time = NOW() WHERE id = " . (int)$user['id']);
            $user['status'] = 'started';
            $user['start_time'] = date('Y-m-d H:i:s');
            $user['time_left'] = 30 * 60;
        } elseif ($user['status'] === 'started') {
            $elapsed = time() - strtotime($user['start_time']);
            $remaining = (30 * 60) - $elapsed;
            if ($remaining <= 0) {
                $db->query("UPDATE exam_candidates SET status = 'completed', end_time = NOW() WHERE id = " . (int)$user['id']);
                sendJson(['success' => false, 'error' => 'Your exam time has expired.']);
            }
            $user['time_left'] = $remaining;
        }
        sendJson(['success' => true, 'user' => $user]);
    } else {
        sendJson(['success' => false, 'error' => 'Invalid email or password.']);
    }

} elseif ($action === 'get_questions') {
    $res = $db->query("SELECT id, question_text, opt_a, opt_b, opt_c, opt_d FROM exam_questions ORDER BY id ASC");
    sendJson(['success' => true, 'questions' => $res->fetch_all(MYSQLI_ASSOC)]);

} elseif ($action === 'submit_exam') {
    $user_id = (int)($data['user_id'] ?? 0);
    $answers = $data['answers'] ?? [];
    if (!$user_id || empty($answers)) {
        sendJson(['success' => false, 'error' => 'Invalid submission data.']);
    }
    $userCheck = $db->query("SELECT status FROM exam_candidates WHERE id = $user_id")->fetch_assoc();
    if ($userCheck['status'] === 'completed') {
        sendJson(['success' => false, 'error' => 'Exam already submitted.']);
    }
    $score = 0;
    $res = $db->query("SELECT id, correct_opt FROM exam_questions");
    $correct = [];
    while ($row = $res->fetch_assoc()) $correct[$row['id']] = $row['correct_opt'];

    $db->begin_transaction();
    try {
        $stmt = $db->prepare("INSERT INTO exam_responses (candidate_id, question_id, selected_opt) VALUES (?, ?, ?)");
        foreach ($answers as $q_id => $opt) {
            $q_id = (int)$q_id;
            $opt  = strtoupper((string)$opt);
            if (isset($correct[$q_id]) && $correct[$q_id] === $opt) $score++;
            $stmt->bind_param('iis', $user_id, $q_id, $opt);
            $stmt->execute();
        }
        $db->query("UPDATE exam_candidates SET score = $score, status = 'completed', end_time = NOW() WHERE id = $user_id");
        $db->commit();
        sendJson(['success' => true, 'score' => $score]);
    } catch (Exception $e) {
        $db->rollback();
        sendJson(['success' => false, 'error' => 'Database error while saving answers.']);
    }

} else {
    sendJson(['success' => false, 'error' => 'Invalid action.']);
}
