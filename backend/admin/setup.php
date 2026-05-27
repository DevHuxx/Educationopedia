<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php'; require_once __DIR__ . '/auth.php'; $message = ''; $qrUrl = ''; $totpSecret = ''; $error = ''; $alreadySetup = false; try { $db = getDB(); $result = $db->query("SELECT COUNT(*) as cnt FROM admin_users"); if ($result) { $row = $result->fetch_assoc(); if ((int)$row['cnt'] > 0) { $alreadySetup = true; } } } catch (Exception $e) { } if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$alreadySetup) { try { $db = new mysqli(DB_HOST, DB_USER, DB_PASS); if ($db->connect_error) { throw new Exception("Database connection failed: " . $db->connect_error); } $db->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`"); if (!$db->select_db(DB_NAME)) { throw new Exception("Failed to select database: " . $db->error); } $sqlPath = __DIR__ . '/../setup.sql'; if (!file_exists($sqlPath)) { throw new Exception("Schema file not found at: " . $sqlPath); } $sql = file_get_contents($sqlPath); if ($sql === false) { throw new Exception("Failed to read schema file."); } $db->multi_query($sql); while ($db->next_result()) { $db->store_result(); } $username = 'admin'; $password = 'admin123'; $hash = password_hash($password, PASSWORD_BCRYPT); $totpSecret = TOTP::generateSecret(); $stmt = $db->prepare("INSERT INTO admin_users (username, password_hash, totp_secret) VALUES (?, ?, ?)"); $stmt->bind_param('sss', $username, $hash, $totpSecret); $stmt->execute(); $contentSeeds = [ ['hero', 'badge_text', 'Trusted by 1,500+ Indian Families'], ['hero', 'title_line1', "Your Parents'"], ['hero', 'title_highlight', 'Proudest Moment'], ['hero', 'title_line3', 'Starts Here.'], ['hero', 'subtitle', 'NMC & WHO approved universities across 45+ countries. From NEET counselling to visa, hostel & graduation — we walk with you every single step.'], ['hero', 'cta_primary', 'Explore Universities'], ['hero', 'cta_secondary', 'Book Free Counselling'], ['hero', 'search_placeholder', 'Search universities, courses, countries...'], ['hero', 'tags', 'MBBS Abroad,Low Cost MBBS,Study in Russia,NMC Approved,NEET Counselling'], ['stats', 'stat_1_value', '10+'], ['stats', 'stat_1_label', 'Years Experience'], ['stats', 'stat_2_value', '1500+'], ['stats', 'stat_2_label', 'Students Placed'], ['stats', 'stat_3_value', '2000+'], ['stats', 'stat_3_label', 'Partner Universities'], ['stats', 'stat_4_value', '40+'], ['stats', 'stat_4_label', 'Countries'], ['why_us', 'title', "We Don't Just Place Students — We Fulfil Family Dreams"], ['why_us', 'subtitle', 'Every parent deserves to see their child in a white coat. We make that happen — honestly, affordably, and with care that feels personal because it is.'], ['why_us', 'points', "Only NMC & WHO Approved Universities — Zero Risk
Complete Journey: Application → Visa → Hostel → Graduation
Honest Fees — No Hidden Charges, No Surprises
Scholarship Guidance That Actually Saves Lakhs
24/7 Student Helpline Even After You Land Abroad
Pre-departure Orientation So You're Never Alone"], ['cta', 'title', 'Your Child Deserves a White Coat'], ['cta', 'subtitle', "Don't let NEET scores or high fees end the dream. Talk to our experts who have already helped 1,500+ students become doctors abroad — 100% free, zero pressure."], ['cta', 'phone', '+91 85913 42044'], ['footer', 'description', "India's #1 MBBS Abroad Consultancy. Your trusted partner for studying medicine abroad with expert guidance and complete support from admission to graduation."], ['footer', 'address', 'Office No- 1103, 11th Floor, GDITL Tower, B-08, Block- C, Netaji Subhash Place, Pitampura, New Delhi - 110034'], ['footer', 'phone_1', '+91 85913 42044'], ['footer', 'phone_2', '+91 91391 73733'], ['footer', 'phone_3', '+91 98219 64939'], ['footer', 'phone_4', '+91 95990 44332'], ['footer', 'email_1', 'admissions@educationopedia.com'], ['footer', 'email_2', 'contact@educationopedia.com'], ['footer', 'facebook', '#'], ['footer', 'instagram', '#'], ['footer', 'twitter', '#'], ['footer', 'linkedin', '#'], ['footer', 'youtube', '#'], ['about', 'title', 'About Educationopedia — Your Trusted MBBS Abroad Consultancy'], ['about', 'subtitle', 'Helping Indian students achieve their dream of becoming doctors through affordable, transparent, and end-to-end study abroad guidance since 2015.'], ['about', 'story_title', 'Empowering 1,500+ Students to Study MBBS Abroad Since 2015'], ['about', 'story_p1', 'Educationopedia was founded with a simple yet powerful mission — to make quality international medical education accessible to every deserving Indian student. Over the past decade, we have guided thousands of families through the complex journey of studying MBBS abroad, turning NEET disappointments into white coat celebrations.'], ['about', 'story_p2', 'Our experienced education counsellors provide personalized, honest guidance at every step — from choosing the right NMC & WHO approved university to visa processing, hostel allotment, and post-arrival support in 45+ countries. We believe that geography and finances should never be a barrier to becoming a doctor.'], ['contact', 'title', 'Contact Us'], ['contact', 'subtitle', 'Get free expert counselling for your MBBS abroad journey'], ]; $stmt = $db->prepare("INSERT INTO site_content (section, content_key, content_value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE content_value = VALUES(content_value)"); foreach ($contentSeeds as $seed) { $stmt->bind_param('sss', $seed[0], $seed[1], $seed[2]); $stmt->execute(); } $heroSlides = [ ['hero_slides', 'slide-1', '/clgs/slide-1.jpg', 'Students at a top university campus', 'World-Class Universities', 1], ['hero_slides', 'slide-2', '/clgs/slide-2.jpg', 'Medical students in a lecture hall', 'MBBS Abroad Programs', 2], ['hero_slides', 'slide-3', '/clgs/slide-3.jpg', 'University campus abroad', 'NMC & WHO Approved', 3], ['hero_slides', 'slide-4', '/clgs/slide-4.jpg', 'Indian students studying abroad', '1,500+ Dreams Fulfilled', 4], ]; $stmt = $db->prepare("INSERT INTO site_images (section, image_key, image_path, alt_text, label, sort_order) VALUES (?, ?, ?, ?, ?, ?)"); foreach ($heroSlides as $s) { $stmt->bind_param('sssssi', $s[0], $s[1], $s[2], $s[3], $s[4], $s[5]); $stmt->execute(); } $testimonials = [ ["Priya Sharma", "MBBS in Russia", "My father sold his shop to fund my education. Educationopedia found me a university where the total cost was half of what private colleges in India charge. Today I'm a practicing doctor — Papa's sacrifice was worth it.", 5], ["Rahul Verma", "MBBS in Kazakhstan", "I scored just 320 in NEET. Everyone said 'medical nahi hoga.' Educationopedia showed me a path. Now I'm in my final year at a WHO-approved university. Never give up on your dream.", 5], ["Anita Patel", "MBBS in Georgia", "As a girl from a small town, studying abroad felt impossible. The team handled everything — from documents to hostel. My mother cried happy tears at the airport. Thank you, Educationopedia.", 5], ["Vikram Singh", "MBBS in China", "I was confused between 10 consultancies. Educationopedia was the only one that didn't pressure me. They gave honest advice, helped me choose the right university, and even called my parents to reassure them.", 5], ["Sneha Reddy", "MBBS in Kyrgyzstan", "Coming from a middle-class family, the fees were my biggest worry. Educationopedia helped me get a scholarship that reduced my cost by 40%. My parents still can't believe it happened.", 5], ["Arjun Mehta", "MBBS in Uzbekistan", "The visa process scared me the most. But the Educationopedia team was with me at every step — they even helped me prepare for the embassy interview. I cleared it in one attempt!", 5], ]; $stmt = $db->prepare("INSERT INTO testimonials (name, course, text, rating, sort_order) VALUES (?, ?, ?, ?, ?)"); $order = 1; foreach ($testimonials as $t) { $stmt->bind_param('sssii', $t[0], $t[1], $t[2], $t[3], $order); $stmt->execute(); $order++; } $blogs = [ ["Top 10 Countries for MBBS Abroad in 2025", "Discover the most popular and affordable destinations for pursuing MBBS abroad with recognized degrees.", "MBBS Abroad", "5 min read", "/blog-mbbs-abroad.jpg", "2026-03-28"], ["NEET Score Requirements for Studying MBBS Abroad", "Complete guide on minimum NEET scores required for admission in different countries for Indian students.", "Admissions", "4 min read", "/blog-neet-score.jpg", "2026-03-25"], ["Scholarship Opportunities for Indian Students Abroad", "Explore various scholarship programs available for Indian students seeking international education.", "Scholarships", "6 min read", "/blog-scholarship.jpg", "2026-03-20"], ]; $stmt = $db->prepare("INSERT INTO blog_posts (title, excerpt, category, read_time, image_path, published_at) VALUES (?, ?, ?, ?, ?, ?)"); foreach ($blogs as $b) { $stmt->bind_param('ssssss', $b[0], $b[1], $b[2], $b[3], $b[4], $b[5]); $stmt->execute(); } $stmt = $db->prepare("INSERT INTO gallery_images (image_path, alt_text, sort_order) VALUES (?, ?, ?)"); for ($i = 11; $i <= 49; $i++) { $path = "/gallery/Untitled design ($i).png"; $alt = "Gallery Image $i"; $stmt->bind_param('ssi', $path, $alt, $i); $stmt->execute(); } $qrUrl = TOTP::getQRCodeUrl('admin', $totpSecret); $message = 'Setup completed successfully!'; $alreadySetup = true; } catch (Exception $e) { $error = 'Setup failed: ' . $e->getMessage(); } } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup — Educationopedia CMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 48px; max-width: 520px; width: 100%; margin: 20px; }
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #f1f5f9; }
        .subtitle { color: #94a3b8; font-size: 14px; margin-bottom: 32px; }
        .btn { display: inline-block; background: #3b82f6; color: #fff; border: none; padding: 14px 32px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; width: 100%; text-align: center; transition: background 0.2s; }
        .btn:hover { background: #2563eb; }
        .btn:disabled { background: #475569; cursor: not-allowed; }
        .success { background: #065f46; border: 1px solid #10b981; border-radius: 10px; padding: 16px; margin-bottom: 24px; }
        .success h3 { color: #6ee7b7; margin-bottom: 8px; }
        .error { background: #7f1d1d; border: 1px solid #ef4444; border-radius: 10px; padding: 16px; margin-bottom: 24px; color: #fca5a5; }
        .creds { background: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: 16px; margin: 16px 0; font-family: monospace; font-size: 14px; }
        .creds span { color: #fbbf24; }
        .qr-box { text-align: center; margin: 24px 0; }
        .qr-box img { border-radius: 12px; border: 4px solid #334155; }
        .qr-box p { margin-top: 12px; font-size: 13px; color: #94a3b8; }
        .secret-code { font-family: monospace; font-size: 16px; color: #fbbf24; letter-spacing: 2px; background: #0f172a; padding: 8px 16px; border-radius: 6px; display: inline-block; margin-top: 8px; border: 1px solid #334155; user-select: all; }
        .warn { background: #78350f; border: 1px solid #f59e0b; border-radius: 10px; padding: 14px; margin-top: 20px; font-size: 13px; color: #fde68a; }
        .already { text-align: center; }
        .already a { color: #60a5fa; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
<div class="card">
    <?php if ($message && $qrUrl): ?>
        <div class="success">
            <h3>✅ <?= htmlspecialchars($message) ?></h3>
            <p>Database tables created and initial data seeded.</p>
        </div>

        <h1>Admin Credentials</h1>
        <div class="creds">
            <div>Username: <span>admin</span></div>
            <div>Password: <span>admin123</span></div>
        </div>

        <h1 style="margin-top: 24px;">Google Authenticator Setup</h1>
        <p class="subtitle">Scan this QR code with your Google Authenticator app:</p>

        <div class="qr-box">
            <img src="<?= htmlspecialchars($qrUrl) ?>" alt="QR Code" width="250" height="250" />
            <p>Can't scan? Enter this secret manually:</p>
            <div class="secret-code"><?= htmlspecialchars($totpSecret) ?></div>
        </div>

        <div class="warn">
            ⚠️ <strong>Save this secret!</strong> You won't see it again. If you lose access to your authenticator, you'll need to reset the database.
        </div>

        <a href="login.php" class="btn" style="margin-top: 24px; display: block; text-decoration: none; text-align: center;">
            Go to Login →
        </a>

    <?php elseif ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <form method="POST"><button type="submit" class="btn">Retry Setup</button></form>

    <?php elseif ($alreadySetup): ?>
        <div class="already">
            <h1>✅ Already Set Up</h1>
            <p class="subtitle" style="margin-bottom: 24px;">The CMS database is already configured.</p>
            <a href="login.php">Go to Login →</a>
        </div>

    <?php else: ?>
        <h1>🚀 Educationopedia CMS Setup</h1>
        <p class="subtitle">This will create the database tables and seed initial content from the website. You only need to do this once.</p>
        <form method="POST">
            <button type="submit" class="btn">Run Setup</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
