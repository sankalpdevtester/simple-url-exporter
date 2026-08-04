namespace App\Console\Services;

use App\Console\Helpers\UrlExporterHelper;
use App\Console\Handlers\UrlExporterErrorHandler;
use App\Config\UrlExporterConfig;

class UrlExporterService
{
    private UrlExporterHelper $helper;
    private UrlExporterErrorHandler $errorHandler;
    private UrlExporterConfig $config;

    public function __construct(UrlExporterHelper $helper, UrlExporterErrorHandler $errorHandler, UrlExporterConfig $config)
    {
        $this->helper = $helper;
        $this->errorHandler = $errorHandler;
        $this->config = $config;
    }

    public function exportUrls(array $urls): void
    {
        try {
            $filename = $this->helper->getExportFilename();
            $path = $this->helper->getExportPath();
            $this->helper->exportUrlsToCsv($urls, $path . '/' . $filename);
        } catch (Exception $exception) {
            $this->errorHandler->handleException($exception);
        }
    }
}