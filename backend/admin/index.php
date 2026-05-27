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
    $db = getDB();
    $modRights = [];
    try {
        $stmt = $db->prepare("SELECT university_rights, site_content_rights, exam_rights FROM mod_users WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $_SESSION['mod_id']);
            $stmt->execute();
            $modRights = $stmt->get_result()->fetch_assoc();
        }
    } catch (Exception $e) {
        
    }
} else {
    $isMod = false;
    $modRights = ['university_rights'=>1, 'site_content_rights'=>1, 'exam_rights'=>1];
    $db = getDB();
}

$currentSection = $_GET['section'] ?? 'dashboard';

if ($isMod) {
    $allowedSections = ['dashboard'];
    if (!empty($modRights['university_rights'])) $allowedSections[] = 'universities';
    if (!empty($modRights['site_content_rights'])) {
        array_push($allowedSections, 'content', 'images', 'testimonials', 'blog', 'footer', 'stats');
    }
    if (!empty($modRights['exam_rights'])) $allowedSections[] = 'exams';
    
    if (!in_array($currentSection, $allowedSections)) {
        die("<h2 style='font-family:sans-serif;padding:20px;'>You do not have permission to view this section.</h2>");
    }
}

$counts = [];
if ($currentSection === 'dashboard') {
    $tables = ['site_content', 'site_images', 'testimonials', 'blog_posts', 'universities', 'gallery_images'];
    foreach ($tables as $t) {
        $r = $db->query("SELECT COUNT(*) as c FROM `$t`");
        $counts[$t] = $r ? $r->fetch_assoc()['c'] : 0;
    }
    $r = $db->query("SELECT COUNT(*) as c FROM leads"); $counts['leads'] = $r ? $r->fetch_assoc()['c'] : 0;
    $r = $db->query("SELECT COUNT(*) as c FROM leads WHERE status='new'"); $counts['leads_new'] = $r ? $r->fetch_assoc()['c'] : 0;
    $r = $db->query("SELECT COUNT(*) as c FROM mod_users WHERE active=1"); $counts['mods'] = $r ? $r->fetch_assoc()['c'] : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Educationopedia CMS</title>
    <link rel="stylesheet" href="assets/style.css" />
</head>
<body>
<div class="admin-layout">
    
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h2>EDUCATION<span>OPEDIA</span></h2>
            <p>Content Management</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="?section=dashboard" class="<?= $currentSection === 'dashboard' ? 'active' : '' ?>"><span class="icon">📊</span> Dashboard</a></li>
            <?php if (!$isMod): ?>
            <li style="border-top:1px solid #334155;margin-top:8px;padding-top:8px;"><span style="font-size:10px;color:#475569;padding:0 16px;text-transform:uppercase;letter-spacing:.05em;">CRM</span></li>
            <li><a href="?section=leads" class="<?= $currentSection === 'leads' ? 'active' : '' ?>"><span class="icon">🎯</span> Leads <?php $nr=$db->query("SELECT COUNT(*) c FROM leads WHERE status='new'"); $nc=$nr?$nr->fetch_assoc()['c']:0; if($nc>0) echo "<span style='background:#ef4444;color:#fff;border-radius:10px;padding:1px 7px;font-size:10px;margin-left:4px;'>$nc</span>"; ?></a></li>
            <li><a href="?section=mods" class="<?= $currentSection === 'mods' ? 'active' : '' ?>"><span class="icon">👤</span> Mod Users</a></li>
            <?php endif; ?>
            <?php if (!empty($modRights['exam_rights'])): ?>
            <li><a href="manage_exams.php" class="<?= $currentSection === 'exams' ? 'active' : '' ?>"><span class="icon">🎓</span> Scholarship Exams</a></li>
            <?php endif; ?>
            
            <?php if (!empty($modRights['site_content_rights'])): ?>
            <li style="border-top:1px solid #334155;margin-top:8px;padding-top:8px;"><span style="font-size:10px;color:#475569;padding:0 16px;text-transform:uppercase;letter-spacing:.05em;">Content</span></li>
            <li><a href="?section=stats" class="<?= $currentSection === 'stats' ? 'active' : '' ?>"><span class="icon">📈</span> Stats</a></li>
            <li><a href="?section=content" class="<?= $currentSection === 'content' ? 'active' : '' ?>"><span class="icon">📝</span> Site Content</a></li>
            <li><a href="?section=images" class="<?= $currentSection === 'images' ? 'active' : '' ?>"><span class="icon">🖼️</span> Hero Slides</a></li>
            <li><a href="?section=testimonials" class="<?= $currentSection === 'testimonials' ? 'active' : '' ?>"><span class="icon">⭐</span> Testimonials</a></li>
            <li><a href="?section=footer" class="<?= $currentSection === 'footer' ? 'active' : '' ?>"><span class="icon">🔗</span> Footer & Contact</a></li>
            <?php endif; ?>

            <?php if (!empty($modRights['university_rights'])): ?>
            <li style="border-top:1px solid #334155;margin-top:8px;padding-top:8px;"><span style="font-size:10px;color:#475569;padding:0 16px;text-transform:uppercase;letter-spacing:.05em;">Academics</span></li>
            <li><a href="?section=universities" class="<?= $currentSection === 'universities' ? 'active' : '' ?>"><span class="icon">🏛️</span> Universities</a></li>
            <?php endif; ?>
        </ul>
        <div class="sidebar-bottom">
            <?php if ($isMod): ?>
            <a href="../mod/index.php">🔙 Mod Portal</a>
            <?php endif; ?>
            <a href="?action=logout">🚪 Logout</a>
        </div>
    </aside>

    
    <div class="main-content">
        <div id="toast-container"></div>

        <?php if (isset($_GET['action']) && $_GET['action'] === 'logout'): adminLogout(); header('Location: login.php'); exit; endif; ?>

        <?php if ($currentSection === 'dashboard'): ?>
        
        <div class="page-header">
            <div>
                <h1>Dashboard</h1>
                <p>Welcome back, <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?></p>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card" style="border-left:3px solid #6366f1;"><div class="value" style="color:#818cf8;"><?= $counts['leads'] ?></div><div class="label">Total Leads</div></div>
            <div class="stat-card" style="border-left:3px solid #ef4444;"><div class="value" style="color:#f87171;"><?= $counts['leads_new'] ?></div><div class="label">New Leads</div></div>
            <div class="stat-card" style="border-left:3px solid #22c55e;"><div class="value" style="color:#4ade80;"><?= $counts['mods'] ?></div><div class="label">Active Mods</div></div>
            <div class="stat-card"><div class="value"><?= $counts['testimonials'] ?></div><div class="label">Testimonials</div></div>
            <div class="stat-card"><div class="value"><?= $counts['blog_posts'] ?></div><div class="label">Blog Posts</div></div>
            <div class="stat-card"><div class="value"><?= $counts['universities'] ?></div><div class="label">Universities</div></div>
        </div>
        <div style="margin-top:16px;">
            <?php if (!$isMod): ?>
            <a href="?section=leads" class="btn btn-primary" style="margin-right:8px;">🎯 View All Leads</a>
            <a href="?section=mods" class="btn" style="background:#1e293b;color:#94a3b8;border:1px solid #334155;">👤 Manage Mod Users</a>
            <?php endif; ?>
        </div>

        <?php elseif ($currentSection === 'hero'): ?>
        
        <div class="page-header"><div><h1>Hero Section</h1><p>Edit the main hero text and CTAs</p></div></div>
        <?php
            $rows = $db->query("SELECT * FROM site_content WHERE section = 'hero' ORDER BY id");
            $heroData = [];
            while ($r = $rows->fetch_assoc()) $heroData[$r['content_key']] = $r;
        ?>
        <div class="card">
            <form id="heroForm" onsubmit="return saveContent(event, 'hero')">
                <?php foreach ($heroData as $key => $row): ?>
                <div class="form-group">
                    <label><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></label>
                    <?php if (strlen($row['content_value']) > 100): ?>
                        <textarea name="<?= htmlspecialchars($key) ?>" rows="3"><?= htmlspecialchars($row['content_value']) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($row['content_value']) ?>" />
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">💾 Save Hero Content</button>
            </form>
        </div>

        <?php elseif ($currentSection === 'stats'): ?>
        
        <div class="page-header"><div><h1>Statistics</h1><p>Edit the stat numbers shown on the homepage</p></div></div>
        <?php
            $rows = $db->query("SELECT * FROM site_content WHERE section = 'stats' ORDER BY content_key");
            $statsData = [];
            while ($r = $rows->fetch_assoc()) $statsData[$r['content_key']] = $r;
        ?>
        <div class="card">
            <form id="statsForm" onsubmit="return saveContent(event, 'stats')">
                <div class="form-row">
                    <?php foreach ($statsData as $key => $row): ?>
                    <div class="form-group">
                        <label><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></label>
                        <input type="text" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($row['content_value']) ?>" />
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">💾 Save Stats</button>
            </form>
        </div>

        <?php elseif ($currentSection === 'content'): ?>
        
        <div class="page-header"><div><h1>Site Content</h1><p>Edit all text content across the website</p></div></div>
        <?php
            $sections = $db->query("SELECT DISTINCT section FROM site_content ORDER BY section");
            $sectionList = [];
            while ($r = $sections->fetch_assoc()) $sectionList[] = $r['section'];
        ?>
        <?php foreach ($sectionList as $sec):
            $label = ucwords(str_replace('_', ' ', $sec));
            $hint = ($sec === 'why_us') ? ' (Home Page - Why Choose Us)' : ($sec === 'about' ? ' (About Page)' : '');
        ?>
        <div class="card">
            <div class="card-header"><h3>📝 <?= htmlspecialchars($label . $hint) ?></h3></div>
            <form onsubmit="return saveContent(event, '<?= htmlspecialchars($sec) ?>')">
                <?php
                    $rows = $db->query("SELECT * FROM site_content WHERE section = '" . $db->real_escape_string($sec) . "' ORDER BY id");
                    while ($r = $rows->fetch_assoc()):
                ?>
                <div class="form-group">
                    <label><?= htmlspecialchars(ucwords(str_replace('_', ' ', $r['content_key']))) ?></label>
                    <?php if (strlen($r['content_value']) > 100): ?>
                        <textarea name="<?= htmlspecialchars($r['content_key']) ?>" rows="3"><?= htmlspecialchars($r['content_value']) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?= htmlspecialchars($r['content_key']) ?>" value="<?= htmlspecialchars($r['content_value']) ?>" />
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
                <button type="submit" class="btn btn-primary">💾 Save <?= htmlspecialchars(ucwords($sec)) ?></button>
            </form>
        </div>
        <?php endforeach; ?>

        <?php elseif ($currentSection === 'images'): ?>
        
        <div class="page-header">
            <div><h1>Hero Slides</h1><p>Manage the hero carousel images</p></div>
            <label class="btn btn-primary" style="cursor:pointer;">
                📤 Upload Slide
                <input type="file" accept="image/*" onchange="uploadImage(this.files[0], 'hero_slides')" style="display:none;" />
            </label>
        </div>
        <div class="image-grid">
            <?php
                $images = $db->query("SELECT * FROM site_images WHERE section = 'hero_slides' ORDER BY sort_order");
                while ($img = $images->fetch_assoc()):
            ?>
            <div class="image-card" data-id="<?= $img['id'] ?>">
                <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="<?= htmlspecialchars($img['alt_text']) ?>" />
                <div class="overlay">
                    <button class="btn btn-sm btn-danger" onclick="deleteImage(<?= $img['id'] ?>)">🗑️</button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php elseif ($currentSection === 'testimonials'): ?>
        
        <div class="page-header">
            <div><h1>Testimonials</h1><p>Manage student reviews</p></div>
            <button class="btn btn-primary" onclick="document.getElementById('addTestimonialForm').style.display='block'">➕ Add Testimonial</button>
        </div>
        
        <div class="card" id="addTestimonialForm" style="display:none;">
            <div class="card-header"><h3>Add New Testimonial</h3></div>
            <form onsubmit="return addTestimonial(event)">
                <div class="form-row">
                    <div class="form-group"><label>Student Name</label><input type="text" name="name" required /></div>
                    <div class="form-group"><label>Course</label><input type="text" name="course" placeholder="e.g. MBBS in Russia" required /></div>
                </div>
                <div class="form-group"><label>Testimonial Text</label><textarea name="text" rows="3" required></textarea></div>
                <div class="form-row">
                    <div class="form-group"><label>Rating (1-5)</label><input type="number" name="rating" value="5" min="1" max="5" /></div>
                    <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="0" /></div>
                </div>
                <button type="submit" class="btn btn-success">✅ Add Testimonial</button>
            </form>
        </div>
        
        <div class="card">
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Course</th><th>Text</th><th>Rating</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                    $rows = $db->query("SELECT * FROM testimonials ORDER BY sort_order, id");
                    while ($t = $rows->fetch_assoc()):
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($t['name']) ?></strong></td>
                    <td><?= htmlspecialchars($t['course']) ?></td>
                    <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($t['text']) ?></td>
                    <td>⭐ <?= $t['rating'] ?></td>
                    <td class="actions">
                        <button class="btn btn-sm btn-danger" onclick="deleteItem('testimonials', <?= $t['id'] ?>)">🗑️</button>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($currentSection === 'blog'): ?>
        
        <div class="page-header">
            <div><h1>Blog Posts</h1><p>Manage blog articles</p></div>
            <button class="btn btn-primary" onclick="openBlogAdd()">➕ Add Post</button>
        </div>
        
        <div class="card" id="blogFormCard" style="display:none;">
            <div class="card-header"><h3 id="blogFormTitle">Add New Blog Post</h3></div>
            <form id="blogForm" onsubmit="return handleBlogSubmit(event)">
                <input type="hidden" name="id" id="blog_id" />
                <div class="form-group"><label>Title</label><input type="text" name="title" id="blog_title" required /></div>
                <div class="form-group"><label>Excerpt</label><textarea name="excerpt" id="blog_excerpt" rows="2" required></textarea></div>
                <div class="form-group"><label>Content (Full Article)</label><textarea name="content" id="blog_content" rows="6" placeholder="Use **bold** for headings..."></textarea></div>
                <div class="form-row">
                    <div class="form-group"><label>Category</label><input type="text" name="category" id="blog_category" /></div>
                    <div class="form-group"><label>Read Time</label><input type="text" name="read_time" id="blog_read_time" placeholder="5 min read" /></div>
                </div>
                <div class="form-group"><label>Image Path</label><input type="text" name="image_path" id="blog_image_path" placeholder="/blog-image.jpg" /></div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn btn-success" id="blogSubmitBtn">✅ Add Post</button>
                    <button type="button" class="btn btn-danger" onclick="closeBlogForm()">❌ Cancel</button>
                </div>
            </form>
        </div>

        <div class="card">
            <table class="admin-table">
                <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                    $rows = $db->query("SELECT * FROM blog_posts ORDER BY published_at DESC");
                    while ($b = $rows->fetch_assoc()):
                        
                        $jsData = json_encode($b);
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($b['title']) ?></strong></td>
                    <td><?= htmlspecialchars($b['category']) ?></td>
                    <td><?= $b['published_at'] ?></td>
                    <td class="actions">
                        <button class="btn btn-sm btn-primary" onclick='openBlogEdit(<?= htmlspecialchars($jsData, ENT_QUOTES) ?>)'>✏️</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteItem('blog', <?= $b['id'] ?>)">🗑️</button>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($currentSection === 'universities'): ?>
        
        <div class="page-header">
            <div><h1>Universities</h1><p>Manage university rankings by country</p></div>
            <button class="btn btn-primary" onclick="document.getElementById('addUniForm').style.display='block'">➕ Add University</button>
        </div>
        <div class="card" id="addUniForm" style="display:none;">
            <div class="card-header"><h3>Add New University</h3></div>
            <form onsubmit="return addUniversity(event)">
                <div class="form-row">
                    <div class="form-group"><label>Country</label><input type="text" name="country" required /></div>
                    <div class="form-group"><label>Rank</label><input type="number" name="rank" required /></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Full Name</label><input type="text" name="name" required /></div>
                    <div class="form-group"><label>Short Name</label><input type="text" name="short_name" required /></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>City</label><input type="text" name="city" required /></div>
                    <div class="form-group"><label>Flag Emoji</label><input type="text" name="flag" placeholder="🇷🇺" /></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Rating</label><input type="number" name="rating" step="0.1" value="4.5" /></div>
                    <div class="form-group"><label>Fees</label><input type="text" name="fees" placeholder="₹20–25 L" /></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Ranking Text</label><input type="text" name="ranking_text" /></div>
                    <div class="form-group"><label>Cutoff</label><input type="text" name="cutoff" /></div>
                </div>
                <div class="form-group"><label>Deadline</label><input type="text" name="deadline" /></div>
                <button type="submit" class="btn btn-success">✅ Add University</button>
            </form>
        </div>
        <?php
            
            $countriesResult = $db->query("SELECT DISTINCT country FROM universities ORDER BY country");
            $uniCountries = [];
            while ($r = $countriesResult->fetch_assoc()) $uniCountries[] = $r['country'];
            $activeCountry = $_GET['country'] ?? ($uniCountries[0] ?? 'Russia');
        ?>
        <div class="tabs">
            <?php foreach ($uniCountries as $c): ?>
                <a href="?section=universities&country=<?= urlencode($c) ?>" class="tab-btn <?= $activeCountry === $c ? 'active' : '' ?>"><?= htmlspecialchars($c) ?></a>
            <?php endforeach; ?>
        </div>
        <div class="card">
            <table class="admin-table">
                <thead><tr><th>#</th><th>University</th><th>City</th><th>Rating</th><th>Fees</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                    $stmt = $db->prepare("SELECT * FROM universities WHERE country = ? ORDER BY `rank`");
                    $stmt->bind_param('s', $activeCountry);
                    $stmt->execute();
                    $rows = $stmt->get_result();
                    while ($u = $rows->fetch_assoc()):
                ?>
                <tr>
                    <td><strong>#<?= $u['rank'] ?></strong></td>
                    <td><?= htmlspecialchars($u['name']) ?> [<?= htmlspecialchars($u['short_name']) ?>]</td>
                    <td><?= htmlspecialchars($u['city']) ?></td>
                    <td>⭐ <?= $u['rating'] ?></td>
                    <td><?= htmlspecialchars($u['fees']) ?></td>
                    <td class="actions">
                        <a href="university_detail.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-secondary" style="background:#475569;color:white;text-decoration:none;" target="_blank">👁️ View Details</a>
                        <button class="btn btn-sm btn-danger" onclick="deleteItem('universities', <?= $u['id'] ?>)">🗑️</button>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($currentSection === 'gallery'): ?>
        
        <div class="page-header">
            <div><h1>Gallery</h1><p>Manage gallery images</p></div>
            <label class="btn btn-primary" style="cursor:pointer;">
                📤 Upload Images
                <input type="file" accept="image/*" multiple onchange="uploadGalleryImages(this.files)" style="display:none;" />
            </label>
        </div>
        <div class="image-grid">
            <?php
                $images = $db->query("SELECT * FROM gallery_images ORDER BY sort_order, id");
                while ($img = $images->fetch_assoc()):
            ?>
            <div class="image-card">
                <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="<?= htmlspecialchars($img['alt_text']) ?>" loading="lazy" />
                <div class="overlay">
                    <button class="btn btn-sm btn-danger" onclick="deleteItem('gallery', <?= $img['id'] ?>)">🗑️</button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php elseif ($currentSection === 'footer'): ?>
        
        <div class="page-header"><div><h1>Footer & Contact Info</h1><p>Edit contact details, social links, and footer text</p></div></div>
        <?php
            $rows = $db->query("SELECT * FROM site_content WHERE section IN ('footer') ORDER BY section, id");
            $grouped = [];
            while ($r = $rows->fetch_assoc()) $grouped[$r['section']][$r['content_key']] = $r;
        ?>
        <?php foreach ($grouped as $sec => $items): ?>
        <div class="card">
            <div class="card-header"><h3><?= htmlspecialchars(ucwords(str_replace('_', ' ', $sec))) ?></h3></div>
            <form onsubmit="return saveContent(event, '<?= htmlspecialchars($sec) ?>')">
                <?php foreach ($items as $key => $row): ?>
                <div class="form-group">
                    <label><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></label>
                    <?php if (strlen($row['content_value']) > 100): ?>
                        <textarea name="<?= htmlspecialchars($key) ?>" rows="3"><?= htmlspecialchars($row['content_value']) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($row['content_value']) ?>" />
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">💾 Save <?= htmlspecialchars(ucwords($sec)) ?></button>
            </form>
        </div>
        <?php endforeach; ?>

        <?php elseif ($currentSection === 'leads'): ?>
        
        <?php
            
            $db->query("UPDATE leads SET pinned = 1 WHERE reminder_at IS NOT NULL AND reminder_at <= NOW() AND pinned = 0");

            $statusFilter = $_GET['status'] ?? '';
            $modFilter    = (int)($_GET['mod_id'] ?? 0);
            $allMods = $db->query("SELECT id, username, full_name FROM mod_users WHERE active=1 ORDER BY username")->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT l.*, mu.username as mod_username, mu.full_name as mod_name
                    FROM leads l LEFT JOIN mod_users mu ON mu.id = l.assigned_to";
            $where = [];
            if ($statusFilter) $where[] = "l.status = '" . $db->real_escape_string($statusFilter) . "'";
            if ($modFilter)    $where[] = "l.assigned_to = $modFilter";
            if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
            
            $sql .= ' ORDER BY l.pinned DESC, l.created_at DESC';
            $allLeads = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

            $statusColors = ['new'=>'#3b82f6','processing'=>'#f59e0b','positive'=>'#22c55e','negative'=>'#ef4444'];
            $statusIcons  = ['new'=>'🆕','processing'=>'⏳','positive'=>'✅','negative'=>'❌'];
        ?>
        <div class="page-header">
            <div><h1>Leads CRM</h1><p><?= count($allLeads) ?> lead(s) found</p></div>
            <div style="display:flex;gap:8px;">
                <button class="btn btn-success" onclick="togglePanel('addLeadPanel')">➕ Add Lead</button>
                <button class="btn btn-primary" onclick="togglePanel('csvPanel')" style="background:#0ea5e9;">📂 Import CSV</button>
            </div>
        </div>

        <div id="addLeadPanel" style="display:none;" class="card" style="margin-bottom:16px;">
            <div class="card-header"><h3>➕ Add Lead Manually</h3></div>
            <form onsubmit="return submitAddLead(event)">
                <div class="form-row">
                    <div class="form-group"><label>Name *</label><input type="text" id="al_name" required placeholder="Full Name"></div>
                    <div class="form-group"><label>Phone *</label><input type="tel" id="al_phone" required placeholder="+91 9876543210"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Email</label><input type="email" id="al_email" placeholder="email@example.com"></div>
                    <div class="form-group"><label>Country of Interest</label><input type="text" id="al_country" placeholder="Russia, Georgia..."></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Course</label><input type="text" id="al_course" placeholder="MBBS, BDS..."></div>
                    <div class="form-group"><label>Message / Notes</label><input type="text" id="al_message" placeholder="Any notes..."></div>
                </div>
                <button type="submit" class="btn btn-success">✅ Save Lead</button>
            </form>
        </div>

        <div id="csvPanel" style="display:none;" class="card" style="margin-bottom:16px;">
            <div class="card-header"><h3>📂 Import Leads via CSV</h3></div>
            <p style="color:#94a3b8;font-size:13px;margin-bottom:14px;">
                CSV must have a header row with columns: <code style="color:#818cf8;">name, phone, email, country, course, message</code> (only <b>name</b> and <b>phone</b> are required).
            </p>
            <a href="data:text/csv;charset=utf-8,name,phone,email,country,course,message%0AJohn%20Doe,9876543210,john@example.com,Russia,MBBS,Interested" download="leads_template.csv"
               style="font-size:12px;color:#818cf8;margin-bottom:14px;display:inline-block;">⬇ Download CSV Template</a>
            <div class="form-row">
                <div class="form-group">
                    <label>Upload CSV File</label>
                    <input type="file" id="csvFile" accept=".csv,text/csv">
                </div>
            </div>
            <button class="btn btn-primary" onclick="importCSV()" style="background:#0ea5e9;">Upload & Import</button>
            <span id="csvResult" style="margin-left:12px;font-size:13px;"></span>
        </div>
        
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px;align-items:center;">
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;">
                <input type="hidden" name="section" value="leads">
                <select name="status" onchange="this.form.submit()" style="background:#1e293b;border:1px solid #334155;color:#e2e8f0;padding:6px 12px;border-radius:8px;">
                    <option value="">All Statuses</option>
                    <?php foreach(['new','processing','positive','negative'] as $s): ?>
                    <option value="<?= $s ?>" <?= $statusFilter===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="mod_id" onchange="this.form.submit()" style="background:#1e293b;border:1px solid #334155;color:#e2e8f0;padding:6px 12px;border-radius:8px;">
                    <option value="">All Mods</option>
                    <option value="-1" <?= $modFilter===-1?'selected':'' ?>>Unassigned</option>
                    <?php foreach($allMods as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= $modFilter==$m['id']?'selected':'' ?>><?= htmlspecialchars($m['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="card" style="padding:0;">
            <table class="admin-table">
                <thead><tr><th>📌</th><th>Name</th><th>Phone</th><th>Email</th><th>Country</th><th>Status</th><th>Assigned To</th><th>Reminder</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach($allLeads as $lead):
                    $sc = $statusColors[$lead['status']] ?? '#64748b';
                    $si = $statusIcons[$lead['status']] ?? '•';
                    $isPinned = !empty($lead['pinned']);
                    $hasReminder = !empty($lead['reminder_at']);
                    $rowStyle = $isPinned ? 'background:rgba(245,158,11,.08);border-left:3px solid #f59e0b;' : '';
                ?>
                <tr style="<?= $rowStyle ?>">
                    <td style="text-align:center;">
                        <?php if ($isPinned): ?>
                        <span title="Pinned by reminder" style="font-size:18px;cursor:pointer;" onclick="unpinLead(<?= $lead['id'] ?>, this)">📌</span>
                        <?php else: ?>
                        <span style="color:#475569;font-size:14px;">—</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($lead['name']) ?></strong></td>
                    <td><a href="tel:<?= htmlspecialchars($lead['phone']) ?>" style="color:#818cf8;"><?= htmlspecialchars($lead['phone']) ?></a></td>
                    <td style="font-size:12px;"><?= htmlspecialchars($lead['email']) ?></td>
                    <td><?= htmlspecialchars($lead['country'] ?: '—') ?></td>
                    <td>
                        <span style="background:<?= $sc ?>22;color:<?= $sc ?>;border:1px solid <?= $sc ?>55;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;white-space:nowrap;">
                            <?= $si ?> <?= ucfirst($lead['status']) ?>
                        </span>
                    </td>
                    <td>
                        <select onchange="assignLead(<?= $lead['id'] ?>, this.value)" style="background:#1e293b;border:1px solid #334155;color:#e2e8f0;padding:4px 8px;border-radius:6px;font-size:12px;max-width:150px;">
                            <option value="">— Unassigned —</option>
                            <?php foreach($allMods as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= $lead['assigned_to']==$m['id']?'selected':'' ?>>
                                <?= htmlspecialchars($m['username']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td style="min-width:160px;">
                        <?php if ($hasReminder): ?>
                            <div style="font-size:11px;color:#f59e0b;font-weight:600;">⏰ <?= date('d M y H:i', strtotime($lead['reminder_at'])) ?></div>
                        <?php endif; ?>
                        <button onclick="openReminderModal(<?= $lead['id'] ?>, '<?= $lead['reminder_at'] ?? '' ?>')"
                                style="font-size:11px;background:#1e293b;border:1px solid #334155;color:#94a3b8;padding:3px 8px;border-radius:5px;cursor:pointer;margin-top:3px;">
                            <?= $hasReminder ? '✏️ Edit' : '⏰ Set' ?> Reminder
                        </button>
                    </td>
                    <td style="font-size:11px;color:#64748b;"><?= date('d M y', strtotime($lead['created_at'])) ?></td>
                    <td class="actions">
                        <button class="btn btn-sm btn-primary" onclick="viewLead(<?= $lead['id'] ?>)" title="View Details">👁️</button>
                        <a href="admission.php?lead_id=<?= $lead['id'] ?>" class="btn btn-sm" style="background:#10b981; color:#fff;" title="Admission Portal">🎓</a>
                        <button class="btn btn-sm btn-danger" onclick="deleteLead(<?= $lead['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($allLeads)): ?>
                <tr><td colspan="10" style="text-align:center;padding:40px;color:#475569;">No leads found. They will appear here when users submit the contact form.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div id="reminderModal" style="display:none;position:fixed;inset:0;background:#000b;z-index:2000;display:none;align-items:center;justify-content:center;">
            <div style="background:#1e293b;border:1px solid #334155;border-radius:14px;padding:28px;width:340px;max-width:95vw;">
                <h3 style="color:#f1f5f9;margin-bottom:16px;">⏰ Set Reminder</h3>
                <input type="hidden" id="reminderLeadId">
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px;color:#94a3b8;display:block;margin-bottom:6px;">Date & Time</label>
                    <input type="datetime-local" id="reminderDatetime"
                        style="width:100%;background:#0f172a;border:1px solid #334155;border-radius:8px;color:#e2e8f0;padding:10px;font-size:14px;">
                </div>
                <p style="font-size:11px;color:#64748b;margin-bottom:16px;">When this time arrives, the lead will be automatically 📌 pinned to the top of the list.</p>
                <div style="display:flex;gap:10px;">
                    <button onclick="saveReminder()" class="btn btn-success" style="flex:1;">✅ Save</button>
                    <button onclick="clearReminder()" class="btn btn-danger" style="flex:1;">🗑 Clear</button>
                    <button onclick="document.getElementById('reminderModal').style.display='none'" style="background:#334155;border:none;color:#94a3b8;padding:8px 14px;border-radius:8px;cursor:pointer;">Cancel</button>
                </div>
            </div>
        </div>

        <div id="leadModal" style="display:none;position:fixed;inset:0;background:#000a;z-index:1000;overflow-y:auto;">
            <div style="max-width:680px;margin:40px auto;background:#1e293b;border:1px solid #334155;border-radius:16px;padding:28px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <h2 id="modalLeadName" style="color:#f8fafc;font-size:18px;"></h2>
                    <button onclick="document.getElementById('leadModal').style.display='none'" style="background:#334155;border:none;color:#94a3b8;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;">✕</button>
                </div>
                <div id="modalLeadBody">Loading...</div>
            </div>
        </div>

        <?php elseif ($currentSection === 'mods'): ?>
        
        <?php 
            $allModsList = [];
            try {
                $res = $db->query("SELECT id, username, full_name, email, active, created_at, university_rights, site_content_rights, exam_rights FROM mod_users ORDER BY created_at DESC");
                if ($res) $allModsList = $res->fetch_all(MYSQLI_ASSOC);
            } catch (Exception $e) {
                $res = $db->query("SELECT id, username, full_name, email, active, created_at FROM mod_users ORDER BY created_at DESC");
                if ($res) $allModsList = $res->fetch_all(MYSQLI_ASSOC);
            }
        ?>
        <div class="page-header">
            <div><h1>Mod Users</h1><p>Create and manage moderator accounts</p></div>
            <button class="btn btn-primary" onclick="document.getElementById('addModForm').style.display='block'">➕ Create Mod User</button>
        </div>
        <div class="card" id="addModForm" style="display:none;">
            <div class="card-header"><h3>Create Mod User</h3></div>
            <form onsubmit="return createMod(event)">
                <div class="form-row">
                    <div class="form-group"><label>Username</label><input type="text" name="username" required placeholder="e.g. mod_akash"></div>
                    <div class="form-group"><label>Full Name</label><input type="text" name="full_name" placeholder="Akash Kumar"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Password (min 6 chars)</label><input type="password" name="password" required minlength="6"></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" placeholder="mod@example.com"></div>
                </div>
                <button type="submit" class="btn btn-success">✅ Create Mod</button>
            </form>
            
            <div id="modQrSection" style="display:none;margin-top:20px;padding:20px;background:#0f172a;border-radius:10px;text-align:center;">
                <p style="color:#22c55e;font-weight:600;margin-bottom:12px;">✅ Mod created! Scan this QR in Google Authenticator:</p>
                <img id="modQrImg" src="" alt="QR Code" style="border-radius:8px;max-width:200px;">
                <p style="color:#94a3b8;font-size:12px;margin-top:10px;">Secret: <code id="modSecret" style="color:#818cf8;"></code></p>
                <p style="color:#64748b;font-size:11px;margin-top:6px;">Mod portal: <strong style="color:#94a3b8;">http://localhost:8000/mod/login.php</strong></p>
            </div>
        </div>
        <div class="card" style="padding:0;">
            <table class="admin-table">
                <thead><tr><th>Username</th><th>Full Name</th><th>Email</th><th>Rights</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach($allModsList as $mod): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($mod['username']) ?></strong></td>
                    <td><?= htmlspecialchars($mod['full_name'] ?: '—') ?></td>
                    <td style="font-size:12px;"><?= htmlspecialchars($mod['email'] ?: '—') ?></td>
                    <td>
                        <label style="font-size:11px; cursor:pointer;"><input type="checkbox" onchange="toggleModRight(<?= $mod['id'] ?>,'university_rights')" <?= !empty($mod['university_rights']) ? 'checked' : '' ?>> Universities</label><br>
                        <label style="font-size:11px; cursor:pointer;"><input type="checkbox" onchange="toggleModRight(<?= $mod['id'] ?>,'site_content_rights')" <?= !empty($mod['site_content_rights']) ? 'checked' : '' ?>> Content</label><br>
                        <label style="font-size:11px; cursor:pointer;"><input type="checkbox" onchange="toggleModRight(<?= $mod['id'] ?>,'exam_rights')" <?= !empty($mod['exam_rights']) ? 'checked' : '' ?>> Exams</label>
                    </td>
                    <td>
                        <span style="background:<?= $mod['active'] ? '#16653422' : '#45090a22' ?>;color:<?= $mod['active'] ? '#4ade80' : '#f87171' ?>;border:1px solid <?= $mod['active'] ? '#22c55e44' : '#ef444444' ?>;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;">
                            <?= $mod['active'] ? '✅ Active' : '❌ Disabled' ?>
                        </span>
                    </td>
                    <td style="font-size:11px;color:#64748b;"><?= date('d M Y', strtotime($mod['created_at'])) ?></td>
                    <td class="actions">
                        <button class="btn btn-sm" onclick="toggleMod(<?= $mod['id'] ?>)" style="background:#1e3a5f;color:#93c5fd;border:1px solid #3b82f6;">
                            <?= $mod['active'] ? 'Disable' : 'Enable' ?>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($allModsList)): ?>
                <tr><td colspan="6" style="text-align:center;padding:40px;color:#475569;">No mod users yet. Create one above.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</div>

<script>
const API = 'api_admin.php';

function showToast(msg, type = 'success') {
    const el = document.createElement('div');
    el.className = `toast toast-${type}`;
    el.textContent = msg;
    document.getElementById('toast-container').appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

async function saveContent(e, section) {
    e.preventDefault();
    const form = e.target;
    const data = {};
    new FormData(form).forEach((v, k) => data[k] = v);

    const res = await fetch(API + '?action=update_content', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ section, data }),
        credentials: 'include'
    });
    const json = await res.json();
    showToast(json.success || json.error, json.error ? 'error' : 'success');
    return false;
}

async function uploadImage(file, section) {
    const fd = new FormData();
    fd.append('image', file);
    fd.append('section', section);
    const res = await fetch(API + '?action=upload_image', { method: 'POST', body: fd, credentials: 'include' });
    const json = await res.json();
    if (json.success) { showToast('Image uploaded!'); location.reload(); }
    else showToast(json.error, 'error');
}

async function uploadGalleryImages(files) {
    for (const file of files) {
        const fd = new FormData();
        fd.append('image', file);
        await fetch(API + '?action=upload_gallery', { method: 'POST', body: fd, credentials: 'include' });
    }
    showToast(`${files.length} image(s) uploaded!`);
    location.reload();
}

async function deleteImage(id) {
    if (!confirm('Delete this image?')) return;
    const res = await fetch(API + '?action=delete_image', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id }),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Deleted!'); location.reload(); }
    else showToast(json.error, 'error');
}

async function deleteItem(type, id) {
    if (!confirm('Delete this item?')) return;
    const res = await fetch(API + `?action=delete_${type}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id }),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Deleted!'); location.reload(); }
    else showToast(json.error, 'error');
}

async function addTestimonial(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    const data = Object.fromEntries(fd);
    const res = await fetch(API + '?action=add_testimonial', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Added!'); location.reload(); }
    else showToast(json.error, 'error');
    return false;
}

function openBlogAdd() {
    document.getElementById('blogFormCard').style.display='block';
    document.getElementById('blogFormTitle').textContent = 'Add New Blog Post';
    document.getElementById('blogSubmitBtn').textContent = '✅ Add Post';
    document.getElementById('blogForm').reset();
    document.getElementById('blog_id').value = '';
}

function openBlogEdit(data) {
    document.getElementById('blogFormCard').style.display='block';
    document.getElementById('blogFormTitle').textContent = 'Edit Blog Post';
    document.getElementById('blogSubmitBtn').textContent = '💾 Update Post';
    
    document.getElementById('blog_id').value = data.id;
    document.getElementById('blog_title').value = data.title;
    document.getElementById('blog_excerpt').value = data.excerpt;
    document.getElementById('blog_content').value = data.content || '';
    document.getElementById('blog_category').value = data.category;
    document.getElementById('blog_read_time').value = data.read_time;
    document.getElementById('blog_image_path').value = data.image_path;
}

function closeBlogForm() {
    document.getElementById('blogFormCard').style.display = 'none';
}

async function handleBlogSubmit(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    const data = Object.fromEntries(fd);
    const isEdit = data.id !== '';
    const action = isEdit ? 'update_blog' : 'add_blog';

    const res = await fetch(API + '?action=' + action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast(json.success); location.reload(); }
    else showToast(json.error, 'error');
    return false;
}

async function addUniversity(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    const data = Object.fromEntries(fd);
    const res = await fetch(API + '?action=add_university', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Added!'); location.reload(); }
    else showToast(json.error, 'error');
    return false;
}

async function assignLead(leadId, modId) {
    const res = await fetch(API + '?action=assign_lead', {
        method: 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ lead_id: leadId, mod_id: modId === '' ? null : modId }),
        credentials: 'include'
    });
    const json = await res.json();
    showToast(json.success || json.error, json.error ? 'error' : 'success');
}

function togglePanel(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

async function submitAddLead(e) {
    e.preventDefault();
    const body = {
        name:    document.getElementById('al_name').value.trim(),
        phone:   document.getElementById('al_phone').value.trim(),
        email:   document.getElementById('al_email').value.trim(),
        country: document.getElementById('al_country').value.trim(),
        course:  document.getElementById('al_course').value.trim(),
        message: document.getElementById('al_message').value.trim(),
    };
    const res  = await fetch(API + '?action=add_lead', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body), credentials:'include' });
    const json = await res.json();
    if (json.id) { showToast('Lead added! ID #' + json.id, 'success'); location.reload(); }
    else showToast(json.error || 'Error', 'error');
    return false;
}

async function importCSV() {
    const file = document.getElementById('csvFile').files[0];
    if (!file) { showToast('Please select a CSV file', 'error'); return; }
    const fd = new FormData(); fd.append('csv', file);
    document.getElementById('csvResult').textContent = '⏳ Importing…';
    const res  = await fetch(API + '?action=import_leads_csv', { method:'POST', body:fd, credentials:'include' });
    const json = await res.json();
    if (json.success) {
        document.getElementById('csvResult').innerHTML = `<span style="color:#22c55e">✅ Imported: ${json.imported} | Skipped: ${json.skipped}</span>`;
        setTimeout(() => location.reload(), 1500);
    } else {
        document.getElementById('csvResult').innerHTML = `<span style="color:#ef4444">❌ ${json.error}</span>`;
    }
}

function openReminderModal(leadId, currentReminder) {
    document.getElementById('reminderLeadId').value = leadId;
    if (currentReminder) {
        const dt = new Date(currentReminder.replace(' ', 'T'));
        const local = dt.getFullYear() + '-'
            + String(dt.getMonth()+1).padStart(2,'0') + '-'
            + String(dt.getDate()).padStart(2,'0') + 'T'
            + String(dt.getHours()).padStart(2,'0') + ':'
            + String(dt.getMinutes()).padStart(2,'0');
        document.getElementById('reminderDatetime').value = local;
    } else {
        document.getElementById('reminderDatetime').value = '';
    }
    const modal = document.getElementById('reminderModal');
    modal.style.display = 'flex';
}

async function saveReminder() {
    const leadId = document.getElementById('reminderLeadId').value;
    const dt     = document.getElementById('reminderDatetime').value;
    if (!dt) { showToast('Please pick a date & time', 'error'); return; }
    const res  = await fetch(API + '?action=set_reminder', {
        method:'POST', headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ lead_id: parseInt(leadId), reminder_at: dt }),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('⏰ Reminder saved!', 'success'); location.reload(); }
    else showToast(json.error || 'Error', 'error');
}

async function clearReminder() {
    const leadId = document.getElementById('reminderLeadId').value;
    const res  = await fetch(API + '?action=set_reminder', {
        method:'POST', headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ lead_id: parseInt(leadId), reminder_at: '' }),
        credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Reminder cleared', 'success'); location.reload(); }
    else showToast(json.error || 'Error', 'error');
}

async function unpinLead(leadId, el) {
    if (!confirm('Unpin and clear reminder for this lead?')) return;
    const res  = await fetch(API + '?action=unpin_lead', {
        method:'POST', headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ lead_id: leadId }), credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Lead unpinned', 'success'); location.reload(); }
    else showToast(json.error || 'Error', 'error');
}

async function deleteLead(id) {
    if (!confirm('Permanently delete this lead and all its remarks?')) return;
    const res = await fetch(API + '?action=delete_lead', {
        method: 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ id }), credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Lead deleted'); location.reload(); }
    else showToast(json.error, 'error');
}

async function viewLead(id) {
    document.getElementById('leadModal').style.display = 'block';
    document.getElementById('modalLeadBody').innerHTML = '<p style="color:#64748b;padding:20px;">Loading…</p>';
    const res = await fetch(API + '?action=lead_detail&id=' + id, { credentials: 'include' });
    const lead = await res.json();
    const statusColor = {new:'#3b82f6',processing:'#f59e0b',positive:'#22c55e',negative:'#ef4444'};
    const sc = statusColor[lead.status] || '#64748b';
    document.getElementById('modalLeadName').textContent = lead.name;
    const remarks = (lead.remarks || []).map(r => `
        <div style="display:flex;gap:10px;margin-bottom:12px;">
            <div style="width:8px;height:8px;border-radius:50%;background:${statusColor[r.status_at_time]||'#64748b'};flex-shrink:0;margin-top:6px;"></div>
            <div style="flex:1;background:#0f172a;border:1px solid #1e293b;border-radius:8px;padding:10px 14px;">
                <div style="font-size:11px;color:#475569;margin-bottom:4px;">${new Date(r.created_at).toLocaleString()} · <span style="color:${statusColor[r.status_at_time]||'#64748b'}">${r.status_at_time}</span></div>
                <div style="color:#cbd5e1;font-size:14px;">${r.remark.replace(/\n/g,'<br>')}</div>
            </div>
        </div>
    `).reverse().join('');
    document.getElementById('modalLeadBody').innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Phone</div><a href="tel:${lead.phone}" style="color:#818cf8;font-size:15px;">${lead.phone}</a></div>
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Email</div><a href="mailto:${lead.email}" style="color:#818cf8;font-size:15px;">${lead.email}</a></div>
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Country</div><span style="color:#f1f5f9;">${lead.country||'—'}</span></div>
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Course</div><span style="color:#f1f5f9;">${lead.course||'—'}</span></div>
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Status</div><span style="background:${sc}22;color:${sc};border:1px solid ${sc}55;border-radius:20px;padding:3px 10px;font-size:12px;font-weight:600;">${lead.status}</span></div>
            <div><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Assigned To</div><span style="color:#f1f5f9;">${lead.mod_username||'Unassigned'}</span></div>
            ${lead.message ? `<div style="grid-column:1/-1;"><div style="color:#64748b;font-size:11px;text-transform:uppercase;">Message</div><div style="color:#94a3b8;font-size:14px;margin-top:4px;">${lead.message.replace(/\n/g,'<br>')}</div></div>` : ''}
        </div>
        <div style="border-top:1px solid #334155;padding-top:16px;">
            <div style="color:#64748b;font-size:11px;text-transform:uppercase;margin-bottom:12px;">Remarks Timeline (${(lead.remarks||[]).length})</div>
            ${remarks || '<div style="color:#475569;font-size:13px;">No remarks added yet.</div>'}
        </div>
    `;
}

async function createMod(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    const data = Object.fromEntries(fd);
    const res = await fetch(API + '?action=create_mod', {
        method: 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify(data), credentials: 'include'
    });
    const json = await res.json();
    if (json.success) {
        showToast('Mod user created!');
        document.getElementById('modQrImg').src = json.qr_url;
        document.getElementById('modSecret').textContent = json.totp_secret;
        document.getElementById('modQrSection').style.display = 'block';
        e.target.reset();
    } else showToast(json.error, 'error');
    return false;
}

async function toggleModRight(id, rightField) {
    if (!confirm('Toggle this right for the mod user?')) return;
    try {
        const res = await fetch('api_admin.php?action=toggle_mod_right', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, right: rightField })
        });
        const data = await res.json();
        if (data.error) showToast(data.error, 'danger');
        else showToast(data.success);
    } catch(e) {
        showToast('Error', 'danger');
    }
}

