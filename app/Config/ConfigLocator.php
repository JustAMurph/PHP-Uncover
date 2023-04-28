<?php

namespace App\Config;

use App\Plugins\Contracts\ISettingLocator;

class ConfigLocator implements ISettingLocator
{
    /**
     * @var IParseConfig[] $parsers
     */
    private $parsers = [];

    /**
     * @var ILocateConfig[] $locators
     */
    private $locators = [];


    public function __construct($locators, $parsers)
    {
        $this->locators = (array) $locators;
        $this->parsers = (array) $parsers;
    }

    public function locate(\SplFileInfo $directory, callable $filter = null)
    {
        $configs = new ConfigFileCollection();
        foreach ($this->locators as $locator) {
            $configs = $configs->merge($locator->locate($directory));
        }

        $result = new ConfigFileCollection();

        foreach($configs as $config) {
            /**
             * @var $config \SplFileInfo
             */

            foreach($this->parsers as $parser) {
                $variables = $parser->parseFile($config);

                if ($filter) {
                    $variables = $variables->filterWhenDotted($filter);
                }

                if ($variables->isNotEmpty()) {
                    $result->push(new ConfigFile($config->getPathname(), $variables));
                }
            }
        }

        return $result;
    }
}
