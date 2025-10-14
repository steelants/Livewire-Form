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
    protected $signature = 'livewire-form:make {formName=Form}
                            {--model=}
                            {--force : Overwrite existing files by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected function getPackageBasePath()
    {
        return  __DIR__ . '/../../..';
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('model')) {
            $model = ucfirst($this->option('model'));
            if (!class_exists('App\\Models\\' . $model)) {
                $this->components->error('Model not Found!');
                return;
            }
        }
        $formName = ucfirst($this->argument('formName')) . ".php";

        $this->makeClassFile('app/Livewire/' . $model, $formName, $model);
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

        $fillable = (new ('App\\Models\\' . $model))->getFillable();
        if ($fillable == []) {
            $this->components->warn('Please make sure that $fillable variable of model ' . $model . ' is defined correctly.');
        }

        $content = $this->getFormClassSkeleton([
            'model' => $model,
            'fileName' => str_replace(".php", "", $fileName),
            'headers' => $fillable,
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
            //$propertiesString .= "\tpublic string $" . $header . ";\n";
            $validationRules .= "\t\t\t'properties." . $header . "' => 'required',\n";
            //$loadProperties .= "\t\t\t\$this->properties['" . $header . "'] = $" . $arguments['model_lower_case'] . "->" . $header . ";\n";
        }

        //$arguments['properties'] = rtrim(ltrim($propertiesString, "\t"), "\n");
        $arguments['validationRules'] = rtrim(ltrim($validationRules, "\t"), "\n");
        //$arguments['loadProperties'] = rtrim(ltrim($loadProperties, "\t"), "\n");

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
