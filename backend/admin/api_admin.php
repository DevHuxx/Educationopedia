<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php'; require_once __DIR__ . '/auth.php'; initSession(); header("Access-Control-Allow-Origin: " . ($_SERVER['HTTP_ORIGIN'] ?? '*')); header("Access-Control-Allow-Credentials: true"); header("Access-Control-Allow-Methods: POST, OPTIONS"); header("Access-Control-Allow-Headers: Content-Type"); header("Content-Type: application/json; charset=utf-8"); if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; } 

$isMod = false;
$modRights = [];
if (!isAdmin()) { 
    require_once __DIR__ . '/../mod/auth_mod.php';
    session_write_close();
    if (!isMod()) {
        jsonError('Unauthorized — please login', 401);
    }
    $isMod = true;
    $db = getDB();
    try {
        $stmt = $db->prepare("SELECT university_rights, site_content_rights, exam_rights FROM mod_users WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $_SESSION['mod_id']);
            $stmt->execute();
            $modRights = $stmt->get_result()->fetch_assoc();
        }
    } catch (Exception $e) {
        $modRights = [];
    }
}

$action = $_GET['action'] ?? ''; 
$db = getDB(); 

if ($isMod) {
    $uniActions = ['add_university', 'delete_universities'];
    $contentActions = ['update_content', 'upload_image', 'delete_image', 'upload_gallery', 'delete_gallery', 'add_testimonial', 'delete_testimonials', 'add_blog', 'update_blog', 'delete_blog'];
    
    $allowed = false;
    if (!empty($modRights['university_rights']) && in_array($action, $uniActions)) $allowed = true;
    if (!empty($modRights['site_content_rights']) && in_array($action, $contentActions)) $allowed = true;
    
    if (!$allowed) {
        jsonError('You do not have permission to perform this action', 403);
    }
}

