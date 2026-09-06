<?php

namespace Udara\LaravelAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gen-module {name : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new module scaffold';

    /**
     * The view files to generate with their corresponding stub files
     *
     * @var array
     */
    protected $viewFiles = [
        'index.blade.php' => 'module-index.stub',
        'create.blade.php' => 'module-create.stub',
        'edit.blade.php' => 'module-edit.stub',
    ];

    public function handle()
    {
        $name = $this->argument('name');
        $folderName = strtolower($name);

        $this->info("Generating module: $name");
        $this->createModuleDirectory($folderName);
        $this->generateViewFiles($name, $folderName);
        $this->generateModel($name);
        $this->generateController($name);
        $this->addModuleToPermissions($name);
        $this->addModuleToSeeder($name);
        $this->addModuleToRoutes($name);
        $this->addModuleToSidebar($name);
        $this->updateController($name);

        $this->info("Module '$name' generated successfully!");
    }

    protected function updateController(string $name): void
    {
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");

        if (!file_exists($controllerPath)) {
            $this->error("Controller not found: {$name}Controller.php");
            return;
        }

        $content = file_get_contents($controllerPath);
        $folderName = strtolower($name);

        if (strpos($content, 'public function index()') !== false) {
            $this->warn("Controller '{$name}Controller' already has methods");
            return;
        }

        $methods = "
        public function index()
        {
            return view('{$folderName}.index');
        }

        public function create()
        {
            return view('{$folderName}.create');
        }

        public function store(Request \$request)
        {
            // Store logic here
            return redirect()->route('{$folderName}.index');
        }

        public function edit(\$id)
        {
            return view('{$folderName}.edit');
        }

        public function update(Request \$request, \$id)
        {
            // Update logic here
            return redirect()->route('{$folderName}.index');
        }

        public function destroy(\$id)
        {
            // Delete logic here
            return redirect()->route('{$folderName}.index');
        }";

        $pattern = '/(class\s+' . $name . 'Controller\s+extends\s+Controller\s*\{[^}]*)(}\s*$)/s';
        $replacement = "$1$methods\n$2";

        $updatedContent = preg_replace($pattern, $replacement, $content);

        if ($updatedContent && file_put_contents($controllerPath, $updatedContent)) {
            $this->info("Updated controller: {$name}Controller with CRUD methods");
        } else {
            $this->error("Failed to update controller: {$name}Controller");
        }
    }

    protected function addModuleToSidebar(string $name): void
    {
        $layoutPath = resource_path('views/layouts/app.blade.php');

        if (!file_exists($layoutPath)) {
            $this->error('Layout file not found');
            return;
        }

        $content = file_get_contents($layoutPath);
        $moduleKey = strtolower(str_replace(' ', '_', $name)) . '_management';
        $routePrefix = strtolower($name);
        $routePrefixPlural = $routePrefix . 's';
        $displayName = ucwords(str_replace('_', ' ', $name)) . ' Management';

        if (strpos($content, "@can('{$moduleKey}')") !== false) {
            $this->warn("Sidebar entry for module '{$moduleKey}' already exists");
            return;
        }

        $newMenuItem = "\n                    @can('{$moduleKey}')
                        <li class=\"menu-item {{ Request::is('{$routePrefixPlural}*') ? 'active' : '' }}\">
                            <a href=\"{{ route('{$routePrefixPlural}') }}\" class=\"menu-link\">
                                <i class='menu-icon bx bxs-folder'></i>
                                <div data-i18n=\"Support\">{$displayName}</div>
                            </a>
                        </li>
                    @endcan";

        $pattern = '/(@can\(\'activity_management\'\)[^@]+@endcan)/s';
        $replacement = "$1$newMenuItem";

        $content = preg_replace($pattern, $replacement, $content);

        if (file_put_contents($layoutPath, $content)) {
            $this->info("Added sidebar menu item for '{$displayName}'");
        } else {
            $this->error("Failed to update sidebar");
        }
    }

