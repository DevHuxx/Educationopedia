<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/auth_mod.php';
requireMod();

function h(?string $str): string {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

$db      = getDB();
$modId   = (int)$_SESSION['mod_id'];
$modName = (string)($_SESSION['mod_name'] ?: $_SESSION['mod_username'] ?: '');
$leadId  = (int)($_GET['lead_id'] ?? 0);
$currentTab = $_GET['tab'] ?? 'student_info';

$stmt = $db->prepare("SELECT * FROM leads WHERE id = ? AND assigned_to = ?");
$stmt->bind_param('ii', $leadId, $modId);
$stmt->execute();
$lead = $stmt->get_result()->fetch_assoc();

if (!$lead) {
    die("Lead not found or not assigned to you.");
}

$db->query("INSERT IGNORE INTO lead_details (lead_id) VALUES ($leadId)");

    
    if (isset($_POST['action']) && $_POST['action'] === 'upload_document') {
        $docName = (string)($_POST['doc_name'] ?? '');
        $uploadError = '';
        if ($docName && !empty($_FILES['document_file']['name']) && $_FILES['document_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['document_file'];
            $tmpPath = $file['tmp_name'];

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
            
            if (in_array($ext, $allowed)) {
                $filename = 'doc_' . $leadId . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $uploadDir = __DIR__ . '/../uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $destPath = $uploadDir . $filename;
                if (move_uploaded_file($tmpPath, $destPath)) {
                    $docUrl = '/backend/uploads/' . $filename;
                    $stmt = $db->prepare("INSERT INTO lead_documents (lead_id, doc_name, doc_url) VALUES (?, ?, ?)");
                    $stmt->bind_param('iss', $leadId, $docName, $docUrl);
                    if($stmt->execute()) {
                        $_SESSION['upload_success'] = 'Document uploaded successfully.';
                    }
                } else {
                    $_SESSION['upload_error'] = 'Failed to save file to server.';
                }
            } else {
                $_SESSION['upload_error'] = 'Invalid file format. Allowed: jpg, png, pdf, etc.';
            }
        }
        header("Location: admission.php?lead_id=$leadId&tab=documents");
        exit;
    }
    

    
    if (isset($_POST['action']) && $_POST['action'] === 'save_course') {
        $f_inst  = (string)($_POST['selected_institute'] ?? '');
        $f_fund  = (string)($_POST['funding_type'] ?? '');
        $f_exam  = (string)($_POST['entrance_exam_name'] ?? '');
        $f_score = (string)($_POST['entrance_score'] ?? '');
        
        $upd = $db->prepare("UPDATE lead_details SET selected_institute=?, funding_type=?, entrance_exam_name=?, entrance_score=? WHERE lead_id=?");
        $upd->bind_param('ssssi', $f_inst, $f_fund, $f_exam, $f_score, $leadId);
        if ($upd->execute()) {
            $_SESSION['upload_success'] = 'Course details updated successfully.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=course");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'add_academic') {
        $qual = (string)($_POST['qualification'] ?? '');
        $inst = (string)($_POST['institution'] ?? '');
        $year = (string)($_POST['passing_year'] ?? '');
        $perc = (string)($_POST['percentage'] ?? '');
        
        $stmt = $db->prepare("INSERT INTO lead_academic (lead_id, qualification, institution, passing_year, percentage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('issss', $leadId, $qual, $inst, $year, $perc);
        if ($stmt->execute()) {
            $_SESSION['upload_success'] = 'Academic qualification added.';
        } else {
            $_SESSION['upload_error'] = 'Error adding academic qualification.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=academic");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'delete_academic') {
        $acadId = (int)($_POST['acad_id'] ?? 0);
        $db->query("DELETE FROM lead_academic WHERE id = $acadId AND lead_id = $leadId");
        header("Location: admission.php?lead_id=$leadId&tab=academic");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'add_payment') {
        $amount = (float)($_POST['amount'] ?? 0);
        $date = (string)($_POST['payment_date'] ?? date('Y-m-d'));
        $mode = (string)($_POST['payment_mode'] ?? '');
        $notes = (string)($_POST['notes'] ?? '');
        $receipt = ''; 
        
        $stmt = $db->prepare("INSERT INTO lead_payments (lead_id, amount, payment_date, payment_mode, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('idsss', $leadId, $amount, $date, $mode, $notes);
        if ($stmt->execute()) {
            $_SESSION['upload_success'] = 'Payment recorded successfully.';
        } else {
            $_SESSION['upload_error'] = 'Error recording payment.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=payments");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'delete_payment') {
        $payId = (int)($_POST['pay_id'] ?? 0);
        $db->query("DELETE FROM lead_payments WHERE id = $payId AND lead_id = $leadId");
        header("Location: admission.php?lead_id=$leadId&tab=payments");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'save_course') {
        $f_inst  = (string)($_POST['selected_institute'] ?? '');
        $f_fund  = (string)($_POST['funding_type'] ?? '');
        $f_exam  = (string)($_POST['entrance_exam_name'] ?? '');
        $f_score = (string)($_POST['entrance_score'] ?? '');
        
        $upd = $db->prepare("UPDATE lead_details SET selected_institute=?, funding_type=?, entrance_exam_name=?, entrance_score=? WHERE lead_id=?");
        $upd->bind_param('ssssi', $f_inst, $f_fund, $f_exam, $f_score, $leadId);
        if ($upd->execute()) {
            $_SESSION['upload_success'] = 'Course details updated successfully.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=course");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'add_academic') {
        $qual = (string)($_POST['qualification'] ?? '');
        $inst = (string)($_POST['institution'] ?? '');
        $year = (string)($_POST['passing_year'] ?? '');
        $perc = (string)($_POST['percentage'] ?? '');
        
        $stmt = $db->prepare("INSERT INTO lead_academic (lead_id, qualification, institution, passing_year, percentage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('issss', $leadId, $qual, $inst, $year, $perc);
        if ($stmt->execute()) {
            $_SESSION['upload_success'] = 'Academic qualification added.';
        } else {
            $_SESSION['upload_error'] = 'Error adding academic qualification.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=academic");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'delete_academic') {
        $acadId = (int)($_POST['acad_id'] ?? 0);
        $db->query("DELETE FROM lead_academic WHERE id = $acadId AND lead_id = $leadId");
        header("Location: admission.php?lead_id=$leadId&tab=academic");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'add_payment') {
        $amount = (float)($_POST['amount'] ?? 0);
        $date = (string)($_POST['payment_date'] ?? date('Y-m-d'));
        $mode = (string)($_POST['payment_mode'] ?? '');
        $notes = (string)($_POST['notes'] ?? '');
        
        $stmt = $db->prepare("INSERT INTO lead_payments (lead_id, amount, payment_date, payment_mode, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('idsss', $leadId, $amount, $date, $mode, $notes);
        if ($stmt->execute()) {
            $_SESSION['upload_success'] = 'Payment recorded successfully.';
        } else {
            $_SESSION['upload_error'] = 'Error recording payment.';
        }
        header("Location: admission.php?lead_id=$leadId&tab=payments");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'delete_payment') {
        $payId = (int)($_POST['pay_id'] ?? 0);
        $db->query("DELETE FROM lead_payments WHERE id = $payId AND lead_id = $leadId");
        header("Location: admission.php?lead_id=$leadId&tab=payments");
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'delete_document') {
        $docId = (int)($_POST['doc_id'] ?? 0);
        $db->query("DELETE FROM lead_documents WHERE id = $docId AND lead_id = $leadId");
        header("Location: admission.php?lead_id=$leadId&tab=documents");
        exit;
    }

$toast = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['action'])) {
    $f_father   = (string)($_POST['father_name'] ?? '');
    $f_mother   = (string)($_POST['mother_name'] ?? '');
    $f_gender   = (string)($_POST['gender'] ?? 'Male');
    $f_alt      = (string)($_POST['alt_phone'] ?? '');
    $f_dob      = (string)($_POST['dob'] ?? '') ?: null;
    $f_nat      = (string)($_POST['nationality'] ?? 'India');
    $f_aadhar   = (string)($_POST['aadhar_number'] ?? '');
    $f_passport = (string)($_POST['passport_number'] ?? '');
    $f_address  = (string)($_POST['address'] ?? '');
    $f_country  = (string)($_POST['country_to_go'] ?? '');

    
    if ($f_country) {
        $updLead = $db->prepare("UPDATE leads SET country=? WHERE id=?");
        $updLead->bind_param('si', $f_country, $leadId);
        $updLead->execute();
    }
    $f_inst     = (string)($_POST['selected_institute'] ?? '');
    $f_fund     = (string)($_POST['funding_type'] ?? '');
    $f_exam     = (string)($_POST['entrance_exam_name'] ?? '');
    $f_score    = (string)($_POST['entrance_score'] ?? '');

    
    $photoPath   = (string)($_POST['existing_photo'] ?? '');
    $uploadError = '';
    if (!empty($_FILES['student_photo']['name']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
        $file    = $_FILES['student_photo'];
        $tmpPath = $file['tmp_name'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($ext, $allowed)) {
            $filename = 'photo_' . $leadId . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $destPath = $uploadDir . $filename;
            if (move_uploaded_file($tmpPath, $destPath)) {
                $photoPath = '/backend/uploads/' . $filename;
            } else {
                $_SESSION['upload_error'] = 'Failed to save photo to server.';
            }
        } else {
            $_SESSION['upload_error'] = 'Invalid photo format. Use JPG, PNG, etc.';
        }
    }

    $upd = $db->prepare("UPDATE lead_details SET 
        father_name=?, mother_name=?, gender=?, alt_phone=?, dob=?, nationality=?, 
        aadhar_number=?, passport_number=?, address=?, photo_path=?,
        selected_institute=?, funding_type=?, entrance_exam_name=?, entrance_score=? 
        WHERE lead_id=?");
    $upd->bind_param('ssssssssssssssi', 
        $f_father, $f_mother, $f_gender, $f_alt, $f_dob, $f_nat, 
        $f_aadhar, $f_passport, $f_address, $photoPath,
        $f_inst, $f_fund, $f_exam, $f_score, $leadId
    );
    $toast = $upd->execute() ? "Student details updated successfully." : "Error: " . $db->error;
    header("Location: admission.php?lead_id=$leadId&saved=1");
    exit;
}

$stmt = $db->prepare("SELECT * FROM lead_details WHERE lead_id = ?");
$stmt->bind_param('i', $leadId);
$stmt->execute();
$det = $stmt->get_result()->fetch_assoc() ?? [];

$d = [
    'father_name'          => (string)($det['father_name']          ?? ''),
    'mother_name'          => (string)($det['mother_name']          ?? ''),
    'gender'               => (string)($det['gender']               ?? 'Male'),
    'alt_phone'            => (string)($det['alt_phone']            ?? ''),
    'dob'                  => (string)($det['dob']                  ?? ''),
    'nationality'          => (string)($det['nationality']          ?? 'India'),
    'aadhar_number'        => (string)($det['aadhar_number']        ?? ''),
    'passport_number'      => (string)($det['passport_number']      ?? ''),
    'address'              => (string)($det['address']              ?? ''),
    'photo_path'           => (string)($det['photo_path']           ?? ''),
    'selected_institute'   => (string)($det['selected_institute']   ?? ''),
    'funding_type'         => (string)($det['funding_type']         ?? 'Self Funded'),
    'entrance_exam_name'   => (string)($det['entrance_exam_name']   ?? 'NEET'),
    'entrance_score'       => (string)($det['entrance_score']       ?? ''),
];

$leadName    = (string)($lead['name']    ?? '');
$leadPhone   = (string)($lead['phone']   ?? '');
$leadEmail   = (string)($lead['email']   ?? '');
$leadCountry = (string)($lead['country'] ?? '');
$leadCourse  = (string)($lead['course']  ?? '');

$toast       = isset($_GET['saved']) ? 'Student details updated successfully.' : '';
if(isset($_SESSION['upload_success'])){ $toast = $_SESSION['upload_success']; unset($_SESSION['upload_success']); }
$uploadError = '';
if (isset($_SESSION['upload_error'])) {
    $uploadError = $_SESSION['upload_error'];
    unset($_SESSION['upload_error']);
}

if ($d['photo_path'] && strpos($d['photo_path'], '/public/uploads/') === 0) {
    $uploadError = 'Photo is stored locally and cannot be displayed. Please re-upload to fix.';
}

$photoDisplay = $d['photo_path'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($leadName) . '&size=200&background=6366f1&color=fff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Admission — <?= h($leadName) ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', sans-serif; background: #f0f4f8; color: #334155; }
.top-nav { background: #fff; padding: 14px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.top-nav a { text-decoration: none; color: #6366f1; font-weight: 600; font-size: 14px; }
.container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }

/* ── Status Card ── */
.status-card { background: #fff; border: 2px solid #22c55e; border-radius: 12px; position: relative; margin-top: 30px; margin-bottom: 30px; padding: 24px; display: flex; gap: 20px; align-items: center; justify-content: space-between; flex-wrap: wrap; }
.status-badge { position: absolute; top: -16px; left: 50%; transform: translateX(-50%); background: #16a34a; color: white; padding: 6px 20px; border-radius: 20px; font-size: 14px; font-weight: bold; border: 2px solid #fff; }
.card-section { display: flex; align-items: center; gap: 16px; border-right: 1px dashed #cbd5e1; padding-right: 20px; flex: 1; min-width: 200px; }
.card-section:last-child { border-right: none; }
.card-photo { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; }
.card-text { font-size: 13px; color: #475569; line-height: 1.7; }
.card-text strong { color: #0f172a; }

/* ── Tabs ── */
.tabs-container { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; display: flex; overflow-x: auto; border-bottom: 3px solid #f97316; }
.tab { padding: 14px 20px; font-size: 13px; font-weight: bold; color: #64748b; text-transform: uppercase; cursor: pointer; white-space: nowrap; }
.tab.active { background: #f97316; color: #fff; border-radius: 8px 8px 0 0; }

/* ── Form Area ── */
.form-area { background: #fff; border: 1px solid #e2e8f0; border-top: none; padding: 24px; display: grid; grid-template-columns: 1fr 300px; gap: 30px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 4px; }
.form-group.full { grid-column: 1 / -1; }
label { display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; }
input, select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; font-size: 14px; color: #334155; outline: none; }
input:focus, select:focus, textarea:focus { border-color: #f97316; background: #fff; }

/* ── Photo Box ── */
.photo-box { border: 1px dashed #cbd5e1; border-radius: 8px; padding: 16px; text-align: center; background: #f8fafc; }
.photo-preview { width: 150px; height: 180px; object-fit: cover; border-radius: 8px; border: 2px solid #e2e8f0; margin: 10px auto; display: block; }
.catbox-note { font-size: 11px; color: #94a3b8; margin-top: 6px; }

/* ── Right Panel ── */
.right-panel { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-top: 16px; }
.info-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.info-table td { padding: 8px; border: 1px solid #cbd5e1; }
.info-table td:first-child { background: #e2e8f0; font-weight: 600; width: 45%; }

.btn { background: #16a34a; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px; }
.btn:hover { background: #15803d; }

.toast { position: fixed; top: 20px; right: 20px; background: #166534; color: #fff; padding: 12px 20px; border-radius: 8px; z-index: 100; animation: fadeIn .3s ease; }
@keyframes fadeIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }

@media(max-width: 900px) {
  .form-area { grid-template-columns: 1fr; }
  .card-section { border-right: none; border-bottom: 1px dashed #cbd5e1; padding-bottom: 16px; }
  .form-grid { grid-template-columns: 1fr; }
}

.doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 20px; background: #fff; border: 1px solid #e2e8f0; border-top: none; }
.doc-card { border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; background: #f8fafc; }
.doc-img { width: 100%; height: 250px; object-fit: cover; border-bottom: 1px solid #cbd5e1; background: #e2e8f0; }
.doc-info { padding: 10px; text-align: center; font-size: 13px; font-weight: bold; background: #64748b; color: white; }
.doc-actions { display: flex; gap: 10px; padding: 10px; justify-content: center; }
.btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 4px; border: none; cursor: pointer; color: white; text-decoration: none; display: inline-block; }
.btn-dl { background: #16a34a; }
.btn-del { background: #dc2626; }
.upload-bar { display: flex; gap: 15px; padding: 20px; background: #fff; border: 1px solid #e2e8f0; border-top: none; border-bottom: 1px dashed #cbd5e1; align-items: flex-end; }
</style>
</head>
<body>

<?php if ($toast): ?>
<div class="toast">✅ <?= h($toast) ?></div>
<script>setTimeout(() => document.querySelector('.toast')?.remove(), 3000);</script>
<?php endif; ?>

<?php if ($uploadError): ?>
<div class="toast" style="background:#b91c1c;">❌ <?= h($uploadError) ?></div>
<?php endif; ?>

<div class="top-nav">
  <a href="index.php">← Back to Leads</a>
  <div style="font-weight:bold;color:#334155;">Student ID: #<?= (int)$lead['id'] ?></div>
</div>

<div class="container">

  <div class="status-card">
    <div class="status-badge">✅ Admission Confirmed</div>

    <div class="card-section">
      <img src="<?= h($photoDisplay) ?>" class="card-photo" alt="Student Photo">
      <div class="card-text">
        <strong>👤 <?= h($leadName) ?></strong><br>
        📞 <?= h($leadPhone) ?><br>
        📧 <?= h($leadEmail) ?><br>
        📍 <?= h($d['address'] ?: $leadCountry ?: 'N/A') ?>
      </div>
    </div>

    <div class="card-section">
      <div class="card-text">
        Selected Course : <strong><?= h($leadCourse ?: 'N/A') ?></strong><br>
        Selected Country : <strong><?= h($leadCountry ?: 'N/A') ?></strong><br>
        Selected Institute : <strong><?= h($d['selected_institute'] ?: 'N/A') ?></strong><br>
        Course Funding Type : <strong><?= h($d['funding_type'] ?: 'Self Funded') ?></strong>
      </div>
    </div>

    <div class="card-section">
      <div class="card-text">
        Entrance Exam Name : <strong><?= h($d['entrance_exam_name'] ?: 'N/A') ?></strong><br>
        Entrance Rank/Score Obt. : <strong><?= h($d['entrance_score'] ?: 'N/A') ?></strong><br>
        Passport Number : <strong><?= h($d['passport_number'] ?: 'N/A') ?></strong><br>
        Aadhar Number : <strong><?= h($d['aadhar_number'] ?: 'N/A') ?></strong>
      </div>
    </div>
  </div>

  <div class="tabs-container">
    <a href="?lead_id=<?= $leadId ?>&tab=student_info" class="tab <?= $currentTab === 'student_info' ? 'active' : '' ?>">Student Info</a>
    <a href="?lead_id=<?= $leadId ?>&tab=academic" class="tab <?= $currentTab === 'academic' ? 'active' : '' ?>">Academic Qualification</a>
    <a href="?lead_id=<?= $leadId ?>&tab=course" class="tab <?= $currentTab === 'course' ? 'active' : '' ?>">Course Info</a>
    <a href="?lead_id=<?= $leadId ?>&tab=documents" class="tab <?= $currentTab === 'documents' ? 'active' : '' ?>">Document Locker</a>
    <a href="?lead_id=<?= $leadId ?>&tab=payments" class="tab <?= $currentTab === 'payments' ? 'active' : '' ?>">Payments Receipt</a>
    <a href="document_receipt.php?lead_id=<?= $leadId ?>" target="_blank" class="tab" style="color:#1d4ed8;">📄 Documents Receipt</a>
  </div>

  <?php if ($currentTab === 'student_info'): ?>
  <form method="POST" enctype="multipart/form-data" class="form-area">

    <div class="form-grid">
      <div class="form-group"><label>Student Name (read-only)</label><input type="text" value="<?= h($leadName) ?>" readonly></div>
      <div class="form-group"><label>Father Name</label><input type="text" name="father_name" value="<?= h($d['father_name']) ?>"></div>
      <div class="form-group"><label>Mother Name</label><input type="text" name="mother_name" value="<?= h($d['mother_name']) ?>"></div>
      <div class="form-group"><label>Gender</label>
        <select name="gender">
          <option <?= $d['gender']==='Male'?'selected':'' ?>>Male</option>
          <option <?= $d['gender']==='Female'?'selected':'' ?>>Female</option>
          <option <?= $d['gender']==='Other'?'selected':'' ?>>Other</option>
        </select>
      </div>
      <div class="form-group"><label>Contact No.</label><input type="text" value="<?= h($leadPhone) ?>" readonly></div>
      <div class="form-group"><label>Alternative Number</label><input type="text" name="alt_phone" value="<?= h($d['alt_phone']) ?>"></div>
      <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" value="<?= h($d['dob']) ?>"></div>
      <div class="form-group"><label>Nationality</label><input type="text" name="nationality" value="<?= h($d['nationality']) ?>"></div>
      <div class="form-group"><label>E-mail Id</label><input type="email" value="<?= h($leadEmail) ?>" readonly></div>
      <div class="form-group"><label>Aadhar Number</label><input type="text" name="aadhar_number" value="<?= h($d['aadhar_number']) ?>"></div>
      <div class="form-group"><label>Passport Number</label><input type="text" name="passport_number" value="<?= h($d['passport_number']) ?>"></div>
      <div class="form-group"><label>Country to Go</label><input type="text" name="country_to_go" value="<?= h($leadCountry) ?>" placeholder="e.g. Malaysia, Canada"></div>
      <div class="form-group"><label>Selected Institute</label><input type="text" name="selected_institute" value="<?= h($d['selected_institute']) ?>" placeholder="e.g. International Islamic University"></div>

      <div class="form-group full"><label>Address</label><textarea name="address" rows="3"><?= h($d['address']) ?></textarea></div>

      <div class="form-group full" style="margin-top:8px;">
        <button type="submit" class="btn">💾 Save Student Info</button>
      </div>
    </div>

    <div>
      <div class="photo-box">
        <label style="font-weight:700;font-size:13px;color:#334155;">Student Photo</label>
        <img src="<?= h($photoDisplay) ?>" class="photo-preview" id="photoPreview" alt="Student Photo">
        <input type="hidden" name="existing_photo" value="<?= h($d['photo_path']) ?>">
        <input type="file" name="student_photo" accept="image/*" style="font-size:12px;margin-top:10px;"
               onchange="previewPhoto(this)">
        <div class="catbox-note">📤 Photo is uploaded to Catbox CDN</div>
        <?php if ($d['photo_path']): ?>
          <div style="font-size:11px;margin-top:4px;word-break:break-all;color:#94a3b8;"><?= h($d['photo_path']) ?></div>
        <?php endif; ?>
      </div>

      <div class="right-panel">
        <div style="font-weight:700;font-size:13px;color:#0f172a;margin-bottom:8px;">Student Short Info</div>
        <table class="info-table">
          <tr><td>Student Name</td><td><?= h($leadName) ?></td></tr>
          <tr><td>Selected Course</td><td><?= h($leadCourse ?: '—') ?></td></tr>
          <tr><td>Selected Country</td><td><?= h($leadCountry ?: '—') ?></td></tr>
          <tr><td>Selected Coll/Uni.</td><td><?= h($d['selected_institute'] ?: '—') ?></td></tr>
        </table>

        <div style="font-weight:700;font-size:13px;color:#0f172a;margin:16px 0 8px;">Lead Short Info</div>
        <table class="info-table">
          <tr><td>Lead ID</td><td>#<?= (int)$lead['id'] ?></td></tr>
          <tr><td>Created On</td><td><?= date('d M Y', strtotime($lead['created_at'])) ?></td></tr>
          <tr><td>Assigned User</td><td><?= h($modName) ?></td></tr>
        </table>
      </div>
    </div>

  </form>
  <?php endif; ?>

  <?php if ($currentTab === 'course'): ?>
    <form method="POST" class="form-area">
        <input type="hidden" name="action" value="save_course">
        <div class="form-grid">
            <div class="form-group full"><h3 style="color:#1e293b; margin-bottom:10px;">Academic Course & Institute Preference</h3></div>
            
            <div class="form-group"><label>Selected Country</label><input type="text" value="<?= h($leadCountry) ?>" readonly></div>
            <div class="form-group"><label>Selected Course</label><input type="text" value="<?= h($leadCourse) ?>" readonly></div>

            <div class="form-group"><label>Selected Institute / College</label><input type="text" name="selected_institute" value="<?= h($d['selected_institute']) ?>" placeholder="e.g. International Islamic University"></div>
            <div class="form-group"><label>Funding Type</label><input type="text" name="funding_type" value="<?= h($d['funding_type']) ?>" placeholder="Self Funded / Scholarship"></div>
            <div class="form-group"><label>Entrance Exam Name</label><input type="text" name="entrance_exam_name" value="<?= h($d['entrance_exam_name']) ?>" placeholder="e.g. NEET"></div>
            <div class="form-group"><label>Entrance Score / Rank</label><input type="text" name="entrance_score" value="<?= h($d['entrance_score']) ?>" placeholder="e.g. 450"></div>
            
            <div class="form-group full" style="margin-top:10px;">
                <button type="submit" class="btn" style="background:#f97316;">💾 Save Course Info</button>
            </div>
        </div>
    </form>
  <?php endif; ?>

  <?php if ($currentTab === 'documents'): ?>
    <?php $docs = $db->query("SELECT * FROM lead_documents WHERE lead_id = $leadId")->fetch_all(MYSQLI_ASSOC); ?>
    
    <div style="background:#fff; border:1px solid #e2e8f0; border-top:none;">
        <form method="POST" enctype="multipart/form-data" class="upload-bar">
            <input type="hidden" name="action" value="upload_document">
            <div style="flex:1;">
                <label>Document Name (e.g. 10th Marks Card)</label>
                <input type="text" name="doc_name" required placeholder="Enter document name...">
            </div>
            <div style="flex:1;">
                <label>Document Upload</label>
                <input type="file" name="document_file" required accept="image/*,application/pdf">
            </div>
            <div>
                <button type="submit" class="btn" style="background:#f97316;">Upload Document</button>
            </div>
        </form>

        <div class="doc-grid">
            <?php foreach ($docs as $doc): ?>
            <div class="doc-card">
                <?php if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $doc['doc_url'])): ?>
                    <img src="<?= h($doc['doc_url']) ?>" class="doc-img">
                <?php else: ?>
                    <div class="doc-img" style="display:flex;align-items:center;justify-content:center;font-size:40px;color:#94a3b8;">📄</div>
                <?php endif; ?>
                <div class="doc-info"><?= h($doc['doc_name']) ?></div>
                <div class="doc-actions">
                    <a href="<?= h($doc['doc_url']) ?>" target="_blank" class="btn-sm btn-dl">⬇ Download</a>
                    <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this document?');">
                        <input type="hidden" name="action" value="delete_document">
                        <input type="hidden" name="doc_id" value="<?= $doc['id'] ?>">
                        <button type="submit" class="btn-sm btn-del">🗑</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($docs)): ?>
            <div style="grid-column: 1/-1; text-align:center; padding:40px; color:#64748b;">No documents uploaded yet.</div>
            <?php endif; ?>
        </div>
    </div>
  <?php endif; ?>

  <?php if ($currentTab === 'academic'): ?>
    <?php $academics = $db->query("SELECT * FROM lead_academic WHERE lead_id = $leadId ORDER BY passing_year ASC")->fetch_all(MYSQLI_ASSOC); ?>
    <div style="background:#fff; border:1px solid #e2e8f0; border-top:none; padding:20px;">
        <form method="POST" class="upload-bar" style="display:grid; grid-template-columns:1fr 1.5fr 1fr 1fr auto; gap:15px; align-items:end;">
            <input type="hidden" name="action" value="add_academic">
            <div>
                <label>Qualification</label>
                <input type="text" name="qualification" required placeholder="e.g. 12th Standard">
            </div>
            <div>
                <label>Institution / Board</label>
                <input type="text" name="institution" required placeholder="e.g. CBSE / State Board">
            </div>
            <div>
                <label>Passing Year</label>
                <input type="text" name="passing_year" required placeholder="YYYY">
            </div>
            <div>
                <label>Percentage / CGPA</label>
                <input type="text" name="percentage" required placeholder="e.g. 85%">
            </div>
            <div>
                <button type="submit" class="btn" style="background:#f97316;">Add Record</button>
            </div>
        </form>

        <table class="info-table" style="margin-top:20px;">
            <tr style="background:#e2e8f0;">
                <th>Qualification</th>
                <th>Institution</th>
                <th>Passing Year</th>
                <th>Percentage</th>
                <th style="width:50px;">Act.</th>
            </tr>
            <?php foreach ($academics as $acad): ?>
            <tr>
                <td><?= h($acad['qualification']) ?></td>
                <td><?= h($acad['institution']) ?></td>
                <td><?= h($acad['passing_year']) ?></td>
                <td><?= h($acad['percentage']) ?></td>
                <td style="text-align:center;">
                    <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this record?');">
                        <input type="hidden" name="action" value="delete_academic">
                        <input type="hidden" name="acad_id" value="<?= $acad['id'] ?>">
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:#dc2626; font-size:16px;">🗑</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($academics)): ?>
            <tr><td colspan="5" style="text-align:center; padding:20px; color:#64748b;">No academic records added yet.</td></tr>
            <?php endif; ?>
        </table>
    </div>
  <?php endif; ?>

  <?php if ($currentTab === 'payments'): ?>
    <?php $payments = $db->query("SELECT * FROM lead_payments WHERE lead_id = $leadId ORDER BY payment_date DESC")->fetch_all(MYSQLI_ASSOC); ?>
    <?php 
        $totalPaid = array_sum(array_column($payments, 'amount'));
    ?>
    <div style="background:#fff; border:1px solid #e2e8f0; border-top:none; padding:20px;">
        
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:15px; border-radius:8px; margin-bottom:20px; font-weight:bold; font-size:16px; color:#166534;">
            💰 Total Received: ₹<?= number_format($totalPaid, 2) ?>
        </div>

        <form method="POST" class="upload-bar" style="display:grid; grid-template-columns:1fr 1fr 1fr 2fr auto; gap:15px; align-items:end;">
            <input type="hidden" name="action" value="add_payment">
            <div>
                <label>Amount Received</label>
                <input type="number" step="0.01" name="amount" required placeholder="e.g. 50000">
            </div>
            <div>
                <label>Payment Date</label>
                <input type="date" name="payment_date" required value="<?= date('Y-m-d') ?>">
            </div>
            <div>
                <label>Payment Mode</label>
                <select name="payment_mode" required>
                    <option>Bank Transfer (NEFT/RTGS)</option>
                    <option>UPI</option>
                    <option>Cash</option>
                    <option>Cheque</option>
                    <option>Credit/Debit Card</option>
                </select>
            </div>
            <div>
                <label>Notes / Ref No.</label>
                <input type="text" name="notes" placeholder="Transaction ID, Cheque No, etc.">
            </div>
            <div>
                <button type="submit" class="btn" style="background:#16a34a;">Add Payment</button>
            </div>
        </form>

        <table class="info-table" style="margin-top:20px;">
            <tr style="background:#e2e8f0;">
                <th>Date</th>
                <th>Amount</th>
                <th>Mode</th>
                <th>Notes / Ref</th>
                <th style="width:50px;">Act.</th>
            </tr>
            <?php foreach ($payments as $pay): ?>
            <tr>
                <td><?= date('d M Y', strtotime($pay['payment_date'])) ?></td>
                <td style="font-weight:bold; color:#166534;">₹<?= number_format($pay['amount'], 2) ?></td>
                <td><?= h($pay['payment_mode']) ?></td>
                <td><?= h($pay['notes']) ?></td>
                <td style="text-align:center;">
                    <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this payment record?');">
                        <input type="hidden" name="action" value="delete_payment">
                        <input type="hidden" name="pay_id" value="<?= $pay['id'] ?>">
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:#dc2626; font-size:16px;">🗑</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($payments)): ?>
            <tr><td colspan="5" style="text-align:center; padding:20px; color:#64748b;">No payments recorded yet.</td></tr>
            <?php endif; ?>
        </table>
    </div>
  <?php endif; ?>

</div>

<script>
function previewPhoto(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</body>
</html>
