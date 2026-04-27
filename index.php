<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple URL Exporter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📎 Simple URL Exporter</h1>
            <p>Export website URLs to various formats</p>
        </header>

        <div class="card">
            <h2>Enter URL to Export</h2>
            <form id="exportForm" action="export.php" method="POST">
                <div class="form-group">
                    <label for="url">Website URL:</label>
                    <input type="url" id="url" name="url" required placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label for="depth">Crawl Depth:</label>
                    <input type="number" id="depth" name="depth" min="1" max="3" value="1">
                    <small>Maximum depth to crawl (1-3)</small>
                </div>

                <div class="form-group">
                    <label for="format">Export Format:</label>
                    <select id="format" name="format">
                        <option value="txt">Text File (.txt)</option>
                        <option value="csv">CSV (.csv)</option>
                        <option value="json">JSON (.json)</option>
                        <option value="xml">XML Sitemap (.xml)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Export URLs</button>
            </form>
        </div>

        <div id="results" class="card hidden">
            <h2>Export Results</h2>
            <div id="resultsContent"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