switch ($action) {case 'update_content': $input = json_decode(file_get_contents('php://input'), true); $section = $input['section'] ?? ''; $data = $input['data'] ?? []; if (!$section || !$data) jsonError('Section and data required'); $stmt = $db->prepare("INSERT INTO site_content (section, content_key, content_value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content_value = ?"); foreach ($data as $key => $value) { $stmt->bind_param('ssss', $section, $key, $value, $value); $stmt->execute(); } jsonResponse(['success' => 'Content updated successfully']); break; case 'upload_image': if (empty($_FILES['image'])) jsonError('No image uploaded'); $section = $_POST['section'] ?? 'hero_slides'; $file = $_FILES['image']; if ($file['error'] !== UPLOAD_ERR_OK) jsonError('Upload error'); if ($file['size'] > MAX_UPLOAD_SIZE) jsonError('File too large (max 20MB)'); $mime = mime_content_type($file['tmp_name']); if (!in_array($mime, ALLOWED_IMAGE_TYPES)) jsonError('Invalid image type'); $ext = pathinfo($file['name'], PATHINFO_EXTENSION); $filename = $section . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext; $destPath = UPLOAD_DIR . $filename; if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true); if (!move_uploaded_file($file['tmp_name'], $destPath)) jsonError('Failed to save file'); $imagePath = UPLOAD_URL . $filename; $altText = pathinfo($file['name'], PATHINFO_FILENAME); $sortOrder = 0; $imageKey = $section . '_' . time(); $stmt = $db->prepare("INSERT INTO site_images (section, image_key, image_path, alt_text, sort_order) VALUES (?, ?, ?, ?, ?)"); $stmt->bind_param('ssssi', $section, $imageKey, $imagePath, $altText, $sortOrder); $stmt->execute(); jsonResponse(['success' => 'Image uploaded', 'path' => $imagePath, 'id' => $db->insert_id]); break; case 'delete_image': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('Image ID required'); $stmt = $db->prepare("SELECT image_path FROM site_images WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); $row = $stmt->get_result()->fetch_assoc(); if ($row) { $filePath = __DIR__ . '/..' . $row['image_path']; if (file_exists($filePath)) unlink($filePath); } $stmt = $db->prepare("DELETE FROM site_images WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Image deleted']); break; case 'upload_gallery': if (empty($_FILES['image'])) jsonError('No image uploaded'); $file = $_FILES['image']; if ($file['error'] !== UPLOAD_ERR_OK) jsonError('Upload error'); if ($file['size'] > MAX_UPLOAD_SIZE) jsonError('File too large (max 20MB)'); $ext = pathinfo($file['name'], PATHINFO_EXTENSION); $filename = 'gallery_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext; $destPath = UPLOAD_DIR . $filename; if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true); if (!move_uploaded_file($file['tmp_name'], $destPath)) jsonError('Failed to save file'); $imagePath = UPLOAD_URL . $filename; $altText = pathinfo($file['name'], PATHINFO_FILENAME); $stmt = $db->prepare("INSERT INTO gallery_images (image_path, alt_text) VALUES (?, ?)"); $stmt->bind_param('ss', $imagePath, $altText); $stmt->execute(); jsonResponse(['success' => 'Gallery image uploaded', 'path' => $imagePath]); break; case 'delete_gallery': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("SELECT image_path FROM gallery_images WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); $row = $stmt->get_result()->fetch_assoc(); if ($row) { $filePath = __DIR__ . '/..' . $row['image_path']; if (file_exists($filePath)) unlink($filePath); } $stmt = $db->prepare("DELETE FROM gallery_images WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Gallery image deleted']); break; case 'add_testimonial': $input = json_decode(file_get_contents('php://input'), true); $name = $input['name'] ?? ''; $course = $input['course'] ?? ''; $text = $input['text'] ?? ''; $rating = (int)($input['rating'] ?? 5); $sortOrder = (int)($input['sort_order'] ?? 0); if (!$name || !$text) jsonError('Name and text required'); $stmt = $db->prepare("INSERT INTO testimonials (name, course, text, rating, sort_order) VALUES (?, ?, ?, ?, ?)"); $stmt->bind_param('sssii', $name, $course, $text, $rating, $sortOrder); $stmt->execute(); jsonResponse(['success' => 'Testimonial added', 'id' => $db->insert_id]); break; case 'delete_testimonials': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("DELETE FROM testimonials WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Testimonial deleted']); break; case 'add_blog': $input = json_decode(file_get_contents('php://input'), true); $title = $input['title'] ?? ''; $excerpt = $input['excerpt'] ?? ''; $content = $input['content'] ?? ''; $category = $input['category'] ?? ''; $readTime = $input['read_time'] ?? ''; $imagePath = $input['image_path'] ?? ''; $publishedAt = date('Y-m-d'); if (!$title) jsonError('Title required'); $stmt = $db->prepare("INSERT INTO blog_posts (title, excerpt, content, category, read_time, image_path, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)"); $stmt->bind_param('sssssss', $title, $excerpt, $content, $category, $readTime, $imagePath, $publishedAt); $stmt->execute(); jsonResponse(['success' => 'Blog post added', 'id' => $db->insert_id]); break; case 'update_blog': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); $title = $input['title'] ?? ''; $excerpt = $input['excerpt'] ?? ''; $content = $input['content'] ?? ''; $category = $input['category'] ?? ''; $readTime = $input['read_time'] ?? ''; $imagePath = $input['image_path'] ?? ''; if (!$id || !$title) jsonError('ID and Title required'); $stmt = $db->prepare("UPDATE blog_posts SET title = ?, excerpt = ?, content = ?, category = ?, read_time = ?, image_path = ? WHERE id = ?"); $stmt->bind_param('ssssssi', $title, $excerpt, $content, $category, $readTime, $imagePath, $id); if ($stmt->execute()) { if ($stmt->affected_rows > 0 || $db->errno === 0) { jsonResponse(['success' => 'Blog post updated']); } else { jsonError('No changes were made or Post ID not found'); } } else { jsonError('DB Error: ' . $db->error); } $stmt->close(); break; case 'delete_blog': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Blog post deleted']); break; case 'add_university': $input = json_decode(file_get_contents('php://input'), true); $country = $input['country'] ?? ''; $rank = (int)($input['rank'] ?? 0); $name = $input['name'] ?? ''; $shortName = $input['short_name'] ?? ''; $city = $input['city'] ?? ''; $flag = $input['flag'] ?? ''; $rating = (float)($input['rating'] ?? 4.5); $rankingText = $input['ranking_text'] ?? ''; $cutoff = $input['cutoff'] ?? ''; $deadline = $input['deadline'] ?? ''; $fees = $input['fees'] ?? ''; if (!$country || !$name) jsonError('Country and name required'); $stmt = $db->prepare("INSERT INTO universities (country, `rank`, name, short_name, city, flag, rating, ranking_text, cutoff, deadline, fees) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); $stmt->bind_param('sissssdssss', $country, $rank, $name, $shortName, $city, $flag, $rating, $rankingText, $cutoff, $deadline, $fees); $stmt->execute(); jsonResponse(['success' => 'University added', 'id' => $db->insert_id]); break; case 'delete_universities': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("DELETE FROM universities WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'University deleted']); break; case 'list_leads': $status = $_GET['status'] ?? ''; $modFilter = (int)($_GET['mod_id'] ?? 0); $sql = "SELECT l.*, mu.username as mod_username, mu.full_name as mod_name 
                FROM leads l 
                LEFT JOIN mod_users mu ON mu.id = l.assigned_to"; $conditions = []; if ($status) $conditions[] = "l.status = '" . $db->real_escape_string($status) . "'"; if ($modFilter) $conditions[] = "l.assigned_to = $modFilter"; if ($conditions) $sql .= " WHERE " . implode(' AND ', $conditions); $sql .= " ORDER BY l.created_at DESC"; $result = $db->query($sql); $leads = []; while ($row = $result->fetch_assoc()) $leads[] = $row; jsonResponse($leads); break; case 'lead_detail': $id = (int)($_GET['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("SELECT l.*, mu.username as mod_username, mu.full_name as mod_name 
                               FROM leads l LEFT JOIN mod_users mu ON mu.id = l.assigned_to WHERE l.id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); $lead = $stmt->get_result()->fetch_assoc(); if (!$lead) jsonError('Lead not found', 404); $r = $db->prepare("SELECT lr.*, mu2.username as mod_username FROM lead_remarks lr 
                            LEFT JOIN mod_users mu2 ON mu2.id = lr.mod_id                            WHERE lr.lead_id = ? ORDER BY lr.created_at ASC"); $r->bind_param('i', $id); $r->execute(); $lead['remarks'] = $r->get_result()->fetch_all(MYSQLI_ASSOC); jsonResponse($lead); break; case 'assign_lead': $input = json_decode(file_get_contents('php://input'), true); $leadId = (int)($input['lead_id'] ?? 0); $modId = ($input['mod_id'] === '' || $input['mod_id'] === null) ? null : (int)$input['mod_id']; if (!$leadId) jsonError('lead_id required'); $stmt = $db->prepare("UPDATE leads SET assigned_to = ? WHERE id = ?"); $stmt->bind_param('ii', $modId, $leadId); $stmt->execute(); jsonResponse(['success' => 'Lead assigned']); break; case 'list_mods': $result = $db->query("SELECT id, username, full_name, email, active, created_at FROM mod_users ORDER BY created_at DESC"); $mods = []; while ($row = $result->fetch_assoc()) $mods[] = $row; jsonResponse($mods); break; case 'create_mod': require_once __DIR__ . '/auth.php'; $input = json_decode(file_get_contents('php://input'), true); $username = trim($input['username'] ?? ''); $password = trim($input['password'] ?? ''); $fullName = trim($input['full_name'] ?? ''); $email = trim($input['email'] ?? ''); if (!$username || !$password) jsonError('Username and password required'); if (strlen($password) < 6) jsonError('Password must be at least 6 characters'); $secret = TOTP::generateSecret(); $hash = password_hash($password, PASSWORD_BCRYPT); $stmt = $db->prepare("INSERT INTO mod_users (username, password_hash, totp_secret, full_name, email) VALUES (?, ?, ?, ?, ?)"); $stmt->bind_param('sssss', $username, $hash, $secret, $fullName, $email); if (!$stmt->execute()) { if ($db->errno === 1062) jsonError('Username already exists'); jsonError('Failed to create mod user'); } $qrUrl = TOTP::getQRCodeUrl($username . ' (Mod)', $secret, 'Educationopedia'); jsonResponse(['success' => true, 'totp_secret' => $secret, 'qr_url' => $qrUrl, 'id' => $db->insert_id]); break; case 'toggle_mod': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $stmt = $db->prepare("UPDATE mod_users SET active = 1 - active WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Mod status toggled']); break; case 'toggle_mod_right': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); $right = $input['right'] ?? ''; if (!$id) jsonError('ID required'); $allowedRights = ['university_rights', 'site_content_rights', 'exam_rights']; if (!in_array($right, $allowedRights)) jsonError('Invalid right'); $stmt = $db->prepare("UPDATE mod_users SET `$right` = 1 - IFNULL(`$right`, 0) WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Mod right updated']); break; case 'delete_lead': $input = json_decode(file_get_contents('php://input'), true); $id = (int)($input['id'] ?? 0); if (!$id) jsonError('ID required'); $db->prepare("DELETE FROM lead_remarks WHERE lead_id = ?")->bind_param('i', $id) && $db->execute(); $stmt = $db->prepare("DELETE FROM leads WHERE id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); jsonResponse(['success' => 'Lead deleted']); break;

case 'set_reminder':
    $input  = json_decode(file_get_contents('php://input'), true);
    $leadId = (int)($input['lead_id'] ?? 0);
    $remAt  = trim($input['reminder_at'] ?? '');
    if (!$leadId) jsonError('lead_id required');
    if ($remAt) {
        
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $remAt);
        if (!$dt) $dt = DateTime::createFromFormat('Y-m-d H:i:s', $remAt);
        if (!$dt) jsonError('Invalid datetime format. Use YYYY-MM-DDTHH:MM');
        $remAt = $dt->format('Y-m-d H:i:s');
        $stmt = $db->prepare("UPDATE leads SET reminder_at = ? WHERE id = ?");
        $stmt->bind_param('si', $remAt, $leadId);
    } else {
        $stmt = $db->prepare("UPDATE leads SET reminder_at = NULL, pinned = 0 WHERE id = ?");
        $stmt->bind_param('i', $leadId);
    }
    $stmt->execute();
    jsonResponse(['success' => 'Reminder set', 'reminder_at' => $remAt]);
    break;

