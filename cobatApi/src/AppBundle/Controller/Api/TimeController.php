<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Site;
use Dunglas\ApiBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route()
 */
class TimeController extends ResourceController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function massSaveAction(Request $request)
    {
        $serializer = $this->get('serializer');
        $resource = $this->getResource($request);
        $entityClass = $resource->getEntityClass();
        $denormalizationContext = $resource->getDenormalizationContext();
        $objectManager = $this->getDoctrine()->getManager();
        $content = json_decode($request->getContent(), true);

        $times = array_map(function ($element) use ($serializer, $entityClass, $denormalizationContext, $resource) {
            if (!empty($element['@id'])) {
                $object = $this->findOrThrowNotFound(
                    $resource,
                    $this->get('cobat.idconverter.tools')->removePrefix($element['@id'])
                );
                $denormalizationContext['object_to_populate'] = $object;
            } else {
                unset($denormalizationContext['object_to_populate']);
            }


            return $serializer->denormalize(
                $element,
                $entityClass,
                'json-ld',
                $denormalizationContext
            );
        }, $content);

        //TODO: HANDLE ERROR
        foreach ($times as $time) {
            $objectManager->persist($time);
        }

        $objectManager->flush();
        //TODO: USE JSON LD REPONSE
        return new JsonResponse($content);
    }
}
