<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

class Minifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static:minify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify CSS and JS files';

    /**
     * Execute the console command.
     */
    public function handle() {
        $this->info('Starting minification process...');

        // Define the directories for CSS and JS files
        $cssDir = public_path('css');
        $jsDir = public_path('js');

        // Minify CSS files
        $this->minifyFiles($cssDir, '*.css', 'css');

        // Minify JS files
        $this->minifyFiles($jsDir, '*.js', 'js');

        $this->info('Minification process completed.');
    }

    /**
     * Minify files in the specified directory.
     *
     * @param string $directory
     * @param string $pattern
     * @param string $type
     */
    protected function minifyFiles($directory, $pattern, $type) {
        $files = glob("{$directory}/{$pattern}");

        if (empty($files)) {
            $this->info("No {$type} files found in {$directory}.");
            return;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                // Extract filename without extension to check if it's already minified
                $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);

                // If filename ends with .min, skip this file
                if (str_contains($fileNameWithoutExtension, '.min')) {
                    $this->info("Skipping already minified file: {$file}");
                    continue;
                }

                // Minify the file based on its type
                $minifiedContent = $this->minifyContent($file, $type);

                if ($minifiedContent !== false) {
                    $pathInfo = pathinfo($file);
                    $minFileName = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.min.' . $pathInfo['extension'];

                    // Check if the minified version already exists and remove it
                    if (file_exists($minFileName)) {
                        unlink($minFileName);
                        $this->info("Removed existing minified file: {$minFileName}");
                    }

                    file_put_contents($minFileName, $minifiedContent);
                    $this->info("Successfully minified {$file} to {$minFileName}");
                } else {
                    $this->error("Failed to minify: {$file}");
                }
            }
        }
    }

    /**
     * Minify the content of a file using MatthiasMullie\Minify library.
     *
     * @param string $file
     * @param string $type
     * @return string|false
     */
    protected function minifyContent($file, $type) {
        try {
            if ($type === 'css') {
                $minifier = new CSS($file);
                return $minifier->minify();
            } elseif ($type === 'js') {
                $minifier = new JS($file);
                return $minifier->minify();
            }

            return false;
        } catch (\Exception $e) {
            $this->error("Error minifying {$file}: " . $e->getMessage());
            return false;
        }
    }
}
