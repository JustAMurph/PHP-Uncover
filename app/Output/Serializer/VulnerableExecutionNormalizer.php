<?php

namespace App\Output\Serializer;

use App\EntryPoint\EntryPoint;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class VulnerableExecutionNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private Serializer $serializer;

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof EntryPoint;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /**
         * @var EntryPoint $object
         */
        $obj = [
            'executedCall' => $object->getCallLike()->name->getFirst(),
            'executedVariable' => $object->variable->name,
            'executionPath' => $object->toExecutionPath(),
            'entrypoint' => $object->entrypoint
        ];

        return $this->serializer->normalize($obj, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}
