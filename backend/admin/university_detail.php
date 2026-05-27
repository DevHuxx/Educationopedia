<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth.php';
initSession();
if (!isAdmin()) {
    require_once __DIR__ . '/../mod/auth_mod.php';
    session_write_close();
    if (!isMod()) {
        header('Location: login.php');
        exit;
    }
}

$db  = getDB();
$id  = (int)($_GET['id'] ?? 0);
if (!$id) { echo "No university ID provided."; exit; }

$stmt = $db->prepare("SELECT * FROM universities WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { echo "University not found."; exit; }

function val($v) { return ($v && trim($v) !== '') ? htmlspecialchars($v) : 'N/A'; }

$pageUrl    = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$shareCaption = urlencode($u['name'] . ' — MBBS Fees & Details | Educationopedia');

$inr_to_usd = 90;
$yuan_to_inr = 12; 
$rub_to_usd = 75;

$symbol = ($u['country'] === 'China') ? '¥' : '$';
$conversion_rate = ($u['country'] === 'China') ? $yuan_to_inr : $inr_to_usd;

$tuition_1 = ($u['tuition_inr'] > 0) ? '₹ ' . $u['tuition_inr'] : (($u['tuition_usd'] > 0) ? $symbol . number_format($u['tuition_usd']) : (($u['tuition_rub'] > 0) ? number_format($u['tuition_rub']) . ' RUB' : val($u['fees'])));

$hostel_1 = ($u['hostel_inr'] > 0) ? '₹ ' . $u['hostel_inr'] : (($u['hostel_usd'] > 0) ? $symbol . number_format($u['hostel_usd']) : (($u['hostel_rub'] > 0) ? number_format($u['hostel_rub']) . ' RUB' : 'N/A'));

$food_usd = ($u['food_usd'] > 0) ? $u['food_usd'] : (($u['food_rub'] > 0) ? (in_array($u['country'], ['Georgia', 'China']) ? $u['food_rub'] : $u['food_rub'] / $inr_to_usd) : 0);
$food_1 = ($u['food_inr'] > 0) ? '₹ ' . $u['food_inr'] : ($food_usd > 0 ? $symbol . number_format($food_usd) : 'N/A');

$medical_usd = ($u['medical_usd'] > 0) ? $u['medical_usd'] : (($u['medical_rub'] > 0) ? (in_array($u['country'], ['Georgia', 'China']) ? $u['medical_rub'] : $u['medical_rub'] / $rub_to_usd) : 0);
$medical_1 = ($u['medical_inr'] > 0) ? '₹ ' . $u['medical_inr'] : ($medical_usd > 0 ? $symbol . number_format($medical_usd) : 'N/A');

$otc_usd = ($u['otc_usd'] > 0) ? $u['otc_usd'] : (($u['otc_rub'] > 0) ? $u['otc_rub'] : 0);
$otc_1 = ($u['otc_inr'] > 0) ? '₹ ' . $u['otc_inr'] : ($otc_usd > 0 ? $symbol . number_format($otc_usd) : 'N/A');

$y1_usd = $u['tuition_usd'] + $u['hostel_usd'] + $food_usd + $medical_usd + $otc_usd;
$y2_usd = $u['tuition_usd'] + $u['hostel_usd'] + $food_usd + $medical_usd;

$y1_display = $y1_usd > 0 ? $symbol . number_format($y1_usd) : 'N/A';
$y2_display = $y2_usd > 0 ? $symbol . number_format($y2_usd) : 'N/A';

$y1_inr_display = $y1_usd > 0 ? '₹' . number_format($y1_usd * $conversion_rate) : 'N/A';
$y2_inr_display = $y2_usd > 0 ? '₹' . number_format($y2_usd * $conversion_rate) : 'N/A';

$total_usd = $y1_usd + ($y2_usd * 5);
$total_inr = $total_usd * $conversion_rate;

$total_usd_display = $total_usd > 0 ? $symbol . number_format($total_usd) : 'Calculated Upon Request';
$total_inr_display = $total_usd > 0 ? '₹' . number_format($total_inr) : 'Calculated Upon Request';
$total_inr_lakh = $total_usd > 0 ? ' (≈ ' . round($total_inr / 100000, 2) . ' Lakh)' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($u['name']) ?> — Details</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const UNI_NAME = <?= json_encode($u['name']) ?>;
async function captureCard() {
  const card = document.getElementById('uni-card');
  const loader = document.getElementById('share-loading');
  if (!card || !loader) return null;
  loader.classList.add('active');
  try {
    const canvas = await html2canvas(card, { scale: 2, useCORS: true, backgroundColor: '#ffffff' });
    return canvas;
  } catch (e) {
    console.error("Capture failed", e);
    throw e;
  }
}

async function shareImage(target) {
  const loader = document.getElementById('share-loading');
  document.querySelector('#share-loading p').textContent = 'Generating Image…';
  try {
    const canvas = await captureCard();
    if (!canvas) return;
    const blob = await new Promise(r => canvas.toBlob(r, 'image/png'));
    const file = new File([blob], 'university-details.png', { type: 'image/png' });
    if (target === 'dl') {
      const link = document.createElement('a');
      link.download = UNI_NAME.replace(/[^a-z0-9]/gi, '_') + '_details.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    } else if (navigator.share && navigator.canShare && navigator.canShare({ files: [file] })) {
      await navigator.share({ files: [file], title: UNI_NAME, text: UNI_NAME + ' Details' });
    }
    loader.classList.remove('active');
  } catch (err) {
    if (loader) loader.classList.remove('active');
    if (err.name !== 'AbortError') alert('Action failed: ' + err.message);
  }
}

async function downloadPDF() {
  const loader = document.getElementById('share-loading');
  loader.classList.add('active');
  document.querySelector('#share-loading p').textContent = 'Generating PDF…';
  try {
    const canvas = await captureCard();
    if (!canvas) return;
    
    const { jsPDF } = window.jspdf;
    const imgData = canvas.toDataURL('image/png');
    
    const pdf = new jsPDF({
      orientation: canvas.width > canvas.height ? 'landscape' : 'portrait',
      unit: 'px',
      format: [canvas.width, canvas.height]
    });
    
    pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
    pdf.save(UNI_NAME.replace(/[^a-z0-9]/gi, '_') + '_details.pdf');
    
    loader.classList.remove('active');
    document.querySelector('#share-loading p').textContent = 'Capturing…';
  } catch (err) {
    if (loader) loader.classList.remove('active');
    alert('PDF Generation failed: ' + err.message);
  }
}
</script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
  body { background: #eef2f5; padding: 20px; color: #111; display: flex; flex-direction: column; align-items: center; }
  
  .back-bar { width: 1200px; margin: 0 auto 20px auto; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
  .btn { padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; border: none; }
  .btn-dark { background: #1e293b; color: white; }
  .btn-blue { background: #0056b3; color: white; }
  .btn-red { background: #dc3545; color: white; }
  
  #share-loading { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.8); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; color: white; font-weight: bold; }
  #share-loading.active { display: flex; }

  /* Set fixed width to match exactly the aspect ratio of the right image */
  .card { width: 1200px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; position: relative; }
  
  /* Top Section */
  .top-section { display: flex; height: 350px; }
  /* Match exactly 34% width for perfect vertical alignment with the PARTICULARS column */
  .top-left { width: 34%; position: relative; background: #f0f0f0; flex-shrink: 0; }
  .top-left img { width: 100%; height: 100%; object-fit: cover; }
  .badge-private { position: absolute; top: 15px; left: 0px; background: #ff8c00; color: #fff; padding: 4px 12px; font-weight: 800; border-radius: 0 4px 4px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
  .top-left .fallback-icon { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; font-size: 100px; }

  .top-right { flex: 1; padding: 15px 25px; position: relative; background: #fff; display: flex; flex-direction: column; }
  .top-right h1 { color: #22253b; font-size: 26px; font-weight: 800; margin-bottom: 2px; line-height: 1.2; }
  .address { color: #666; font-size: 12px; margin-bottom: 8px; display: flex; align-items: center; gap: 4px; }
  
  .meta-top { position: absolute; top: 15px; right: 25px; text-align: right; font-size: 10px; font-weight: 600; color: #333; line-height: 1.5; }
  
  .badges { display: flex; gap: 6px; margin-bottom: 12px; }
  .badge-tag { padding: 2px 10px; background: #fff; border: 1px solid #108c5c; color: #108c5c; font-weight: 700; font-size: 10px; border-radius: 20px; }

  .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 10px; font-size: 11px; position: relative; z-index: 1; flex: 1; }
  .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.05; width: 280px; pointer-events: none; z-index: 0; }
  
  .detail-item { display: flex; gap: 5px; align-items: baseline; border-bottom: 1px dashed #f0f0f0; padding-bottom: 2px; }
  .detail-label { width: 130px; color: #111; font-weight: 700; }
  .detail-value { color: #555; font-weight: 600; }

  .note-text { font-size: 10px; color: #444; margin-top: 8px; line-height: 1.4; font-weight: 500; }

  /* Fee Section */
  .fee-title { background: #ff8c00; color: #fff; text-align: center; font-size: 18px; font-weight: 800; padding: 10px; text-transform: uppercase; }
  .table-responsive { width: 100%; }
  table.fee-table { width: 100%; border-collapse: collapse; text-align: center; font-size: 12px; font-weight: 700; table-layout: fixed; }
  table.fee-table th, table.fee-table td { border: 1px solid #e0e0e0; padding: 8px 5px; }
  table.fee-table thead th { background: #0056b3; color: #fff; font-size: 11px; text-transform: uppercase; }
  table.fee-table thead th:last-child { background: #ff8c00; }
  
  /* PERFECT VERTICAL ALIGNMENT: 34% width for the first column! */
  table.fee-table th:first-child,
  table.fee-table tbody tr td:first-child { width: 34%; }
  
  table.fee-table tbody tr td:first-child { background: #ff8c00; color: #fff; text-transform: uppercase; text-align: center; border-color: #fff; }
  table.fee-table tbody tr td { background: #fff; color: #333; }
  
  /* Totals row overrides */
  table.fee-table tbody tr.total-row td:first-child { background: #fff; color: #111; font-weight: 800; border: 1px solid #e0e0e0; }
  table.fee-table tbody tr.total-row td { font-weight: 800; font-size: 12px; }
  
  /* Summary Buttons */
  .summary-bar { display: flex; justify-content: flex-end; gap: 15px; padding: 15px 30px; background: #fff; border-top: 1px solid #e0e0e0; }
  .summary-box { padding: 10px 20px; border-radius: 4px; font-size: 14px; font-weight: 800; color: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
  .box-usd { background: #198754; }
  .box-inr { background: #dc3545; }

</style>
</head>
<body>

<div id="share-loading"><p>Capturing…</p></div>

<div class="back-bar">
  <?php if (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false): ?>
    <a href="index.php?section=universities&country=<?= urlencode($u['country']) ?>" class="btn btn-dark">← Back to Universities</a>
    <div style="display:flex;gap:10px;">
      <a href="edit_university.php?id=<?= $u['id'] ?>" class="btn btn-blue">✏️ EDIT</a>
      <button onclick="downloadPDF()" class="btn btn-red">⬇️ PDF</button>
      <button onclick="shareImage('dl')" class="btn btn-dark">⬇️ IMAGE</button>
    </div>
  <?php else: ?>
    <a href="cms.php?section=universities&country=<?= urlencode($u['country']) ?>" class="btn btn-dark">← Back to Universities</a>
    <div style="display:flex;gap:10px;">
      <?php if (!empty($_SESSION['mod_rights']['university_rights'])): ?>
      <a href="edit_university.php?id=<?= $u['id'] ?>" class="btn btn-blue">✏️ EDIT</a>
      <?php endif; ?>
      <button onclick="downloadPDF()" class="btn btn-red">⬇️ PDF</button>
      <button onclick="shareImage('dl')" class="btn btn-dark">⬇️ IMAGE</button>
    </div>
  <?php endif; ?>
</div>

<div class="card" id="uni-card">
  <div class="top-section">
    <div class="top-left">
      <div class="badge-private"><?= strtoupper(val($u['university_type'] ?? 'Private')) ?></div>
      <?php if (!empty($u['image_path'])): ?>
        <img src="<?= htmlspecialchars($u['image_path']) ?>" alt="<?= val($u['name']) ?>">
      <?php else: ?>
        <div class="fallback-icon"><?= $u['flag'] ?: '🏛️' ?></div>
      <?php endif; ?>
    </div>
    
    <div class="top-right">
      <div class="meta-top">
        Updated on : <?= date('d/M/Y') ?><br>
        Ref # : COL/UNI-<?= 1000 + $u['id'] ?>-<?= date('Y') ?>
      </div>
      
      <h1><?= val($u['name']) ?></h1>
      <div class="address">📍 <?= val($u['address'] ?? $u['city'] . ', ' . $u['country']) ?></div>
      
      <div class="badges">
        <div class="badge-tag">General Medicine</div>
        <div class="badge-tag">Bachelor</div>
        <div class="badge-tag"><?= val($u['country']) ?></div>
      </div>
      
      <div class="details-grid">
        <img src="/assets/logo-DUbuizEs.png" class="watermark" alt="Watermark">
        
        <div class="detail-item"><div class="detail-label">Established Year</div> <div class="detail-value">: <?= val($u['established_year'] ?? 'N/A') ?></div></div>
        <div class="detail-item"><div class="detail-label">IELTS/PTE/TOEFL</div> <div class="detail-value">: <?= val($u['ielts_pte_toefl'] ?? 'Not Required') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">Affiliated by</div> <div class="detail-value">: <?= val($u['affiliated_by'] ?? 'MoE ' . $u['country']) ?></div></div>
        <div class="detail-item"><div class="detail-label">NEET Examination</div> <div class="detail-value">: <?= val($u['neet_examination'] ?? 'Required') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">University Type</div> <div class="detail-value">: <?= val($u['university_type'] ?? 'Private') ?></div></div>
        <div class="detail-item"><div class="detail-label">Intake Sessions</div> <div class="detail-value">: <?= val($u['intake_sessions'] ?? $u['deadline']) ?></div></div>
        
        <div class="detail-item"><div class="detail-label">University Grade</div> <div class="detail-value">: <?= val($u['university_grade'] ?? 'A++') ?></div></div>
        <div class="detail-item"><div class="detail-label">Eligibility Criteria</div> <div class="detail-value">: <?= val($u['eligibility_criteria'] ?? '50% in PCB') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">World Ranking</div> <div class="detail-value">: <?= val($u['world_ranking'] ?? 'N/A') ?></div></div>
        <div class="detail-item"><div class="detail-label">Course Duration</div> <div class="detail-value">: <?= val($u['course_duration'] ?? '6 Years') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">Country Ranking</div> <div class="detail-value">: <?= val($u['country_ranking'] ?? 'N/A') ?></div></div>
        <div class="detail-item"><div class="detail-label">Teaching Medium</div> <div class="detail-value">: <?= val($u['teaching_medium'] ?? 'English') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">Airport Distance</div> <div class="detail-value">: <?= val($u['airport_distance'] ?? 'N/A') ?></div></div>
        <div class="detail-item"><div class="detail-label">Teaching Faculty</div> <div class="detail-value">: <?= val($u['teaching_faculty'] ?? 'Mixed') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">WHO/FAIMER</div> <div class="detail-value">: <?= val($u['who_faimer'] ?? 'Recognised') ?></div></div>
        <div class="detail-item"><div class="detail-label">Global Students</div> <div class="detail-value">: <?= val($u['global_students'] ?? '1000+') ?></div></div>
        
        <div class="detail-item"><div class="detail-label">NMC/ECFMG</div> <div class="detail-value">: <?= val($u['nmc_ecfmg'] ?? 'Approved') ?></div></div>
        <div class="detail-item"><div class="detail-label">Hostel Location</div> <div class="detail-value">: <?= val($u['hostel_location'] ?? 'Near Campus') ?></div></div>
      </div>
      
      <div class="note-text">
        Note : 1st Year OTC Includes Countryside: University Registration, Ministry Registration, Police registration, Residence registration PINFL, Laundry Fee, Library Fee, document translation, Documentation and processing for legalization from Ministry and Notary, Biometric Fees, Initial Medical Checkup & Misc. Charges
      </div>
    </div>
  </div>

  <div class="fee-title">FEE STRUCTURE 2026-27</div>
  <div class="table-responsive">
    <table class="fee-table">
      <thead>
        <tr>
          <th>PARTICULARS</th>
          <th>1ST YEAR</th>
          <th>2ND YEAR</th>
          <th>3RD YEAR</th>
          <th>4TH YEAR</th>
          <th>5TH YEAR</th>
          <th>6TH YEAR</th>
          <th>TOTAL<br>(6 YEARS)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>TUITION FEES</td>
          <td><?= $tuition_1 ?></td><td><?= $tuition_1 ?></td><td><?= $tuition_1 ?></td>
          <td><?= $tuition_1 ?></td><td><?= $tuition_1 ?></td><td><?= $tuition_1 ?></td>
          <td rowspan="5" style="vertical-align: middle; font-weight: 800; font-size: 15px;"><?= $total_usd_display ?></td>
        </tr>
        <tr>
          <td>HOSTEL</td>
          <td><?= $hostel_1 ?></td><td><?= $hostel_1 ?></td><td><?= $hostel_1 ?></td>
          <td><?= $hostel_1 ?></td><td><?= $hostel_1 ?></td><td><?= $hostel_1 ?></td>
        </tr>
        <tr>
          <td>FOOD/MESS</td>
          <td><?= $food_1 ?></td><td><?= $food_1 ?></td><td><?= $food_1 ?></td>
          <td><?= $food_1 ?></td><td><?= $food_1 ?></td><td><?= $food_1 ?></td>
        </tr>
        <tr>
          <td>MEDICAL INSURANCE</td>
          <td><?= $medical_1 ?></td><td><?= $medical_1 ?></td><td><?= $medical_1 ?></td>
          <td><?= $medical_1 ?></td><td><?= $medical_1 ?></td><td><?= $medical_1 ?></td>
        </tr>
        <tr>
          <td>ONE TIME ADMINISTRATIVE CHARGE (OTC)</td>
          <td><?= $otc_1 ?></td><td>NA</td><td>NA</td><td>NA</td><td>NA</td><td>NA</td>
        </tr>
        
        <tr class="total-row">
          <td>TOTAL In USD</td>
          <td><?= $y1_display ?></td><td><?= $y2_display ?></td><td><?= $y2_display ?></td>
          <td><?= $y2_display ?></td><td><?= $y2_display ?></td><td><?= $y2_display ?></td>
          <td style="font-size: 14px;"><?= $total_usd_display ?></td>
        </tr>
        <tr class="total-row">
          <td>TOTAL In INR</td>
          <td><?= $y1_inr_display ?></td><td><?= $y2_inr_display ?></td><td><?= $y2_inr_display ?></td>
          <td><?= $y2_inr_display ?></td><td><?= $y2_inr_display ?></td><td><?= $y2_inr_display ?></td>
          <td style="font-size: 14px;"><?= $total_inr_display ?><br><span style="font-size:11px;font-weight:600;"><?= $total_inr_lakh ?></span></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="summary-bar">
    <div class="summary-box box-usd">Total Package In USD: <?= $total_usd_display ?></div>
    <div class="summary-box box-inr">Total Package In INR: <?= $total_inr_display ?><?= $total_inr_lakh ?></div>
  </div>

</div>

</body>
</html>
