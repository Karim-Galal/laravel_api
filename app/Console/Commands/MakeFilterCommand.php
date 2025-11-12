<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeFilterCommand extends Command
{
    protected $signature = 'make:filter {name : The name of the service} {--v= : Optional version directory (e.g. v1, v2)}';

    protected $description = 'Create a new filter class';

    public function handle()
    {
        $name = $this->argument('name');
        $version = $this->option('v');

        // namespace
        $namespace = "App\\Filters" . ($version ? "\\{$version}" : "");

        // directory path
        $directory = app_path("Filters" . ($version ? "/{$version}" : ""));
        (new Filesystem)->ensureDirectoryExists($directory);

        // file path
        $path = $directory . "/{$name}.php";

        // check if already exists
        if (file_exists($path)) {
            $this->error("⚠️ Filter {$name} already exists at {$path}");
            return;
        }

        // stub
        $stub = <<<PHP
<?php

namespace {$namespace};

class {$name}
{
    public function __construct()
    {
        //
    }
}
PHP;

        // create file
        file_put_contents($path, $stub);

        $this->info("✅ Service {$name} created successfully at {$path}");
    }
}
