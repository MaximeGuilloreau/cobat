<?php

namespace AppBundle\Normalizer;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Normalize Collection
 */
class ArrayNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        dump($this->serializer);
        die;
        $result =  array_map(function ($element) use ($format, $context) {
            return $this->serializer->normalize($element, $format, $context);
        }, $object->toArray());

        dump($result);
        die;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Collection;
    }
}
