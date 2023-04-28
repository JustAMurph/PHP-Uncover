<?php

namespace App\Output\Serializer;

use App\Config\ConfigFile;
use App\Utility\Route;
use Illuminate\Support\Arr;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ConfigFileNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof ConfigFile && $format == 'xml';
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /**
         * @var ConfigFile $object
         */
        $n = [];
        $safe = Arr::dot($object->variables);
        foreach($safe as $k => $value) {
            $n[] = [
                'key' => $k,
                'value' => $value
            ];
        }

        $obj = [
            'path' => $object->path,
            'varaiables' => $n
        ];

        return $this->serializer->normalize($obj, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}
