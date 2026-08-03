<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use League\Csv\Writer;
use Symfony\Component\Console\Input\InputOption;

class ExportUrlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:urls {--o|output=} {--s|sources=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export website URLs to a CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $output = $this->option('output') ?: 'urls.csv';
        $sources = $this->option('sources') ?: 'https://example.com';

        $sources = explode(',', $sources);

        $csv = Writer::createFromPath($output, 'w');
        $csv->insertOne(['URL']);

        foreach ($sources as $source) {
            $csv->insertOne([$source]);
        }

        $this->info('URLs exported to ' . $output);

        return 0;
    }
}