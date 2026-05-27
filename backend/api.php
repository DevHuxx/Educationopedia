<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
error_reporting(0);
require_once __DIR__ . '/config.php';
setCorsHeaders();
ob_start();

$action = $_GET['action'] ?? '';
$db     = getDB();

function cleanJsonResponse($data) {
    ob_end_clean();
    jsonResponse($data);
}

switch ($action) {

case 'content':
    $section = $_GET['section'] ?? '';
    if (!$section) jsonError('Section parameter required');
    $stmt = $db->prepare("SELECT content_key, content_value FROM site_content WHERE section = ?");
    $stmt->bind_param('s', $section);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) { $data[$row['content_key']] = $row['content_value']; }
    cleanJsonResponse($data);
    break;

case 'content_all':
    $sectionsStr = $_GET['sections'] ?? '';
    if (!$sectionsStr) jsonError('Sections parameter required');
    $sectionList = array_map('trim', explode(',', $sectionsStr));
    $data = [];
    foreach ($sectionList as $sec) {
        $stmt = $db->prepare("SELECT content_key, content_value FROM site_content WHERE section = ?");
        $stmt->bind_param('s', $sec);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) { $data[$sec][$row['content_key']] = $row['content_value']; }
        $stmt->close();
    }
    cleanJsonResponse($data);
    break;

case 'images':
    $section = $_GET['section'] ?? '';
    if (!$section) jsonError('Section parameter required');
    $stmt = $db->prepare("SELECT id, image_key, image_path, alt_text, label, sort_order FROM site_images WHERE section = ? ORDER BY sort_order, id");
    $stmt->bind_param('s', $section);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    while ($row = $result->fetch_assoc()) { $images[] = $row; }
    cleanJsonResponse($images);
    break;

case 'testimonials':
    $result = $db->query("SELECT id, name, course, text, rating FROM testimonials ORDER BY sort_order, id");
    $data = [];
    while ($row = $result->fetch_assoc()) { $data[] = $row; }
    cleanJsonResponse($data);
    break;

case 'blog':
    $limit = (int)($_GET['limit'] ?? 50);
    $stmt = $db->prepare("SELECT id, title, excerpt, content, category, read_time, image_path, published_at FROM blog_posts ORDER BY published_at DESC, id DESC LIMIT ?");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) { $data[] = $row; }
    cleanJsonResponse($data);
    break;

case 'universities':
    $country = $_GET['country'] ?? '';

    if ($country === 'Global') {
        $result = $db->query(
            "SELECT u.* FROM universities u
             INNER JOIN (
                 SELECT country, MIN(`rank`) AS min_rank
                 FROM universities
                 GROUP BY country
             ) best ON u.country = best.country AND u.`rank` = best.min_rank
             ORDER BY u.country"
        );
        $rows = [];
        while ($row = $result->fetch_assoc()) { $rows[] = $row; }
        cleanJsonResponse(['Global' => $rows]);

    } elseif ($country) {
        $stmt = $db->prepare("SELECT * FROM universities WHERE country = ? ORDER BY `rank`");
        $stmt->bind_param('s', $country);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) { $data[] = $row; }
        cleanJsonResponse($data);

    } else {
        $result = $db->query("SELECT * FROM universities ORDER BY country, `rank`");
        $data = [];
        while ($row = $result->fetch_assoc()) { $data[] = $row; }
        $grouped = [];
        $topPerCountry = [];
        foreach ($data as $row) { 
            $grouped[$row['country']][] = $row; 
            if (!isset($topPerCountry[$row['country']])) {
                $topPerCountry[$row['country']] = $row;
            }
        }
        $grouped['Global'] = array_values($topPerCountry);
        cleanJsonResponse($grouped);
    }
    break;

case 'university_countries':
    $result = $db->query("SELECT DISTINCT country FROM universities ORDER BY country");
    $countries = [];
    while ($row = $result->fetch_assoc()) { $countries[] = $row['country']; }
    cleanJsonResponse($countries);
    break;

case 'gallery':
    $result = $db->query("SELECT id, image_path, alt_text FROM gallery_images ORDER BY sort_order, id");
    $data = [];
    while ($row = $result->fetch_assoc()) { $data[] = $row; }
    cleanJsonResponse($data);
    break;

case 'health':
    cleanJsonResponse(['status' => 'ok', 'timestamp' => date('c')]);
    break;

default:
    cleanJsonResponse([
        'name'      => 'Educationopedia CMS API',
        'version'   => '1.0',
        'endpoints' => [
            'GET ?action=content&section=hero',
            'GET ?action=content_all&sections=hero,stats,why_us',
            'GET ?action=images&section=hero_slides',
            'GET ?action=testimonials',
            'GET ?action=blog&limit=3',
            'GET ?action=universities&country=Russia',
            'GET ?action=universities&country=Global',
            'GET ?action=university_countries',
            'GET ?action=gallery',
            'GET ?action=health',
        ]
    ]);
}
