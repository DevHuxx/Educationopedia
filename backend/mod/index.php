<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/auth_mod.php';
requireMod();

$db      = getDB();
$modId   = $_SESSION['mod_id'];
$modName = $_SESSION['mod_name'] ?: $_SESSION['mod_username'];

$modRights = [];
try {
    $stmt = $db->prepare("SELECT university_rights, site_content_rights, exam_rights FROM mod_users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $modId);
        $stmt->execute();
        $modRights = $stmt->get_result()->fetch_assoc();
    }
} catch (Exception $e) {}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    modLogout();
    header('Location: login.php');
    exit;
}

$toast = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leadId  = (int)($_POST['lead_id'] ?? 0);
    $status  = $_POST['status'] ?? '';
    $remark  = trim($_POST['remark'] ?? '');
    $allowed = ['new', 'processing', 'positive', 'negative'];

    if ($leadId && in_array($status, $allowed)) {
        
        $check = $db->prepare("SELECT id FROM leads WHERE id = ? AND assigned_to = ?");
        $check->bind_param('ii', $leadId, $modId);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            
            $upd = $db->prepare("UPDATE leads SET status = ? WHERE id = ?");
            $upd->bind_param('si', $status, $leadId);
            $upd->execute();
            
            if ($remark) {
                $ins = $db->prepare("INSERT INTO lead_remarks (lead_id, mod_id, remark, status_at_time) VALUES (?, ?, ?, ?)");
                $ins->bind_param('iiss', $leadId, $modId, $remark, $status);
                $ins->execute();
            }
            $toast = 'Lead updated successfully.';
        }
    }
}

$leads = [];
$r = $db->prepare("SELECT * FROM leads WHERE assigned_to = ? ORDER BY created_at DESC");
$r->bind_param('i', $modId);
$r->execute();
$leads = $r->get_result()->fetch_all(MYSQLI_ASSOC);

$remarks = [];
if ($leads) {
    $ids = implode(',', array_column($leads, 'id'));
    $rr = $db->query("SELECT lr.*, mu.username as mod_username FROM lead_remarks lr 
                       LEFT JOIN mod_users mu ON mu.id = lr.mod_id 
                       WHERE lr.lead_id IN ($ids) ORDER BY lr.created_at ASC");
    while ($row = $rr->fetch_assoc()) {
        $remarks[$row['lead_id']][] = $row;
    }
}

$statusColors = [
    'new'        => '#3b82f6',
    'processing' => '#f59e0b',
    'positive'   => '#22c55e',
    'negative'   => '#ef4444',
];
$statusIcons = ['new' => '🆕', 'processing' => '⏳', 'positive' => '✅', 'negative' => '❌'];

$activeLeadId = (int)($_GET['lead'] ?? ($leads[0]['id'] ?? 0));
$activeLead   = null;
foreach ($leads as $l) { if ($l['id'] === $activeLeadId) { $activeLead = $l; break; } }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mod Portal — Educationopedia</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; display: flex; }

