<?php

namespace AppBundle\Export;

use Liuggio\ExcelBundle\Factory;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class ExcelExport
 */
class ExcelExport
{
    private static $days = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];

    /**
     * @var Factory
     */
    private $phpExcel;

    /** @var ExcelReportBuilder */
    private $excelReportBuilder;

    /** @var ExcelHeaderBuilder */
    private $excelHeaderBuilder;

    public function __construct(
        Factory $phpExcel,
        ExcelReportBuilder $excelReportBuilder,
        ExcelHeaderBuilder $excelHeaderBuilder
    ) {
        $this->phpExcel = $phpExcel;
        $this->excelReportBuilder = $excelReportBuilder;
        $this->excelHeaderBuilder = $excelHeaderBuilder;

    }

    public function exportFile($header, $reports, $title = '')
    {
        $phpExcelObject = $this->phpExcel->createPHPExcelObject();
        $this->buildFileProperty($phpExcelObject);
        $sheet = $phpExcelObject
            ->setActiveSheetIndex(0);

        $this->buildTitle($sheet, $phpExcelObject, $title, count($header) + 3);
        $this->excelHeaderBuilder->build($phpExcelObject, $header);

        $this->excelReportBuilder->build($phpExcelObject, $reports);
//        $cell = $sheet->setCellValueByColumnAndRow(++$columns, $row, 'cumul heures normales (hors samedi)', true);
//        $cell = $sheet->setCellValueByColumnAndRow(++$columns, $row, 'nombre de samedis', true);

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        return $this->writeFile($phpExcelObject);
    }



    private function buildTitle($sheet, $phpExcelObject, string $title, $titleSize)
    {
        $row = 1;
        $sheet->mergeCellsByColumnAndRow(0, $row, $titleSize, $row);
        $cell = $sheet->setCellValueByColumnAndRow(0, $row, $title, true);
        $this->addStyleToCell($cell, $phpExcelObject);
    }


    /**
     * @param \PHPExcel $phpExcelObject
     */
    private function buildFileProperty(\PHPExcel $phpExcelObject)
    {
        $phpExcelObject
            ->getProperties()
            ->setCreator('Admin')
            ->setLastModifiedBy('Admin')
            ->setTitle('Export de temps');
    }

    private function getFileName()
    {
        $now = new \DateTime();
        return sprintf('suivi-du-personnel-au-%s.xls', $now->format('Ymd-H:i'));
    }

    private function writeFile(\PHPExcel $phpExcelObject)
    {
        // create the writer
        $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->phpExcel->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $this->getFileName()
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    private function addStyleToCell(\PHPExcel_Cell $cell, $phpExcelObject)
    {
        $phpExcelObject->getActiveSheet()->getStyle($cell->getCoordinate())->applyFromArray(
            [
                'borders' => [
                    'allborders' => [
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ],
            ]

        );

    }
}
