<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExportController
 * @Route("export")
 */
class ExportController extends Controller
{
    /**
     * @Route("/", name="export_index")
     */
    public function indexAction()
    {
        return $this->render(':export:index.html.twig');
    }

    /**
     * @Route("/download/last", name="cobat_download_last_report")
     */
    public function downloadLastReportAction()
    {
        $now = new \DateTime();
        $year = $now->format('Y');
        $month = $now->format('n');

        list($header, $reports) = $this->get('cobat.export.builder')->build($year, $month);

        return $this
            ->get('cobat.export.excel_builder')
            ->exportFile($header, $reports, $now->format('F Y'));

    }
}
