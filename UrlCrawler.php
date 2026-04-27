<?php
/**
 * URL Crawler Class
 * Extracts all URLs from a given website
 */

class UrlCrawler {
    private $baseUrl;
    private $visitedUrls = [];
    private $foundUrls = [];
    private $maxUrls = 100;
    
    public function __construct($url) {
        $this->baseUrl = rtrim($url, '/');
        $this->domain = parse_url($url, PHP_URL_HOST);
    }
    
    /**
     * Crawl website to specified depth
     */
    public function crawl($depth = 1) {
        $this->crawlRecursive($this->baseUrl, $depth);
        return array_unique($this->foundUrls);
    }
    
    /**
     * Recursive crawling function
     */
    private function crawlRecursive($url, $depth) {
        if ($depth <= 0 || count($this->foundUrls) >= $this->maxUrls) {
            return;
        }
        
        if (in_array($url, $this->visitedUrls)) {
            return;
        }
        
        $this->visitedUrls[] = $url;
        $this->foundUrls[] = $url;
        
        // Fetch page content
        $html = $this->fetchUrl($url);
        if (!$html) {
            return;
        }
        
        // Extract links
        $links = $this->extractLinks($html, $url);
        
        // Recursively crawl each link
        foreach ($links as $link) {
            if (count($this->foundUrls) >= $this->maxUrls) {
                break;
            }
            $this->crawlRecursive($link, $depth - 1);
        }
    }
    
    /**
     * Fetch URL content
     */
    private function fetchUrl($url) {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; URLExporter/1.0)',
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode != 200) {
            return false;
        }
        
        return $html;
    }
    
    /**
     * Extract links from HTML
     */
    private function extractLinks($html, $baseUrl) {
        $links = [];
        $dom = new DOMDocument();
        
        // Suppress warnings for malformed HTML
        @$dom->loadHTML($html);
        
        $anchors = $dom->getElementsByTagName('a');
        
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            
            if (empty($href) || $href == '#') {
                continue;
            }
            
            // Convert relative URLs to absolute
            $absoluteUrl = $this->makeAbsoluteUrl($href, $baseUrl);
            
            // Only include URLs from same domain
            if ($this->isSameDomain($absoluteUrl)) {
                $links[] = $absoluteUrl;
            }
        }
        
        return array_unique($links);
    }
    
    /**
     * Convert relative URL to absolute
     */
    private function makeAbsoluteUrl($href, $base) {
        // Already absolute
        if (parse_url($href, PHP_URL_SCHEME) != '') {
            return $href;
        }
        
        // Protocol relative
        if (substr($href, 0, 2) == '//') {
            return parse_url($base, PHP_URL_SCHEME) . ':' . $href;
        }
        
        // Parse base URL
        $parsedBase = parse_url($base);
        $scheme = $parsedBase['scheme'];
        $host = $parsedBase['host'];
        $path = isset($parsedBase['path']) ? $parsedBase['path'] : '/';
        
        // Absolute path
        if (substr($href, 0, 1) == '/') {
            return $scheme . '://' . $host . $href;
        }
        
        // Relative path
        $path = substr($path, 0, strrpos($path, '/') + 1);
        return $scheme . '://' . $host . $path . $href;
    }
    
    /**
     * Check if URL is from same domain
     */
    private function isSameDomain($url) {
        $host = parse_url($url, PHP_URL_HOST);
        return $host === $this->domain;
    }
}