    protected function addModuleToRoutes(string $name): void
    {
        $path = base_path('routes/web.php');
        if (!file_exists($path)) {
            return;
        }
        $content = file_get_contents($path);

        $moduleKey      = Str::snake($name) . '_management';
        $controllerName = "{$name}Controller";
        $useLine        = "use App\\Http\\Controllers\\{$controllerName};";
        $routePrefix    = Str::plural(Str::snake($name));

        if (str_contains($content, "permission:{$moduleKey}")) {
            $this->warn("Routes for {$moduleKey} already exist");
            return;
        }

        if (! str_contains($content, $useLine)) {
            $content = preg_replace(
                '/^(use [^;]+;)/m',
                "$1\n{$useLine}",
                $content,
                1
            );
        }

        $new = <<<EOT

        Route::middleware('permission:{$moduleKey}')->group(function () {
            Route::prefix('{$routePrefix}')->group(function () {
                Route::get('/', [{$controllerName}::class,'index'])->name('{$routePrefix}');
                Route::get('/create',[{$controllerName}::class,'create'])
                    ->name('{$routePrefix}.create')
                    ->middleware('permission:create_{$moduleKey}');
                Route::post('/store',[{$controllerName}::class,'store'])
                    ->name('{$routePrefix}.store')
                    ->middleware('permission:create_{$moduleKey}');
                Route::get('/edit/{id}',[{$controllerName}::class,'edit'])
                    ->name('{$routePrefix}.edit')
                    ->middleware('permission:update_{$moduleKey}');
                Route::put('/update/{id}',[{$controllerName}::class,'update'])
                    ->name('{$routePrefix}.update')
                    ->middleware('permission:update_{$moduleKey}');
                Route::delete('/delete/{id}',[{$controllerName}::class,'destroy'])
                    ->name('{$routePrefix}.destroy')
                    ->middleware('permission:delete_{$moduleKey}');
            });
        });

    EOT;

        $parts = preg_split(
            "/(Route::middleware\('auth'\)->group\(function\s*\(\)\s*\{\s*)/s",
            $content,
            2,
            PREG_SPLIT_DELIM_CAPTURE
        );

        if (count($parts) < 3) {
            $this->error("Could not locate the auth middleware group.");
            return;
        }

        list($before, $authStartLine, $after) = $parts;

        $newContent = $before . $authStartLine . "\n" . $new . $after;

        file_put_contents($path, $newContent)
            ? $this->info("Routes for {$moduleKey} appended correctly.")
            : $this->error("Failed to write routes.");
    }

    protected function addModuleToSeeder(string $name): void
    {
        $seederPath = database_path('seeders/RoleSeeder.php');

        if (!file_exists($seederPath)) {
            $this->error('RoleSeeder not found');
            return;
        }

        $content = file_get_contents($seederPath);
        $moduleKey = strtolower(str_replace(' ', '_', $name)) . '_management';

        if (strpos($content, "'{$moduleKey}'") !== false) {
            $this->warn("Module '{$moduleKey}' already exists in RoleSeeder");
            return;
        }

        $modulesPattern = '/(\$modules = \[[^]]+)(        \];)/s';
        if (preg_match($modulesPattern, $content, $matches)) {
            $newModulesArray = $matches[1] . ",\n            '{$moduleKey}'" . "\n        " . $matches[2];
            $content = str_replace($matches[0], $newModulesArray, $content);
        }

        $adminPermissions = "'{$moduleKey}',\n            'view_{$moduleKey}',\n            'create_{$moduleKey}',\n            'update_{$moduleKey}',\n            'delete_{$moduleKey}',";

        $adminPattern = '/(\$adminPermissions = \[[^]]+)(            \'activity_management\',\n        \];)/s';
        if (preg_match($adminPattern, $content, $matches)) {
            $newAdminArray = $matches[1] . "            " . $adminPermissions . "\n            " . $matches[2];
            $content = str_replace($matches[0], $newAdminArray, $content);
        }

        if (file_put_contents($seederPath, $content)) {
            $this->info("Added module '{$moduleKey}' to RoleSeeder");
        } else {
            $this->error("Failed to update RoleSeeder");
        }
    }

