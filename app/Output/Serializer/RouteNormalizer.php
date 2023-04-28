<?php

namespace App\Output\Serializer;

use App\RouteParser\Route;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RouteNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private Serializer $serializer;

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Route;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        /**
         * @var Route $object
         */
        $obj = [
            'method' => $object->getMethod(),
            'urls' => $object->getUrls(),
            'vulnerable' => '** N/A **'
        ];

        return $this->serializer->normalize($obj, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}
