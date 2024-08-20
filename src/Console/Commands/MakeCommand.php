<?php

namespace SteelAnts\LivewireForm\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire-form:make {formName}
                            {--model=}
                            {--force: Overwrite existing files by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('model')) {
            $model = ucfirst($this->argument('model'));
            if (!class_exists('App\\Models\\' . $model)) {
                $this->components->error('Model not Found!');
                return;
            }
        }

        $this->makeClassFile('app/Livewire/' . $model, "Form.php", $model);
    }

    private function makeClassFile(string $path, string $fileName, string $model)
    {
        $testFilePath = base_path() . '/' . $path . '/' . $fileName;
        if (file_exists($testFilePath) && !$this->option('force')) {
            if (!$this->components->confirm("The [" . $testFilePath . "] already exists. Do you want to replace it?")) {
                return;
            }
        }

        $folderpath = str_replace('/' . $fileName, "", $testFilePath);
        if (!file_exists($folderpath)) {
            mkdir($folderpath, 0777, true);
        }

        $this->components->info("Creating component file: " . $testFilePath);

        $content = $this->getFormClassSkeleton([
            'model' => $model,
        ]);
        file_put_contents($testFilePath, $content);
    }

    private function getFormClassSkeleton(array $arguments)
    {
        $arguments['model_lower_case'] = Str::snake($arguments['model'], "-");
        $arguments['traits'] = "use HasModel;";

        $propertiesString = "";
        $validationRules = "";
        $loadProperties = "";

        foreach ($arguments['headers'] as $key => $header) {
            $propertiesString .= "\tpublic string $" . $header . ";\n";
            $validationRules .= "\t\t\t'" . $header . "' => 'required',\n";
            $loadProperties .= "\t\t\t\$this->" . $header . " = $" . $arguments['model_lower_case'] . "->" . $header . ";\n";
        }

        $arguments['properties'] = rtrim(ltrim($propertiesString, "\t"), "\n");
        $arguments['validationRules'] = rtrim(ltrim($validationRules, "\t"), "\n");
        $arguments['loadProperties'] = rtrim(ltrim($loadProperties, "\t"), "\n");

        unset($arguments['headers']);

        $stubFilePath = ('/stubs/Form.stub');
        $moduleRootPath = realpath($this->getPackageBasePath() . $stubFilePath);

        $fileContent = file_get_contents($moduleRootPath, true);
        foreach ($arguments as $ArgumentName => $ArgumentValue) {
            if (gettype($ArgumentValue) != 'string') {
                continue;
            }

            $fileContent = str_replace("{{" . $ArgumentName . "}}", $ArgumentValue, $fileContent);
        }
        return $fileContent;
    }
}
