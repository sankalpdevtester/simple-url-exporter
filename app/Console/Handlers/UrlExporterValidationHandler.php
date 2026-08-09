<?php

namespace App\Console\Handlers;

use App\Models\Url;
use App\Models\UrlSource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class UrlExporterValidationHandler
{
    /**
     * Validate URL before exporting
     *
     * @param string $url
     * @return bool
     */
    public function validateUrl(string $url): bool
    {
        $validator = Validator::make(['url' => $url], [
            'url' => [
                'required',
                'string',
                'url',
                new Exists(Url::class, 'url'),
            ],
        ]);

        return !$validator->fails();
    }

    /**
     * Validate URL source before exporting
     *
     * @param string $urlSource
     * @return bool
     */
    public function validateUrlSource(string $urlSource): bool
    {
        $validator = Validator::make(['url_source' => $urlSource], [
            'url_source' => [
                'required',
                'string',
                new Exists(UrlSource::class, 'name'),
            ],
        ]);

        return !$validator->fails();
    }

    /**
     * Validate URL and URL source before exporting
     *
     * @param string $url
     * @param string $urlSource
     * @return bool
     */
    public function validateUrlAndSource(string $url, string $urlSource): bool
    {
        return $this->validateUrl($url) && $this->validateUrlSource($urlSource);
    }
}
```

```php
// Update app/Console/Commands/ExportUrlsCommand.php to use the new validation handler
// ...

use App\Console\Handlers\UrlExporterValidationHandler;

class ExportUrlsCommand extends Command
{
    // ...

    private UrlExporterValidationHandler $validationHandler;

    public function __construct(UrlExporterValidationHandler $validationHandler)
    {
        parent::__construct();
        $this->validationHandler = $validationHandler;
    }

    // ...

    protected function handle()
    {
        // ...

        foreach ($urls as $url) {
            if (!$this->validationHandler->validateUrlAndSource($url->url, $url->url_source)) {
                // Handle invalid URL or URL source
                continue;
            }

            // Export URL
        }

        // ...
    }
}
```

```php
// Update app/Console/Kernel.php to bind the validation handler
// ...

protected $commands = [
    // ...
];

protected $bindings = [
    // ...
    UrlExporterValidationHandler::class => function ($app) {
        return new UrlExporterValidationHandler();
    },
];