<?php

namespace App\Plugins;

use App\Plugins\CakePHP4\CakePHP4;
use App\Plugins\CodeIgniter3\CodeIgniter3;
use App\Plugins\Laravel\Laravel;
use App\Plugins\Slim\Slim;
use App\Plugins\Symfony\Symfony;
use Symfony\Component\Finder\Finder;

class DetectPlugin
{
    private $composer = [
        'slim/slim' => Slim::class,
        'laravel/framework' => Laravel::class,
        'cakephp/cakephp' => CakePHP4::class,
        'symfony/framework-bundle' => Symfony::class
    ];

    /**
     * @throws \Exception
     */
    public function detect(\SplFileInfo $directory)
    {
        $plugin = $this->getPluginFromComposer($directory);
        if (!$plugin) {
            $plugin = $this->getPluginFromFiles($directory);
        }

        if (!$plugin) {
            throw new \Exception("Unable to determine plugin. Unsupported framework.");
        }

        return $plugin;
    }

    private function getPluginFromComposer(\SplFileInfo $directory)
    {
        $finder = (new Finder())
            ->files()
            ->name('composer.json')
            ->in($directory->getRealPath())
            ->getIterator();

        $finder->rewind();
        $composer = $finder->current();

        $json = json_decode(file_get_contents($composer->getRealPath()), true);
        return $this->getPluginFromRequire($json['require']);
    }

    private function getPluginFromFiles(\SplFileInfo $directory)
    {
        // Check CodeIgniter.
        $finder = (new Finder())
            ->name('CodeIgniter.php')
            ->in($directory->getRealPath())
            ->path('system/core');

        if ($finder->count()) {
            return CodeIgniter3::class;
        }
    }

    private function getPluginFromRequire($array)
    {
        foreach ($array as $name => $version) {
            if (isset($this->composer[$name])) {
                return $this->composer[$name];
            }
        }
    }
}
