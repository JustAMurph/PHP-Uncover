<?php

namespace App\Analysis;


use App\Config\ConfigFileCollection;
use App\Credentials\Keywords;
use App\EntryPoint\EntryPointCollection;
use App\Parser\Parser;
use App\Plugins\Contracts\IActAsPlugin;
use App\Plugins\DetectPlugin;
use App\Plugins\PluginMapping;
use App\RouteParser\RouteCollection;
use App\Source\CausesTaint\MethodCall;
use App\Source\ManageSources;
use App\Vulnerabilities\ManageSinks;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * A facade to access the underlying sub-components of the system.
 */
class Analysis
{
    use ManageSources, ManageSinks;

    private \SplFileInfo $path;
    private IActAsPlugin $plugin;

    public function __construct(\SplFileInfo $path)
    {
        $this->path = $path;
        $this->detectPlugin();
    }

    public function detectPlugin()
    {
        $guessed = (new DetectPlugin())->detect($this->path);
        if ($guessed) {
            $this->setPlugin(new $guessed($this->path));
        }
    }

    public function setPlugin(IActAsPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function entryPoints() : RouteCollection
    {
        return $this->plugin->getEntryPointLocator()->fromDirectory($this->path);
    }

    public function credentials(): ConfigFileCollection
    {
        return $this->plugin->getSettingLocator()->locate($this->path, function($v, $k) {
            return Keywords::isCredential($k) || Keywords::isCredential($v);
        });
    }

    public function settings(): ConfigFileCollection
    {
        return $this->plugin->getSettingLocator()->locate($this->path);
    }

    public function vulnerabilities() : EntryPointCollection
    {
        $parser = resolve(Parser::class);
        /**
         * @var Parser $parser
         */
        $parser->registerApplicationDefinition($this->plugin->getDefinitionHandler());
        return $parser->routeCollection($this->entryPoints());
    }

    public function useConfigFile(\SplFileInfo $file)
    {
        $yaml = Yaml::parseFile($file->getRealPath());

        $this->addSourcesFromArray($yaml['sources']);
        $this->addSinksFromArray($yaml['sinks']);
    }


    public static function fromInput(InputInterface $input): static
    {
        $analysis =  new static(
            new \SplFileInfo($input->getArgument('dir')),
        );

        if ($input->getOption('config')) {
            $analysis->useConfigFile(new \SplFileInfo($input->getOption('config')));
        }

        return $analysis;
    }
}