async function toggleMod(id) {
    const res = await fetch(API + '?action=toggle_mod', {
        method: 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ id }), credentials: 'include'
    });
    const json = await res.json();
    if (json.success) { showToast('Status updated'); location.reload(); }
    else showToast(json.error, 'error');
}

function viewUniDetails(u) {
    document.getElementById('modalUniName').textContent = u.name;
    document.getElementById('modalUniSubtitle').textContent = '(' + u.short_name + ')';
    document.getElementById('modalUniLocation').textContent = u.city + ', ' + u.country;
    document.getElementById('modalUniFlag').textContent = u.flag || '🏫';
    document.getElementById('modalUniRanking').textContent = u.ranking_text || '—';
    document.getElementById('modalUniCutoff').textContent = u.cutoff || 'NEET Required';
    document.getElementById('modalUniDeadline').textContent = u.deadline || '—';
    document.getElementById('modalUniFees').textContent = u.fees || '—';
    document.getElementById('modalUniRating').textContent = '⭐ ' + u.rating;
    document.getElementById('modalUniRank').textContent = '#' + u.rank + ' in ' + u.country;

    document.getElementById('uniDetailsModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeUniModal() {
    document.getElementById('uniDetailsModal').style.display = 'none';
    document.body.style.overflow = '';
}
</script>

<div id="uniDetailsModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.8);z-index:9999;overflow:auto;padding:30px 16px;" onclick="if(event.target===this)closeUniModal()">
    <div style="background:#0f172a;max-width:860px;margin:0 auto;border-radius:14px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.6);">

        <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid #1e293b;background:#0a1120;">
            <span style="color:#94a3b8;font-size:13px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;">University Profile</span>
            <button onclick="closeUniModal()" style="background:rgba(255,255,255,0.08);border:none;color:#94a3b8;font-size:20px;width:32px;height:32px;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;">&times;</button>
        </div>

        <div style="background:linear-gradient(135deg,#166534,#15803d);padding:22px 24px;color:white;display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
            <div style="flex:1;">
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <h2 id="modalUniName" style="margin:0;font-size:22px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;line-height:1.3;">UNIVERSITY NAME</h2>
                    <span id="modalUniSubtitle" style="font-size:14px;opacity:.75;font-weight:400;">(SHORT)</span>
                </div>
                <div style="margin-top:10px;display:flex;align-items:center;gap:8px;font-size:14px;font-weight:600;">
                    <span style="color:#fca5a5;">📍</span>
                    <span id="modalUniLocation">City, Country</span>
                </div>
                <div style="margin-top:8px;display:flex;gap:12px;flex-wrap:wrap;">
                    <span style="background:rgba(255,255,255,.15);padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;" id="modalUniRank">#1 in Country</span>
                    <span style="background:rgba(255,255,255,.15);padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;" id="modalUniRating">⭐ 4.8</span>
                </div>
            </div>
            <div style="background:white;min-width:56px;height:56px;border-radius:10px;font-size:34px;display:flex;align-items:center;justify-content:center;flex-shrink:0;" id="modalUniFlag">🏫</div>
        </div>

        <div style="background:#f8fafc;padding:22px 24px;display:grid;grid-template-columns:1fr 1fr;gap:16px 32px;color:#1e293b;font-size:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">Country Ranking</span>
                <strong id="modalUniRanking">—</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">IELTS/PTE/TOEFL</span>
                <strong style="color:#2563eb;">NOT REQUIRED</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">NEET / Cutoff</span>
                <strong id="modalUniCutoff" style="text-align:right;max-width:200px;">—</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">Admission Deadline</span>
                <strong id="modalUniDeadline">—</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">WHO / NMC</span>
                <strong style="color:#16a34a;">✅ APPROVED</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">Teaching Medium</span>
                <strong>ENGLISH</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">Course Duration</span>
                <strong>6 YEARS</strong>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;padding-bottom:10px;">
                <span style="color:#64748b;font-weight:600;">Hostel</span>
                <strong>ON CAMPUS</strong>
            </div>
        </div>

        <div style="background:#00529B;color:white;text-align:center;padding:14px;font-size:18px;font-weight:800;letter-spacing:.5px;">
            ANNUAL FEE STRUCTURE 2026–27
        </div>

        <div style="padding:0 0 24px 0;background:#fff;overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;text-align:center;font-size:13.5px;">
                <thead>
                    <tr style="background:#f39c12;color:white;font-weight:700;">
                        <th style="padding:11px 14px;border:1px solid #fde68a;text-align:left;">Particular</th>
                        <th style="padding:11px 10px;border:1px solid #fde68a;">Annual Fee</th>
                        <th style="padding:11px 10px;border:1px solid #fde68a;">Hostel</th>
                        <th style="padding:11px 10px;border:1px solid #fde68a;">Food/Mess</th>
                        <th style="padding:11px 10px;border:1px solid #fde68a;">Visa/Medical</th>
                        <th style="padding:11px 10px;background:#2980b9;border:1px solid #7ec8e3;">Annual Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background:#f1f5f9;">
                        <td style="padding:11px 14px;border:1px solid #cbd5e1;font-weight:700;color:#00529B;text-align:left;">MBBS Programme</td>
                        <td style="padding:11px 10px;border:1px solid #cbd5e1;font-weight:700;" id="modalUniFees">—</td>
                        <td style="padding:11px 10px;border:1px solid #cbd5e1;">₹37,500</td>
                        <td style="padding:11px 10px;border:1px solid #cbd5e1;">$1,500</td>
                        <td style="padding:11px 10px;border:1px solid #cbd5e1;">₹25,000</td>
                        <td style="padding:11px 10px;border:1px solid #7ec8e3;background:#ebf8ff;font-weight:700;">As per fees</td>
                    </tr>
                    <tr>
                        <td style="padding:11px 14px;border:1px solid #cbd5e1;font-weight:700;color:#00529B;text-align:left;">1st Year OTC</td>
                        <td colspan="4" style="padding:11px 10px;border:1px solid #cbd5e1;color:#64748b;font-size:12px;text-align:center;">One-time charge: Invitation Letter, Admission, Rector Letter, Visa, Airport Pickup, Documentation</td>
                        <td style="padding:11px 10px;border:1px solid #7ec8e3;background:#ebf8ff;font-weight:700;">$2,000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="padding:14px 24px 20px;background:#f8fafc;border-top:1px solid #e2e8f0;">
            <p style="margin:0;font-size:11px;color:#64748b;line-height:1.6;">
                <strong>NOTE:</strong> Fee amounts shown are approximate per year. Final fees may vary with exchange rates (1 USD ≈ ₹90, 1 RUB ≈ ₹1). All Indian students must qualify NEET to be eligible. Contact the counsellor for a full year-by-year breakdown for this specific university.
            </p>
        </div>

    </div>
</div>

</body>
</html>