/* ── Layout ── */
.sidebar { width: 280px; background: #1e293b; border-right: 1px solid #334155; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
.sidebar-logo { padding: 20px 20px 16px; border-bottom: 1px solid #334155; }
.sidebar-logo h2 { font-size: 16px; font-weight: 700; color: #f8fafc; }
.sidebar-logo h2 span { color: #6366f1; }
.sidebar-logo p { color: #64748b; font-size: 12px; margin-top: 2px; }
.mod-badge { margin: 12px 16px; background: #312e81; border: 1px solid #6366f1; border-radius: 8px; padding: 8px 12px; font-size: 12px; color: #a5b4fc; }
.lead-list { flex: 1; overflow-y: auto; padding: 8px; }
.lead-item { padding: 12px; border-radius: 10px; cursor: pointer; border: 1px solid transparent; margin-bottom: 6px; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
.lead-item:hover { transform: translateX(4px); background: #1e293b; box-shadow: -4px 0 0 0 #4f46e5; }
.lead-item:hover { background: #1e293b; border-color: #475569; }
.lead-item.active { background: #1e3a5f; border-color: #3b82f6; }
.lead-item .lead-name { font-weight: 600; font-size: 14px; color: #f1f5f9; }
.lead-item .lead-meta { font-size: 11px; color: #64748b; margin-top: 3px; }
.lead-item .status-pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 600; margin-top: 5px; }
.sidebar-footer { padding: 16px; border-top: 1px solid #334155; }
.sidebar-footer a { color: #64748b; font-size: 13px; text-decoration: none; }
.sidebar-footer a:hover { color: #94a3b8; }

/* ── Main ── */
.main { flex: 1; overflow-y: auto; padding: 24px; }
.page-header { margin-bottom: 24px; }
.page-header h1 { font-size: 22px; font-weight: 700; color: #f8fafc; }
.page-header p { color: #64748b; font-size: 13px; margin-top: 4px; }

/* ── Lead Detail Card ── */
.detail-card { background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%); border: 1px solid #334155; border-radius: 14px; padding: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
.detail-field label { display: block; color: #64748b; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
.detail-field .val { color: #f1f5f9; font-size: 15px; font-weight: 500; }
.detail-field .val a { color: #818cf8; }

/* ── Status Update Form ── */
.update-form { background: #0f172a; border: 1px solid #334155; border-radius: 10px; padding: 20px; margin-top: 20px; }
.update-form h3 { color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 14px; }
.status-radios { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 14px; }
.status-radio input { display: none; }
.status-radio label { padding: 7px 16px; border-radius: 20px; border: 2px solid #334155; cursor: pointer; font-size: 13px; font-weight: 600; transition: all .15s; color: #94a3b8; }
.status-radio input:checked + label { border-color: currentColor; background: #1e293b; }
.status-radio.processing label { color: #f59e0b; }
.status-radio.positive  label { color: #22c55e; }
.status-radio.negative  label { color: #ef4444; }
textarea { width: 100%; background: #1e293b; border: 1px solid #334155; border-radius: 8px; color: #f1f5f9; padding: 10px 14px; font-size: 14px; resize: vertical; min-height: 80px; outline: none; font-family: inherit; }
textarea:focus { border-color: #6366f1; }
.btn-submit { margin-top: 12px; padding: 10px 24px; background: #6366f1; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
.btn-submit:hover { background: #4f46e5; }

/* ── Remarks Timeline ── */
.remarks-section { margin-top: 24px; }
.remarks-section h3 { color: #94a3b8; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 14px; }
.remark-item { display: flex; gap: 12px; margin-bottom: 14px; }
.remark-dot { width: 8px; height: 8px; border-radius: 50%; background: #6366f1; flex-shrink: 0; margin-top: 6px; }
.remark-body { flex: 1; background: #0f172a; border: 1px solid #1e293b; border-radius: 8px; padding: 10px 14px; }
.remark-meta { font-size: 11px; color: #475569; margin-bottom: 4px; }
.remark-text { color: #cbd5e1; font-size: 14px; }
.remark-status { display: inline-block; padding: 1px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; margin-left: 8px; }

/* ── Empty state ── */
.empty { text-align: center; padding: 60px 20px; color: #475569; }
.empty .icon { font-size: 48px; margin-bottom: 12px; }
.empty p { font-size: 14px; }

/* ── Toast ── */
.toast { position: fixed; top: 20px; right: 20px; background: #166534; border: 1px solid #22c55e;
         color: #86efac; padding: 12px 20px; border-radius: 10px; font-size: 14px; z-index: 999;
         animation: fadeIn .3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 768px) {
  body { flex-direction: column; }
  .sidebar { width: 100%; height: auto; position: static; }
  .detail-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<?php if ($toast): ?>
<div class="toast">✅ <?= htmlspecialchars($toast) ?></div>
<script>setTimeout(() => document.querySelector('.toast')?.remove(), 3000);</script>
<?php endif; ?>

<aside class="sidebar">
  <div class="sidebar-logo">
    <h2>EDUCATION<span>OPEDIA</span></h2>
    <p>Moderator Portal</p>
  </div>
  <div class="mod-badge">👤 <?= htmlspecialchars($modName) ?></div>

  <div class="lead-list">
    <?php if (empty($leads)): ?>
      <div style="padding:20px;color:#475569;font-size:13px;text-align:center;">No leads assigned yet.</div>
    <?php else: foreach ($leads as $l):
        $sc = $statusColors[$l['status']] ?? '#64748b';
        $si = $statusIcons[$l['status']] ?? '•';
    ?>
      <a href="?lead=<?= $l['id'] ?>" style="text-decoration:none;">
        <div class="lead-item <?= $activeLeadId == $l['id'] ? 'active' : '' ?>">
          <div class="lead-name"><?= htmlspecialchars($l['name']) ?></div>
          <div class="lead-meta">📞 <?= htmlspecialchars($l['phone']) ?> · <?= htmlspecialchars($l['country'] ?: '—') ?></div>
          <div>
            <span class="status-pill" style="background:<?= $sc ?>22;color:<?= $sc ?>;border:1px solid <?= $sc ?>55;">
              <?= $si ?> <?= ucfirst($l['status']) ?>
            </span>
          </div>
        </div>
      </a>
    <?php endforeach; endif; ?>
  </div>

  <div class="sidebar-footer" style="display:flex; flex-direction:column; gap:12px;">
    <?php if (!empty($modRights['university_rights'])): ?>
        <a href="cms.php?section=universities">🏛️ Manage Universities</a>
    <?php endif; ?>
    <?php if (!empty($modRights['site_content_rights'])): ?>
        <a href="cms.php?section=content">📝 Manage Site Content</a>
    <?php endif; ?>
    <?php if (!empty($modRights['exam_rights'])): ?>
        <a href="manage_exams.php">🎓 Manage Exams</a>
    <?php endif; ?>
    <div style="border-top:1px solid #334155; margin:4px 0;"></div>
    <a href="?action=logout">🚪 Logout</a>
  </div>
</aside>

<div class="main">
  <div class="page-header">
    <h1>My Assigned Leads</h1>
    <p><?= count($leads) ?> lead<?= count($leads) != 1 ? 's' : '' ?> assigned to you</p>
  </div>

  <?php if (!$activeLead): ?>
    <div class="empty">
      <div class="icon">📭</div>
      <p>No leads assigned to you yet.<br>Ask the admin to assign leads to your account.</p>
    </div>
  <?php else:
    $sc = $statusColors[$activeLead['status']] ?? '#64748b';
    $si = $statusIcons[$activeLead['status']] ?? '•';
  ?>
    <div class="detail-card">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <div>
          <h2 style="color:#f8fafc;font-size:20px;"><?= htmlspecialchars($activeLead['name']) ?></h2>
          <div style="font-size:12px;color:#475569;margin-top:4px;">
            Submitted: <?= date('d M Y, h:i A', strtotime($activeLead['created_at'])) ?>
          </div>
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
          <span class="status-pill" style="background:<?= $sc ?>22;color:<?= $sc ?>;border:1px solid <?= $sc ?>55;font-size:13px;padding:6px 14px;">
            <?= $si ?> <?= ucfirst($activeLead['status']) ?>
          </span>
          <?php if ($activeLead['status'] === 'positive'): ?>
            <a href="admission.php?lead_id=<?= $activeLead['id'] ?>" style="background:#6366f1;color:#fff;border-radius:20px;padding:6px 14px;font-size:13px;font-weight:600;text-decoration:none;">📝 Fill Student Details</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="detail-grid">
        <div class="detail-field">
          <label>📞 Phone</label>
          <div class="val"><a href="tel:<?= htmlspecialchars($activeLead['phone']) ?>"><?= htmlspecialchars($activeLead['phone']) ?></a></div>
        </div>
        <div class="detail-field">
          <label>📧 Email</label>
          <div class="val"><a href="mailto:<?= htmlspecialchars($activeLead['email']) ?>"><?= htmlspecialchars($activeLead['email']) ?></a></div>
        </div>
        <div class="detail-field">
          <label>🌍 Preferred Country</label>
          <div class="val"><?= htmlspecialchars($activeLead['country'] ?: '—') ?></div>
        </div>
        <div class="detail-field">
          <label>🎓 Course</label>
          <div class="val"><?= htmlspecialchars($activeLead['course'] ?: '—') ?></div>
        </div>
        <?php if ($activeLead['message']): ?>
        <div class="detail-field" style="grid-column:1/-1;">
          <label>💬 Message</label>
          <div class="val" style="font-size:14px;color:#94a3b8;"><?= nl2br(htmlspecialchars($activeLead['message'])) ?></div>
        </div>
        <?php endif; ?>
      </div>

      <div class="update-form">
        <h3>Update Status & Add Remark</h3>
        <form method="POST" action="?lead=<?= $activeLead['id'] ?>">
          <input type="hidden" name="lead_id" value="<?= $activeLead['id'] ?>">
          <div class="status-radios">
            <?php foreach (['processing' => '⏳ Processing', 'positive' => '✅ Positive', 'negative' => '❌ Negative'] as $val => $label): ?>
              <div class="status-radio <?= $val ?>">
                <input type="radio" name="status" id="s_<?= $val ?>" value="<?= $val ?>" <?= $activeLead['status'] === $val ? 'checked' : '' ?>>
                <label for="s_<?= $val ?>"><?= $label ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <textarea name="remark" placeholder="Add a remark (optional — will be appended to timeline)…"></textarea>
          <button type="submit" class="btn-submit">Save Update</button>
        </form>
      </div>

      <div class="remarks-section">
        <h3>Remarks Timeline</h3>
        <?php $leadRemarks = $remarks[$activeLead['id']] ?? []; ?>
        <?php if (empty($leadRemarks)): ?>
          <div style="color:#475569;font-size:13px;">No remarks yet. Add the first one above.</div>
        <?php else: foreach (array_reverse($leadRemarks) as $rem):
            $rsc = $statusColors[$rem['status_at_time']] ?? '#64748b';
        ?>
          <div class="remark-item">
            <div class="remark-dot" style="background:<?= $rsc ?>"></div>
            <div class="remark-body">
              <div class="remark-meta">
                <?= date('d M Y, h:i A', strtotime($rem['created_at'])) ?>
                <span class="remark-status" style="background:<?= $rsc ?>22;color:<?= $rsc ?>;border:1px solid <?= $rsc ?>55;">
                  <?= ucfirst($rem['status_at_time']) ?>
                </span>
              </div>
              <div class="remark-text"><?= nl2br(htmlspecialchars($rem['remark'])) ?></div>
            </div>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
