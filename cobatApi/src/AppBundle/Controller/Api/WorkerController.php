<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Site;
use Dunglas\ApiBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WorkerController
 */
class WorkerController extends ResourceController
{
    /**
     * TODO: TYPE HINT PARAMETER
     * @param Request $request
     * @param $siteId
     * @param $startDate
     * @param $endDate
     * @return JsonResponse
     */
    public function getWeekAction(Request $request, $siteId, $startDate, $endDate)
    {
        //TODO REFACTO WITH PARAM CONVERTER
        $site = $this->getDoctrine()->getRepository(Site::class)->find($siteId);
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $week = $this->get('cobat.week.builder')->build($site, $startDate, $endDate);

        $resource = $this->getResource($request);

        return $this->getSuccessResponse(
            $resource,
            $week,
            Response::HTTP_OK,
            [],
            ['request_uri' => $request->getRequestUri()]
        );
    }
}