case 'pin_due_reminders':
    $db->query("UPDATE leads SET pinned = 1 WHERE reminder_at IS NOT NULL AND reminder_at <= NOW() AND pinned = 0");
    jsonResponse(['pinned' => $db->affected_rows]);
    break;

case 'unpin_lead':
    $input  = json_decode(file_get_contents('php://input'), true);
    $leadId = (int)($input['lead_id'] ?? 0);
    if (!$leadId) jsonError('lead_id required');
    $stmt = $db->prepare("UPDATE leads SET pinned = 0, reminder_at = NULL WHERE id = ?");
    $stmt->bind_param('i', $leadId);
    $stmt->execute();
    jsonResponse(['success' => 'Unpinned']);
    break;

case 'add_lead':
    $input   = json_decode(file_get_contents('php://input'), true);
    $name    = trim($input['name']    ?? '');
    $email   = trim($input['email']   ?? '');
    $phone   = trim($input['phone']   ?? '');
    $country = trim($input['country'] ?? '');
    $course  = trim($input['course']  ?? '');
    $message = trim($input['message'] ?? '');
    if (!$name || !$phone) jsonError('Name and phone are required');
    $stmt = $db->prepare("INSERT INTO leads (name, email, phone, country, course, message, status) VALUES (?, ?, ?, ?, ?, ?, 'new')");
    $stmt->bind_param('ssssss', $name, $email, $phone, $country, $course, $message);
    $stmt->execute();
    jsonResponse(['success' => 'Lead added', 'id' => $db->insert_id]);
    break;

