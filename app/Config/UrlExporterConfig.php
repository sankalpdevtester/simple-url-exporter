namespace App\Config;

use Illuminate\Support\Facades\Config;

class UrlExporterConfig
{
    public function __construct()
    {
        $this->setDefaultConfig();
    }

    private function setDefaultConfig(): void
    {
        Config::set('url-exporter.filename', 'exported-urls');
        Config::set('url-exporter.extension', '.csv');
        Config::set('url-exporter.path', 'exports');
    }

    public function getFilename(): string
    {
        return Config::get('url-exporter.filename');
    }

    public function getExtension(): string
    {
        return Config::get('url-exporter.extension');
    }

    public function getPath(): string
    {
        return Config::get('url-exporter.path');
    }
}