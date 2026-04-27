<?php
/**
 * Simple URL Exporter
 * Extracts and exports all URLs from a website
 */

require_once 'UrlCrawler.php';

header('Content-Type: application/json');

// Get POST data
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$depth = filter_input(INPUT_POST, 'depth', FILTER_VALIDATE_INT) ?: 1;
$format = filter_input(INPUT_POST, 'format', FILTER_SANITIZE_STRING) ?: 'txt';

if (!$url) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid URL provided']);
    exit;
}

// Limit depth
$depth = min(max($depth, 1), 3);

try {
    // Crawl the website
    $crawler = new UrlCrawler($url);
    $urls = $crawler->crawl($depth);
    
    // Generate export file
    $filename = 'urls_' . date('Ymd_His');
    $content = generateExport($urls, $format);
    
    // Set appropriate headers based on format
    switch ($format) {
        case 'csv':
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            break;
        case 'json':
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="' . $filename . '.json"');
            break;
        case 'xml':
            header('Content-Type: application/xml');
            header('Content-Disposition: attachment; filename="' . $filename . '.xml"');
            break;
        default:
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $filename . '.txt"');
    }
    
    echo $content;
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

/**
 * Generate export content in specified format
 */
function generateExport($urls, $format) {
    switch ($format) {
        case 'csv':
            return generateCSV($urls);
        case 'json':
            return generateJSON($urls);
        case 'xml':
            return generateXML($urls);
        default:
            return generateTXT($urls);
    }
}

function generateTXT($urls) {
    return implode("\n", $urls);
}

function generateCSV($urls) {
    $output = "URL,Status,Last Modified\n";
    foreach ($urls as $url) {
        $output .= '"' . str_replace('"', '""', $url) . '",200,' . date('Y-m-d') . "\n";
    }
    return $output;
}

function generateJSON($urls) {
    $data = array_map(function($url) {
        return [
            'url' => $url,
            'status' => 200,
            'discovered' => date('Y-m-d H:i:s')
        ];
    }, $urls);
    
    return json_encode([
        'total' => count($urls),
        'generated' => date('Y-m-d H:i:s'),
        'urls' => $data
    ], JSON_PRETTY_PRINT);
}

function generateXML($urls) {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    foreach ($urls as $url) {
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    <priority>0.8</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }
    
    $xml .= '</urlset>';
    return $xml;
}
