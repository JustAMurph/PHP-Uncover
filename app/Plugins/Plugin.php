<?php

namespace App\Plugins;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\ApplicationDefinitions\Definitions\Loaders\StandardDefinitionLoader;
use App\Config\ILocateConfig;
use App\Config\IParseConfig;
use App\Events\LoadSinks;
use App\Events\LoadSources;
use App\Plugins\Contracts\IActAsPlugin;
use App\Plugins\Contracts\IRouteLocator;
use App\Plugins\Contracts\ISettingLocator;
use App\RouteParser\GenericRouteLocator;
use App\RouteParser\IParseRoutes;
use App\Source\ManageSources;
use App\Vulnerabilities\ManageSinks;
use Illuminate\Support\Facades\Event;

abstract class Plugin implements IActAsPlugin
{
    use ManageSinks, ManageSources;

    private array $configLocators = [];
    private array $configParsers = [];
    private array $routeParsers = [];

    protected string $applicationDefinitionClass = ApplicationDefinitions::class;
    protected string $definitionLoader = StandardDefinitionLoader::class;

    protected \SplFileInfo $path;
    protected ?ApplicationDefinitions $applicationDefinitions = null;

    abstract function initialize();

    abstract public static function getName() : string;

    final public function __construct(\SplFileInfo $path)
    {
        $this->path = $path;
        $this->initialize();
    }

    protected function addConfigLocator(ILocateConfig $locateConfig)
    {
        $this->configLocators[] = $locateConfig;
    }

    protected function addConfigParser(IParseConfig $parseConfig)
    {
        $this->configParsers[] = $parseConfig;
    }

    protected function addRouteParser(IParseRoutes $parseRoutes)
    {
        $this->routeParsers[] = $parseRoutes;
    }

    final public function getDefinitionHandler(): ApplicationDefinitions
    {
        if (!$this->applicationDefinitions) {
            $this->applicationDefinitions = (new $this->applicationDefinitionClass(
                new $this->definitionLoader($this->path))
            );
        }

        return $this->applicationDefinitions;
    }

    final public function getSettingLocator(): ISettingLocator
    {
        return new \App\Config\ConfigLocator($this->configLocators, $this->configParsers);
    }

    final public function getEntryPointLocator(): IRouteLocator
    {
        return new GenericRouteLocator($this->routeParsers);
    }
}
