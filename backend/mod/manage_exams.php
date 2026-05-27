<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth_mod.php';
requireMod();

$db = getDB();
$stmt = $db->prepare("SELECT exam_rights FROM mod_users WHERE id = ?");
$stmt->bind_param('i', $_SESSION['mod_id']);
$stmt->execute();
if (empty($stmt->get_result()->fetch_assoc()['exam_rights'])) {
    die("Permission denied.");
}

$tab = $_GET['tab'] ?? 'candidates';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['act'] ?? '';
    if ($act === 'add_question') {
        $q  = trim($_POST['question_text'] ?? '');
        $a  = trim($_POST['opt_a'] ?? '');
        $b  = trim($_POST['opt_b'] ?? '');
        $c  = trim($_POST['opt_c'] ?? '');
        $d  = trim($_POST['opt_d'] ?? '');
        $co = strtoupper(trim($_POST['correct_opt'] ?? ''));
        if ($q && $a && $b && $c && $d && in_array($co, ['A','B','C','D'])) {
            $st = $db->prepare("INSERT INTO exam_questions (question_text,opt_a,opt_b,opt_c,opt_d,correct_opt) VALUES (?,?,?,?,?,?)");
            $st->bind_param('ssssss', $q, $a, $b, $c, $d, $co);
            $st->execute();
        }
        header("Location: manage_exams.php?tab=questions"); exit;
    }
    if ($act === 'delete_question') {
        $qid = (int)($_POST['qid'] ?? 0);
        if ($qid) $db->query("DELETE FROM exam_questions WHERE id=$qid");
        header("Location: manage_exams.php?tab=questions"); exit;
    }
    if ($act === 'delete_candidate') {
        $cid = (int)($_POST['cid'] ?? 0);
        if ($cid) $db->query("DELETE FROM exam_candidates WHERE id=$cid");
        header("Location: manage_exams.php?tab=candidates"); exit;
    }
    if ($act === 'reset_candidate') {
        $cid = (int)($_POST['cid'] ?? 0);
        if ($cid) {
            $db->query("DELETE FROM exam_responses WHERE candidate_id=$cid");
            $db->query("UPDATE exam_candidates SET status='registered', score=0, start_time=NULL, end_time=NULL WHERE id=$cid");
        }
        header("Location: manage_exams.php?tab=candidates"); exit;
    }
}

