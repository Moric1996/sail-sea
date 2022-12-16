<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BreezejpCommand extends Command
{
    public $signature = 'breezejp';

    public $description = 'Add Japanese Translation files for Laravel Breeze';

    public function handle(): int
    {
        $this->info('Laravel Breeze用に日本語翻訳ファイルを準備します');

        (new Filesystem)->ensureDirectoryExists(lang_path());
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/lang/', lang_path());

        $this->info('config/app.phpのlocaleをjaにします');
        // Read the contents of the file into a string
        $configfile = file_get_contents(base_path('config/app.php'));

        // Modify the contents of the string
        $configfile = str_replace("'locale' => 'en'", "'locale' => 'ja'", $configfile);

        // Save the modified contents back to the file
        file_put_contents(base_path('config/app.php'), $configfile);


        if ($this->confirm('GitHubリポジトリにスターの御協力をお願いします🙏', true)) {
            $repoUrl = 'https://github.com/askdkc/breezejp';

            if (PHP_OS_FAMILY == 'Darwin') {
                exec("open {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Windows') {
                exec("start {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Linux') {
                exec("xdg-open {$repoUrl}");
            }

            $this->line('Thank you! / ありがとう💓');
        }

        $this->info('日本語ファイルのインストールが完了しました!');

        return self::SUCCESS;
    }
}
