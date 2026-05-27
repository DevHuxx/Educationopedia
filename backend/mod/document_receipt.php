<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/auth_mod.php';
requireMod();

$db = getDB();
$leadId = (int)($_GET['lead_id'] ?? 0);

$stmt = $db->prepare("SELECT l.*, d.father_name, d.address, d.alt_phone, d.selected_institute FROM leads l LEFT JOIN lead_details d ON l.id = d.lead_id WHERE l.id = ?");
$stmt->bind_param('i', $leadId);
$stmt->execute();
$lead = $stmt->get_result()->fetch_assoc();

if (!$lead) die("Lead not found.");

$docs = $db->query("SELECT * FROM lead_documents WHERE lead_id = $leadId ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document Receipt - #<?= $leadId ?></title>
<style>
body { font-family: Arial, sans-serif; padding: 40px; color: #000; }
.header { display: flex; justify-content: space-between; margin-bottom: 20px; font-weight: bold; font-size: 14px; }
.title { text-align: center; background: #1d4ed8; color: #fff; padding: 6px; font-weight: bold; font-size: 14px; margin-bottom: 20px; }
table.info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 2px solid #000; }
table.info-table td { padding: 8px 12px; font-size: 13px; }
table.info-table td strong { display: inline-block; width: 100px; }
table.docs-table { width: 100%; border-collapse: collapse; border: 2px solid #000; margin-bottom: 60px; }
table.docs-table th, table.docs-table td { border: 1px solid #000; padding: 8px; font-size: 13px; text-align: left; }
table.docs-table th { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.footer-seal { text-align: right; font-weight: bold; margin-bottom: 40px; }
.terms { font-size: 11px; border-top: 1px dashed #000; padding-top: 10px; }
.terms h4 { margin: 0 0 5px 0; font-size: 13px; }
.terms ul { padding-left: 20px; margin-top: 0; }
</style>
</head>
<body onload="window.print()">

<div class="header">
    <div>REC. NO. : EPC/<?= date('Y') ?>/DOC/<?= $leadId ?></div>
    <div>Dated: <?= date('d-m-Y') ?></div>
</div>

<div class="title">DOCUMENT RECEIPT</div>

<table class="info-table">
    <tr>
        <td><strong>Student Name :</strong> <?= htmlspecialchars($lead['name']) ?></td>
        <td><strong>Adm. ID:</strong> #<?= $leadId ?></td>
    </tr>
    <tr>
        <td><strong>Father Name :</strong> <?= htmlspecialchars($lead['father_name'] ?? 'N/A') ?></td>
        <td><strong>Course :</strong> <?= htmlspecialchars($lead['course']) ?></td>
    </tr>
    <tr>
        <td><strong>Address :</strong> <?= htmlspecialchars($lead['address'] ?? 'N/A') ?></td>
        <td><strong>Country :</strong> <?= htmlspecialchars($lead['country']) ?></td>
    </tr>
    <tr>
        <td><strong>Contact No. :</strong> <?= htmlspecialchars($lead['phone']) ?></td>
        <td><strong>Institution :</strong> <?= htmlspecialchars($lead['selected_institute'] ?? 'N/A') ?></td>
    </tr>
</table>

<table class="docs-table">
    <tr>
        <th style="width: 40px;">#</th>
        <th>Document</th>
    </tr>
    <?php if (empty($docs)): ?>
    <tr><td colspan="2" style="text-align:center;">No documents uploaded yet.</td></tr>
    <?php else: ?>
        <?php foreach ($docs as $index => $doc): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($doc['doc_name']) ?> (Original)</td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<div class="footer-seal">
    Authorized Seal & Signatory<br>
    <br><br>
</div>

<div class="terms">
    <h4>Terms and Conditions for Document Receipts</h4>
    <strong>1. Acceptance of Terms</strong>
    <ul><li>By submitting documents, you agree to these terms and conditions governing the receipt, processing, and handling of documents.</li></ul>
    <strong>2. Document Submission</strong>
    <ul>
        <li>Documents must be complete, legible, and submitted in the required format.</li>
        <li>We reserve the right to reject incomplete or illegible submissions.</li>
    </ul>
    <strong>3. Confidentiality</strong>
    <ul><li>All submitted documents are treated as confidential.</li></ul>
</div>

</body>
</html>
