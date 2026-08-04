namespace App\Console\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class UrlExporterHelper
{
    public function exportUrlsToCsv(array $urls, string $filename): void
    {
        $csvContent = "URL\n";
        foreach ($urls as $url) {
            $csvContent .= $url . "\n";
        }

        Storage::disk('local')->put($filename, $csvContent);
    }

    public function getExportFilename(): string
    {
        $filename = Config::get('url-exporter.filename');
        $extension = Config::get('url-exporter.extension');
        $timestamp = now()->format('Y-m-d_H-i-s');
        return Str::finish($filename, $extension) . '_' . $timestamp;
    }

    public function getExportPath(): string
    {
        return Config::get('url-exporter.path');
    }
}