case 'import_leads_csv':
    if (empty($_FILES['csv'])) jsonError('No CSV file uploaded');
    $file = $_FILES['csv'];
    if ($file['error'] !== UPLOAD_ERR_OK) jsonError('Upload error code: ' . $file['error']);
    $handle = fopen($file['tmp_name'], 'r');
    if (!$handle) jsonError('Cannot read file');
    $headers = array_map('strtolower', array_map('trim', fgetcsv($handle)));
    $colMap = [];
    $allowed = ['name','email','phone','country','course','message'];
    foreach ($headers as $i => $h) { if (in_array($h, $allowed)) $colMap[$h] = $i; }
    if (!isset($colMap['name']) || !isset($colMap['phone'])) {
        fclose($handle);
        jsonError('CSV must have at least "name" and "phone" columns in the header row');
    }
    $stmt = $db->prepare("INSERT IGNORE INTO leads (name, email, phone, country, course, message, status) VALUES (?, ?, ?, ?, ?, ?, 'new')");
    $imported = 0; $skipped = 0;
    while (($row = fgetcsv($handle)) !== false) {
        $n = trim($row[$colMap['name']] ?? '');
        $p = trim($row[$colMap['phone']] ?? '');
        if (!$n || !$p) { $skipped++; continue; }
        $e = trim($row[$colMap['email']   ?? -1] ?? '');
        $c = trim($row[$colMap['country'] ?? -1] ?? '');
        $co= trim($row[$colMap['course']  ?? -1] ?? '');
        $m = trim($row[$colMap['message'] ?? -1] ?? '');
        $stmt->bind_param('ssssss', $n, $e, $p, $c, $co, $m);
        $stmt->execute();
        if ($db->affected_rows > 0) $imported++; else $skipped++;
    }
    fclose($handle);
    jsonResponse(['success' => true, 'imported' => $imported, 'skipped' => $skipped]);
    break;

default: jsonError('Unknown action: ' . $action, 400); }
