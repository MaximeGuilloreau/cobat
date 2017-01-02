<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Site;
use Dunglas\ApiBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TODO: DEFINE CONTROLLER AS A SERVICE
 */
class WorkerController extends ResourceController
{
    /**
     * @ParamConverter("site", options={"id": "siteId" })
     * TODO: TYPE HINT PARAMETER
     * @param Request $request
     * @param Site $site
     * @param $startDate
     * @param $endDate
     * @return JsonResponse
     */
    public function getWeekAction(Request $request, Site $site, $startDate, $endDate)
    {
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
