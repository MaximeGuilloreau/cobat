<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Site;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route()
 */
class TimeController extends Controller
{
    /**
     * @Route("/api/times/week/{siteId}/{startDate}/{endDate}")
     * @param Request $request
     */
    public function getWeekAction(Request $request, $siteId, $startDate, $endDate)
    {
        $site = $this->getDoctrine()->getRepository(Site::class)->find($siteId);
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $week = $this->get('cobat.week.builder')->build($site, $startDate, $endDate);
        dump($week);
        die;
        return new JsonResponse($week);
    }

    /**
     * @Route("/api/times/mass-save", name="cobat_mass_save")
     * @Method({"POST"})
     * @param Request $request
     */
    public function massSaveAction(Request $request)
    {
        $content = $request->getContent();
        return new JsonResponse($content);
    }
}
