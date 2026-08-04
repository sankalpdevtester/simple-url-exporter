namespace App\Console\Handlers;

use Illuminate\Support\Facades\Log;
use Exception;

class UrlExporterErrorHandler
{
    public function handleException(Exception $exception): void
    {
        Log::error('URL exporter error: ' . $exception->getMessage());
        Log::error('URL exporter error stack: ' . $exception->getTraceAsString());
    }

    public function handleWarning(string $message): void
    {
        Log::warning('URL exporter warning: ' . $message);
    }
}