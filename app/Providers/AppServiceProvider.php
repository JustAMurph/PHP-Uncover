<?php

namespace App\Providers;

use App\Analysis\Analysis;
use App\Listeners\VulnerableCallLikeListener;
use App\Output\ConsoleOutput;
use App\Output\IHandleOutput;
use App\Output\Serializer\ConfigFileNormalizer;
use App\Output\Serializer\RouteNormalizer;
use App\Output\Serializer\VulnerableExecutionNormalizer;
use App\Parser\StatementWalker\IStatementWalker;
use App\Parser\StatementWalker\SimpleStatementWalker;
use App\Plugins\CodeIgniter3\CodeIgniter3;
use App\Plugins\Contracts\IActAsPlugin;
use App\Source\Repository as SourceRepository;
use App\Vulnerabilities\Repository as SinkRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parser::class, function ($app) {
            return (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        });

        $this->app->singleton(Standard::class, function() {
            return new Standard();
        });

        $this->app->bind(IHandleOutput::class, ConsoleOutput::class);
        $this->app->bind(IActAsPlugin::class, CodeIgniter3::class);

        $this->app->bind(\App\Parser\Parser::class, \App\Parser\Parser::class);
        $this->app->bind(IStatementWalker::class, SimpleStatementWalker::class);

        $this->app->singleton(SourceRepository::class, function() {
            return new SourceRepository();
        });

        $this->app->singleton(SinkRepository::class, function() {
            return new SinkRepository();
        });

        $this->app->singleton(Serializer::class, function($app) {
            $encoders = [
                new XmlEncoder(),
                new JsonEncoder(),
                new YamlEncoder(),
                new CsvEncoder()
            ];
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

            $normalizers = [
                new RouteNormalizer(),
                new VulnerableExecutionNormalizer(),
                new ConfigFileNormalizer(),
                new PropertyNormalizer($classMetadataFactory),
                new ArrayDenormalizer(),
            ];

            return new Serializer($normalizers, $encoders);
        });

        Collection::macro('dot', function($array) {
            return collect(Arr::dot($array));
        });

        Collection::macro('toDot', function() {
            return Collection::dot($this);
        });


        UploadedFile::macro('zipExtractTo', function($path) {
            /**
             * @var $this UploadedFile
             */
            $zip = new \ZipArchive();
            $zip->open(
                $this->path(),
                \ZipArchive::RDONLY
            );

            return $zip->extractTo($path);
        });
    }



    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