$candidates = $db->query("SELECT * FROM exam_candidates ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$questions  = $db->query("SELECT * FROM exam_questions ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
$totalCands = count($candidates);
$completed  = count(array_filter($candidates, fn($c) => $c['status'] === 'completed'));
$started    = count(array_filter($candidates, fn($c) => $c['status'] === 'started'));
$avgScore   = $completed > 0 ? round(array_sum(array_column(array_filter($candidates, fn($c)=>$c['status']==='completed'), 'score')) / $completed, 1) : 0;
$totalQ     = count($questions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Admin — Educationopedia</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', Arial, sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; }

/* Layout */
.layout { display: flex; min-height: 100vh; }
.sidebar { width: 240px; background: #1e293b; border-right: 1px solid #334155; display: flex; flex-direction: column; flex-shrink: 0; }
.main { flex: 1; overflow-y: auto; }

/* Sidebar */
.sb-logo { padding: 24px 20px 16px; border-bottom: 1px solid #334155; }
.sb-logo h2 { font-size: 16px; color: #f8fafc; letter-spacing: .5px; }
.sb-logo h2 span { color: #818cf8; }
.sb-logo p { font-size: 11px; color: #64748b; margin-top: 2px; }
.sb-nav { padding: 12px 0; flex: 1; }
.sb-nav a {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 20px; text-decoration: none; color: #94a3b8;
  font-size: 14px; font-weight: 500; transition: all .15s;
}
.sb-nav a:hover { background: #0f172a; color: #e2e8f0; }
.sb-nav a.active { background: #312e81; color: #c7d2fe; border-right: 3px solid #818cf8; }
.sb-footer { padding: 16px 20px; border-top: 1px solid #334155; }
.sb-footer a { font-size: 12px; color: #ef4444; text-decoration: none; }

/* Header */
.header { background: #1e293b; border-bottom: 1px solid #334155; padding: 16px 28px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 18px; color: #f1f5f9; }
.header p { font-size: 12px; color: #64748b; }

/* Stats grid */
.stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; padding: 24px 28px 0; }
.stat-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 18px 20px; }
.stat-card .label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 6px; }
.stat-card .value { font-size: 28px; font-weight: 800; color: #818cf8; }
.stat-card .sub { font-size: 11px; color: #475569; margin-top: 2px; }

/* Content */
.content { padding: 24px 28px; }

/* Table */
.tbl-wrap { overflow-x: auto; border-radius: 10px; border: 1px solid #334155; }
table { width: 100%; border-collapse: collapse; font-size: 13px; }
thead th { background: #1e293b; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; padding: 11px 14px; text-align: left; }
tbody tr { border-bottom: 1px solid #1e293b; }
tbody tr:hover { background: #1e293b55; }
tbody td { padding: 10px 14px; color: #cbd5e1; }
tbody tr:last-child { border-bottom: none; }

/* Badges */
.badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.badge-ok { background: #052e16; color: #86efac; }
.badge-warn { background: #1c1917; color: #fbbf24; }
.badge-blue { background: #172554; color: #93c5fd; }

/* Buttons */
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: opacity .2s; text-decoration: none; }
.btn:hover { opacity: .8; }
.btn-primary { background: #6366f1; color: #fff; }
.btn-danger  { background: #dc2626; color: #fff; }
.btn-warn    { background: #d97706; color: #fff; }
.btn-sm { padding: 4px 10px; font-size: 11px; }

/* Form */
.form-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
.form-card h3 { font-size: 15px; color: #e2e8f0; margin-bottom: 18px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group label { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; font-weight: 600; }
.form-group input, .form-group select, .form-group textarea {
  background: #0f172a; border: 1px solid #334155; border-radius: 7px;
  color: #e2e8f0; font-size: 13px; padding: 8px 12px; outline: none; width: 100%;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #6366f1; }
.form-full { grid-column: 1 / -1; }

/* Scores */
.score-bar-wrap { width: 80px; display: inline-flex; align-items: center; gap: 6px; }
.score-bar { height: 6px; border-radius: 3px; background: #6366f1; display: inline-block; }
.score-bg  { width: 60px; height: 6px; background: #1e293b; border-radius: 3px; overflow: hidden; }

/* Section title */
.section-title { font-size: 16px; font-weight: 700; color: #f1f5f9; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }

@media(max-width:700px) {
  .sidebar { display: none; }
  .stats { grid-template-columns: 1fr 1fr; }
  .form-grid { grid-template-columns: 1fr; }
}
<?php if (isset($_GET['embed'])): ?>
.sidebar { display: none !important; }
.header { display: none !important; }
.stats { padding-top: 10px !important; }
<?php endif; ?>
</style>
</head>
<body>
<div class="layout">

  <aside class="sidebar">
    <div class="sb-logo">
      <h2>EDUCATION<span>OPEDIA</span></h2>
      <p>Exam Admin Panel</p>
    </div>
    <nav class="sb-nav">
      <a href="cms.php" style="color:#ef4444;">🔙 Back to Mod CMS</a>

      <a href="?tab=candidates" class="<?= $tab==='candidates'?'active':'' ?>">👥 Candidates</a>
      <a href="?tab=results"    class="<?= $tab==='results'   ?'active':'' ?>">📊 Results</a>
      <a href="?tab=questions"  class="<?= $tab==='questions' ?'active':'' ?>">❓ Questions</a>
    </nav>
    <div class="sb-footer">
      
    </div>
  </aside>

  <div class="main">
    <div class="header">
      <div>
        <h1>🎓 Scholarship Exam Panel</h1>
        <p>Manage candidates, questions & results</p>
      </div>
      <a href="cms.php" class="btn btn-danger btn-sm">Exit</a>
    </div>

    <div class="stats">
      <div class="stat-card">
        <div class="label">Total Candidates</div>
        <div class="value"><?= $totalCands ?></div>
        <div class="sub">registered</div>
      </div>
      <div class="stat-card">
        <div class="label">Completed</div>
        <div class="value"><?= $completed ?></div>
        <div class="sub">submitted exam</div>
      </div>
      <div class="stat-card">
        <div class="label">In Progress</div>
        <div class="value"><?= $started ?></div>
        <div class="sub">currently active</div>
      </div>
      <div class="stat-card">
        <div class="label">Avg Score</div>
        <div class="value"><?= $avgScore ?></div>
        <div class="sub">out of <?= $totalQ ?> questions</div>
      </div>
      <div class="stat-card">
        <div class="label">Questions</div>
        <div class="value"><?= $totalQ ?></div>
        <div class="sub">in question bank</div>
      </div>
    </div>

    <div class="content">

      <?php if ($tab === 'candidates'): ?>
        <div class="section-title">
          <span>All Candidates</span>
          <span style="font-size:12px;color:#64748b;"><?= $totalCands ?> total</span>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th><th>Name</th><th>Email</th><th>Phone</th>
                <th>City/State</th><th>NEET</th><th>Status</th>
                <th>Registered</th><th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($candidates)): ?>
                <tr><td colspan="9" style="text-align:center;padding:30px;color:#475569;">No candidates yet.</td></tr>
              <?php endif; ?>
              <?php foreach ($candidates as $c): ?>
              <tr>
                <td><?= $c['id'] ?></td>
                <td>
                  <div style="font-weight:600;color:#e2e8f0;"><?= htmlspecialchars($c['name']) ?></div>
                  <?php if ($c['photo_path']): ?>
                    <a href="<?= htmlspecialchars($c['photo_path']) ?>" target="_blank" style="font-size:10px;color:#818cf8;">View Photo</a>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['city'].', '.$c['state']) ?></td>
                <td>
                  <div style="font-size:11px;"><?= htmlspecialchars($c['neet_status'] ?? 'N/A') ?></div>
                  <div style="color:#818cf8;font-size:11px;"><?= htmlspecialchars($c['neet_score'] ?? '') ?></div>
                </td>
                <td>
                  <?php
                  $bClass = match($c['status']) {
                    'completed' => 'badge-ok',
                    'started'   => 'badge-warn',
                    default     => 'badge-blue'
                  };
                  ?>
                  <span class="badge <?= $bClass ?>"><?= ucfirst($c['status']) ?></span>
                </td>
                <td style="font-size:11px;"><?= date('d M Y', strtotime($c['created_at'])) ?></td>
                <td>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Reset this candidate\'s exam?')">
                    <input type="hidden" name="act" value="reset_candidate">
                    <input type="hidden" name="cid" value="<?= $c['id'] ?>">
                    <button class="btn btn-warn btn-sm" type="submit">Reset</button>
                  </form>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this candidate?')">
                    <input type="hidden" name="act" value="delete_candidate">
                    <input type="hidden" name="cid" value="<?= $c['id'] ?>">
                    <button class="btn btn-danger btn-sm" type="submit">Del</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($tab === 'results'): ?>
        <div class="section-title"><span>Exam Results</span></div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th>Rank</th><th>Name</th><th>Email</th><th>Score</th>
                <th>Start Time</th><th>End Time</th><th>Duration</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $done = array_filter($candidates, fn($c) => $c['status'] === 'completed');
              usort($done, fn($a,$b) => $b['score'] <=> $a['score']);
              $rank = 1;
              if (empty($done)): ?>
                <tr><td colspan="7" style="text-align:center;padding:30px;color:#475569;">No completed exams yet.</td></tr>
              <?php endif; ?>
              <?php foreach ($done as $c): ?>
              <?php
              $pct = $totalQ > 0 ? round($c['score'] / $totalQ * 100) : 0;
              $dur = '';
              if ($c['start_time'] && $c['end_time']) {
                $diff = (strtotime($c['end_time']) - strtotime($c['start_time']));
                $dur = sprintf('%dm %ds', intdiv($diff, 60), $diff % 60);
              }
              ?>
              <tr>
                <td style="font-weight:800;color:#818cf8;">#<?= $rank++ ?></td>
                <td style="font-weight:600;color:#e2e8f0;"><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td>
                  <div style="font-weight:800;color:#86efac;"><?= $c['score'] ?> / <?= $totalQ ?></div>
                  <div class="score-bg">
                    <div class="score-bar" style="width:<?= $pct ?>%;"></div>
                  </div>
                  <div style="font-size:10px;color:#64748b;"><?= $pct ?>%</div>
                </td>
                <td style="font-size:11px;"><?= $c['start_time'] ? date('d M H:i', strtotime($c['start_time'])) : '—' ?></td>
                <td style="font-size:11px;"><?= $c['end_time']   ? date('d M H:i', strtotime($c['end_time'])) : '—' ?></td>
                <td style="font-size:11px;"><?= $dur ?: '—' ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($tab === 'questions'): ?>

        <div class="form-card">
          <h3>➕ Add New Question</h3>
          <form method="POST">
            <input type="hidden" name="act" value="add_question">
            <div class="form-grid">
              <div class="form-group form-full">
                <label>Question Text</label>
                <textarea name="question_text" rows="2" required placeholder="Enter the question…"></textarea>
              </div>
              <div class="form-group"><label>Option A</label><input name="opt_a" required placeholder="Option A"></div>
              <div class="form-group"><label>Option B</label><input name="opt_b" required placeholder="Option B"></div>
              <div class="form-group"><label>Option C</label><input name="opt_c" required placeholder="Option C"></div>
              <div class="form-group"><label>Option D</label><input name="opt_d" required placeholder="Option D"></div>
              <div class="form-group">
                <label>Correct Answer</label>
                <select name="correct_opt" required>
                  <option value="">Select…</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                </select>
              </div>
              <div class="form-group" style="justify-content:flex-end;">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary">Add Question</button>
              </div>
            </div>
          </form>
        </div>

        <div class="section-title">
          <span>Question Bank (<?= $totalQ ?>)</span>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr><th>#</th><th>Question</th><th>A</th><th>B</th><th>C</th><th>D</th><th>Correct</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php if (empty($questions)): ?>
                <tr><td colspan="8" style="text-align:center;padding:30px;color:#475569;">No questions yet.</td></tr>
              <?php endif; ?>
              <?php foreach ($questions as $i => $q): ?>
              <tr>
                <td style="color:#64748b;"><?= $q['id'] ?></td>
                <td style="max-width:260px;"><?= htmlspecialchars($q['question_text']) ?></td>
                <td style="font-size:12px;"><?= htmlspecialchars($q['opt_a']) ?></td>
                <td style="font-size:12px;"><?= htmlspecialchars($q['opt_b']) ?></td>
                <td style="font-size:12px;"><?= htmlspecialchars($q['opt_c']) ?></td>
                <td style="font-size:12px;"><?= htmlspecialchars($q['opt_d']) ?></td>
                <td><span class="badge badge-ok"><?= htmlspecialchars($q['correct_opt']) ?></span></td>
                <td>
                  <form method="POST" onsubmit="return confirm('Delete question #<?= $q['id'] ?>?')">
                    <input type="hidden" name="act" value="delete_question">
                    <input type="hidden" name="qid" value="<?= $q['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
