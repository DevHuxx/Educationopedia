<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth.php';
initSession();

$db = getDB();
$canEdit = false;
if (isAdmin()) {
    $canEdit = true;
} else {
    require_once __DIR__ . '/../mod/auth_mod.php';
    session_write_close();
    if (!isMod()) {
        header('Location: login.php');
        exit;
    }
    
    $stmt = $db->prepare("SELECT university_rights FROM mod_users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['mod_id']);
    $stmt->execute();
    $mod = $stmt->get_result()->fetch_assoc();
    if (!empty($mod['university_rights'])) {
        $canEdit = true;
    }
}

if (!$canEdit) {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    echo "No university ID provided.";
    exit;
}

$stmt = $db->prepare("SELECT * FROM universities WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { echo "University not found."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $shortName = $_POST['short_name'] ?? '';
    $country = $_POST['country'] ?? '';
    $city = $_POST['city'] ?? '';
    $rank = (int)($_POST['rank'] ?? 99999);
    $rating = (float)($_POST['rating'] ?? 4.5);
    $fees = $_POST['fees'] ?? '';
    
    
    $imagePath = $u['image_path'] ?? '';
    if (!empty($_FILES['university_image']['tmp_name'])) {
        $file = $_FILES['university_image'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'university_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0755, true);
            }
            if (move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $filename)) {
                $imagePath = UPLOAD_URL . $filename;
            }
        }
    }
    
    
    $establishedYear = $_POST['established_year'] ?? '';
    $ieltsPteToefl = $_POST['ielts_pte_toefl'] ?? '';
    $affiliatedBy = $_POST['affiliated_by'] ?? '';
    $neetExamination = $_POST['neet_examination'] ?? '';
    $universityType = $_POST['university_type'] ?? '';
    $intakeSessions = $_POST['intake_sessions'] ?? '';
    $universityGrade = $_POST['university_grade'] ?? '';
    $eligibilityCriteria = $_POST['eligibility_criteria'] ?? '';
    $worldRanking = $_POST['world_ranking'] ?? '';
    $countryRanking = $_POST['country_ranking'] ?? '';
    $teachingMedium = $_POST['teaching_medium'] ?? '';
    $airportDistance = $_POST['airport_distance'] ?? '';
    $teachingFaculty = $_POST['teaching_faculty'] ?? '';
    $whoFaimer = $_POST['who_faimer'] ?? '';
    $globalStudents = $_POST['global_students'] ?? '';
    $nmcEcfmg = $_POST['nmc_ecfmg'] ?? '';
    $hostelLocation = $_POST['hostel_location'] ?? '';
    
    
    $tuition_usd = (float)($_POST['tuition_usd'] ?? 0);
    $tuition_inr = (float)($_POST['tuition_inr'] ?? 0);
    $tuition_rub = (float)($_POST['tuition_rub'] ?? 0);
    $hostel_usd = (float)($_POST['hostel_usd'] ?? 0);
    $hostel_inr = (float)($_POST['hostel_inr'] ?? 0);
    $hostel_rub = (float)($_POST['hostel_rub'] ?? 0);
    $food_usd = (float)($_POST['food_usd'] ?? 0);
    $food_inr = (float)($_POST['food_inr'] ?? 0);
    $food_rub = (float)($_POST['food_rub'] ?? 0);
    $medical_usd = (float)($_POST['medical_usd'] ?? 0);
    $medical_inr = (float)($_POST['medical_inr'] ?? 0);
    $medical_rub = (float)($_POST['medical_rub'] ?? 0);
    $otc_usd = (float)($_POST['otc_usd'] ?? 0);
    $otc_inr = (float)($_POST['otc_inr'] ?? 0);
    $otc_rub = (float)($_POST['otc_rub'] ?? 0);

    $stmt = $db->prepare("UPDATE universities SET 
        name=?, short_name=?, country=?, city=?, `rank`=?, rating=?, fees=?, image_path=?,
        established_year=?, ielts_pte_toefl=?, affiliated_by=?, neet_examination=?, university_type=?, intake_sessions=?, university_grade=?, eligibility_criteria=?, world_ranking=?, country_ranking=?, teaching_medium=?, airport_distance=?, teaching_faculty=?, who_faimer=?, global_students=?, nmc_ecfmg=?, hostel_location=?,
        tuition_usd=?, tuition_inr=?, tuition_rub=?, hostel_usd=?, hostel_inr=?, hostel_rub=?, food_usd=?, food_inr=?, food_rub=?, medical_usd=?, medical_inr=?, medical_rub=?, otc_usd=?, otc_inr=?, otc_rub=?
        WHERE id=?");
        
    $stmt->bind_param('ssssidsssssssssssssssssssdddddddddddddddi', 
        $name, $shortName, $country, $city, $rank, $rating, $fees, $imagePath,
        $establishedYear, $ieltsPteToefl, $affiliatedBy, $neetExamination, $universityType, $intakeSessions, $universityGrade, $eligibilityCriteria, $worldRanking, $countryRanking, $teachingMedium, $airportDistance, $teachingFaculty, $whoFaimer, $globalStudents, $nmcEcfmg, $hostelLocation,
        $tuition_usd, $tuition_inr, $tuition_rub, $hostel_usd, $hostel_inr, $hostel_rub, $food_usd, $food_inr, $food_rub, $medical_usd, $medical_inr, $medical_rub, $otc_usd, $otc_inr, $otc_rub,
        $id
    );
    
    if($stmt->execute()) {
        header("Location: university_detail.php?id=" . $id . "&success=1");
        exit;
    } else {
        $error = "Error updating university: " . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit <?= htmlspecialchars($u['name']) ?></title>
<link rel="stylesheet" href="assets/style.css" />
<style>
  body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; padding: 20px; color: #334155; }
  .edit-container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
  h1 { font-size: 24px; color: #0f172a; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
  .form-section { margin-bottom: 30px; }
  .form-section h3 { background: #f1f5f9; padding: 10px; border-radius: 6px; font-size: 16px; margin-bottom: 15px; color: #475569; }
  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
  .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
  .form-group { display: flex; flex-direction: column; gap: 5px; }
  label { font-size: 13px; font-weight: 600; color: #64748b; }
  input[type="text"], input[type="number"] { padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; }
  .actions { margin-top: 30px; display: flex; gap: 15px; }
  .btn { padding: 10px 20px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; }
  .btn-primary { background: #0ea5e9; color: white; }
  .btn-secondary { background: #64748b; color: white; }
  .alert { padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; }
</style>
</head>
<body>

<div class="edit-container">
    <h1>✏️ Edit University: <?= htmlspecialchars($u['name']) ?></h1>
    
    <?php if(!empty($error)): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <h3>Basic Information</h3>
            <div class="grid-2">
                <div class="form-group"><label>Name</label><input type="text" name="name" value="<?= htmlspecialchars($u['name']) ?>" required></div>
                <div class="form-group"><label>Short Name</label><input type="text" name="short_name" value="<?= htmlspecialchars($u['short_name']) ?>"></div>
                <div class="form-group"><label>Country</label><input type="text" name="country" value="<?= htmlspecialchars($u['country']) ?>"></div>
                <div class="form-group"><label>City</label><input type="text" name="city" value="<?= htmlspecialchars($u['city']) ?>"></div>
                <div class="form-group"><label>Rank</label><input type="number" name="rank" value="<?= htmlspecialchars($u['rank']) ?>"></div>
                <div class="form-group"><label>Rating (Out of 5)</label><input type="number" step="0.1" name="rating" value="<?= htmlspecialchars($u['rating']) ?>"></div>
                <div class="form-group"><label>Display Fees (Short string)</label><input type="text" name="fees" value="<?= htmlspecialchars($u['fees']) ?>"></div>
                <div class="form-group">
                    <label>University Image (Replaces Flag/Icon)</label>
                    <input type="file" name="university_image" accept="image/*" style="padding: 6px; border: 1px dashed #cbd5e1; border-radius: 6px; background: #f8fafc;">
                    <?php if (!empty($u['image_path'])): ?>
                        <div style="margin-top: 5px; display: flex; align-items: center; gap: 10px;">
                            <img src="<?= htmlspecialchars($u['image_path']) ?>" style="height: 40px; border-radius: 4px; border: 1px solid #cbd5e1; object-fit: cover;">
                            <span style="font-size: 11px; color: #64748b;">Current Image</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Detailed Specifications</h3>
            <div class="grid-3">
                <div class="form-group"><label>Established Year</label><input type="text" name="established_year" value="<?= htmlspecialchars($u['established_year']) ?>"></div>
                <div class="form-group"><label>IELTS/PTE/TOEFL</label><input type="text" name="ielts_pte_toefl" value="<?= htmlspecialchars($u['ielts_pte_toefl']) ?>"></div>
                <div class="form-group"><label>Affiliated by</label><input type="text" name="affiliated_by" value="<?= htmlspecialchars($u['affiliated_by']) ?>"></div>
                <div class="form-group"><label>NEET Examination</label><input type="text" name="neet_examination" value="<?= htmlspecialchars($u['neet_examination']) ?>"></div>
                <div class="form-group"><label>University Type</label><input type="text" name="university_type" value="<?= htmlspecialchars($u['university_type']) ?>"></div>
                <div class="form-group"><label>Intake Sessions</label><input type="text" name="intake_sessions" value="<?= htmlspecialchars($u['intake_sessions']) ?>"></div>
                <div class="form-group"><label>University Grade</label><input type="text" name="university_grade" value="<?= htmlspecialchars($u['university_grade']) ?>"></div>
                <div class="form-group"><label>Eligibility Criteria</label><input type="text" name="eligibility_criteria" value="<?= htmlspecialchars($u['eligibility_criteria']) ?>"></div>
                <div class="form-group"><label>World Ranking</label><input type="text" name="world_ranking" value="<?= htmlspecialchars($u['world_ranking']) ?>"></div>
                <div class="form-group"><label>Country Ranking</label><input type="text" name="country_ranking" value="<?= htmlspecialchars($u['country_ranking']) ?>"></div>
                <div class="form-group"><label>Teaching Medium</label><input type="text" name="teaching_medium" value="<?= htmlspecialchars($u['teaching_medium']) ?>"></div>
                <div class="form-group"><label>Airport Distance</label><input type="text" name="airport_distance" value="<?= htmlspecialchars($u['airport_distance']) ?>"></div>
                <div class="form-group"><label>Teaching Faculty</label><input type="text" name="teaching_faculty" value="<?= htmlspecialchars($u['teaching_faculty']) ?>"></div>
                <div class="form-group"><label>WHO/FAIMER</label><input type="text" name="who_faimer" value="<?= htmlspecialchars($u['who_faimer']) ?>"></div>
                <div class="form-group"><label>Global Students</label><input type="text" name="global_students" value="<?= htmlspecialchars($u['global_students']) ?>"></div>
                <div class="form-group"><label>NMC/ECFMG</label><input type="text" name="nmc_ecfmg" value="<?= htmlspecialchars($u['nmc_ecfmg']) ?>"></div>
                <div class="form-group"><label>Hostel Location</label><input type="text" name="hostel_location" value="<?= htmlspecialchars($u['hostel_location']) ?>"></div>
            </div>
        </div>

        <div class="form-section">
            <h3>Fee Structure (Leave 0 if not applicable)</h3>
            <div class="grid-3">
                <div class="form-group"><label>Tuition (USD)</label><input type="number" step="0.01" name="tuition_usd" value="<?= htmlspecialchars($u['tuition_usd']) ?>"></div>
                <div class="form-group"><label>Tuition (INR)</label><input type="number" step="0.01" name="tuition_inr" value="<?= htmlspecialchars($u['tuition_inr']) ?>"></div>
                <div class="form-group"><label>Tuition (RUB)</label><input type="number" step="0.01" name="tuition_rub" value="<?= htmlspecialchars($u['tuition_rub']) ?>"></div>
                
                <div class="form-group"><label>Hostel (USD)</label><input type="number" step="0.01" name="hostel_usd" value="<?= htmlspecialchars($u['hostel_usd']) ?>"></div>
                <div class="form-group"><label>Hostel (INR)</label><input type="number" step="0.01" name="hostel_inr" value="<?= htmlspecialchars($u['hostel_inr']) ?>"></div>
                <div class="form-group"><label>Hostel (RUB)</label><input type="number" step="0.01" name="hostel_rub" value="<?= htmlspecialchars($u['hostel_rub']) ?>"></div>
                
                <div class="form-group"><label>Food/Mess (USD)</label><input type="number" step="0.01" name="food_usd" value="<?= htmlspecialchars($u['food_usd']) ?>"></div>
                <div class="form-group"><label>Food/Mess (INR)</label><input type="number" step="0.01" name="food_inr" value="<?= htmlspecialchars($u['food_inr']) ?>"></div>
                <div class="form-group"><label>Food/Mess (RUB)</label><input type="number" step="0.01" name="food_rub" value="<?= htmlspecialchars($u['food_rub']) ?>"></div>
                
                <div class="form-group"><label>Medical (USD)</label><input type="number" step="0.01" name="medical_usd" value="<?= htmlspecialchars($u['medical_usd']) ?>"></div>
                <div class="form-group"><label>Medical (INR)</label><input type="number" step="0.01" name="medical_inr" value="<?= htmlspecialchars($u['medical_inr']) ?>"></div>
                <div class="form-group"><label>Medical (RUB)</label><input type="number" step="0.01" name="medical_rub" value="<?= htmlspecialchars($u['medical_rub']) ?>"></div>
                
                <div class="form-group"><label>OTC (USD)</label><input type="number" step="0.01" name="otc_usd" value="<?= htmlspecialchars($u['otc_usd']) ?>"></div>
                <div class="form-group"><label>OTC (INR)</label><input type="number" step="0.01" name="otc_inr" value="<?= htmlspecialchars($u['otc_inr']) ?>"></div>
                <div class="form-group"><label>OTC (RUB)</label><input type="number" step="0.01" name="otc_rub" value="<?= htmlspecialchars($u['otc_rub']) ?>"></div>
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            <a href="university_detail.php?id=<?= $u['id'] ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
