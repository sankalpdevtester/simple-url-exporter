# Simple URL Exporter
A PHP CLI tool that exports website URLs to a CSV file, useful for web developers and SEO specialists.

## Badges
[![Language](https://img.shields.io/badge/Language-PHP_8.1-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green)](https://opensource.org/licenses/MIT)

## What it does
The Simple URL Exporter is a command-line tool built with Laravel 9 and PHP 8.1 that allows users to export website URLs to a CSV file. This tool is particularly useful for web developers and SEO specialists who need to manage and analyze large numbers of URLs. With its configurable export options and support for multiple URL sources, the Simple URL Exporter is a versatile and efficient solution.

## Features
* URL export to CSV
* Configurable export options
* Support for multiple URL sources
* Error handling and logging
* Simple and easy to use

## Requirements
* PHP 8.1
* Laravel 9
* Composer 2.3 or higher

## Installation
To install the Simple URL Exporter, run the following command in your terminal:
```bash
composer install
```
This will install all the required dependencies.

## Usage
To use the Simple URL Exporter, run the following command in your terminal:
```bash
php artisan export:urls
```
This will export the URLs to a CSV file named `urls.csv` in the `storage/exports` directory. You can customize the export options by using the following commands:
```bash
php artisan export:urls --file=custom_file.csv
php artisan export:urls --source=https://example.com
```
Expected output:
```
Exporting URLs to custom_file.csv...
Export complete.
```

## Environment Variables
| Variable | Description |
| --- | --- |
| `URL_SOURCE` | The URL source to export from (default: `https://example.com`) |
| `EXPORT_FILE` | The file name to export to (default: `urls.csv`) |
| `EXPORT_DIR` | The directory to export to (default: `storage/exports`) |

## Project Structure
```markdown
simple-url-exporter/
├── app/
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── ExportUrlsCommand.php
│   │   ├── Kernel.php
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Providers/
│   ├── Services/
├── bootstrap/
│   ├── app.php
│   ├── cache/
├── config/
│   ├── app.php
│   ├── database.php
│   ├── export.php
├── database/
│   ├── migrations/
│   ├── seeders/
├── public/
│   ├── index.php
│   ├── webpack.mix.js
├── resources/
│   ├── lang/
│   ├── views/
├── routes/
│   ├── api.php
│   ├── console.php
│   ├── web.php
├── storage/
│   ├── app/
│   ├── exports/
│   ├── framework/
│   ├── logs/
├── tests/
│   ├── Feature/
│   ├── Unit/
├── vendor/
├── composer.json
├── composer.lock
├── phpunit.xml
└── README.md
```

## Contributing
Contributions are welcome and encouraged. To contribute, please fork this repository, make your changes, and submit a pull request. Please ensure that your code is well-documented and follows the PSR-12 coding standard.

## License
The Simple URL Exporter is licensed under the MIT License. See [LICENSE](LICENSE) for more information.