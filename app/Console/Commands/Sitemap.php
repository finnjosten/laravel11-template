<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class Sitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'static:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        return $this->info('Sitemap generation disabled temporarily.');

        // modify this to your own needs
        SitemapGenerator::create("https://sendoo.tools/") ->writeToFile(public_path('sitemap.xml'));
    }
}