    protected function addModuleToPermissions(string $name): void
    {
        $permissionsPath = app_path('Models/Permissions.php');

        if (!file_exists($permissionsPath)) {
            $this->error('Permissions model not found');
            return;
        }

        $content = file_get_contents($permissionsPath);
        $moduleKey = strtolower(str_replace(' ', '_', $name)) . '_management';
        $defaultPermissions = "['view', 'create', 'update', 'delete']";

        $newModule = "'{$moduleKey}' => {$defaultPermissions},";

        if (strpos($content, $moduleKey) !== false) {
            $this->warn("Module '{$moduleKey}' already exists in Permissions");
            return;
        }

        $pattern = '/(\s+)(];)(\s+)$/m';
        $replacement = "$1    {$newModule}\n$1$2$3";

        $updatedContent = preg_replace($pattern, $replacement, $content);

        if ($updatedContent && $updatedContent !== $content) {
            file_put_contents($permissionsPath, $updatedContent);
            $this->info("Added module '{$moduleKey}' to Permissions model");
        } else {
            $this->error("Failed to update Permissions model");
        }
    }

    protected function generateModel(string $name): void
    {
        $this->info("Generating model and migration for: $name");

        $exitCode = $this->call('make:model', [
            'name' => $name,
            '--migration' => true
        ]);

        if ($exitCode === 0) {
            $this->info("Model and migration created successfully for: $name");
        } else {
            $this->error("Failed to create model and migration for: $name");
        }
    }

    protected function generateController(string $name): void
    {
        $controllerName = $name . 'Controller';
        $this->info("Generating controller: $controllerName");

        $exitCode = $this->call('make:controller', [
            'name' => $controllerName
        ]);

        if ($exitCode === 0) {
            $this->info("Controller created successfully: $controllerName");
        } else {
            $this->error("Failed to create controller: $controllerName");
        }
    }

    protected function createModuleDirectory(string $folderName): void
    {
        $viewPath = resource_path("views/{$folderName}");

        if (!is_dir($viewPath)) {
            mkdir($viewPath, 0755, true);
            $this->info("Created folder: resources/views/{$folderName}");
        } else {
            $this->warn("Folder 'resources/views/{$folderName}' already exists.");
        }
    }

    protected function generateViewFiles(string $name, string $folderName): void
    {
        $viewPath = resource_path("views/{$folderName}");

        foreach ($this->viewFiles as $fileName => $stubFile) {
            $this->generateViewFile($name, $viewPath, $fileName, $stubFile, $folderName);
        }
    }

    protected function generateViewFile(string $name, string $viewPath, string $fileName, string $stubFile, string $folderName): void
    {
        $filePath = $viewPath . '/' . $fileName;
        if (file_exists($filePath)) {
            $this->warn("File already exists: resources/views/{$folderName}/{$fileName}");
            return;
        }
        $stubPath = base_path("stubs/{$stubFile}");
        if (!$this->validateStubFile($stubPath)) {
            return;
        }
        $template = $this->processTemplate($stubPath, $name, $fileName);
        file_put_contents($filePath, $template);
        $this->info("Created file: resources/views/{$folderName}/{$fileName}");
    }

    protected function validateStubFile(string $stubPath): bool
    {
        if (!file_exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");
            return false;
        }

        return true;
    }

    protected function processTemplate(string $stubPath, string $name, string $fileName): string
    {
        $template = file_get_contents($stubPath);
        $replacements = $this->getReplacements($name, $fileName);
        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    protected function getReplacements(string $name, string $fileName): array
    {
        $baseReplacements = [
            '{{MODULE_NAME}}' => $name,
            '{{MODULE_NAME_LOWER}}' => strtolower($name),
            '{{MODULE_NAME_UPPER}}' => strtoupper($name),
        ];

        if ($fileName === 'index.blade.php') {
            $baseReplacements['{{MODULE_NAME}}'] = $name . ' Module';
        }

        return $baseReplacements;
    }
}
