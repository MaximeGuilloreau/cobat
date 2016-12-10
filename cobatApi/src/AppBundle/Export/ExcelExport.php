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

    public function __construct(Factory $phpExcel)
    {
        $this->phpExcel = $phpExcel;
    }

    public function exportFile($header, $reports, $title = '')
    {
        $phpExcelObject = $this->phpExcel->createPHPExcelObject();
        $this->buildFileProperty($phpExcelObject);
        $sheet = $phpExcelObject
            ->setActiveSheetIndex(0);

        $maxColumns = count($header);
        $row = 1;
        $sheet->mergeCellsByColumnAndRow(0, $row, $maxColumns, $row);
        $sheet->setCellValueByColumnAndRow(0, 1, $title);

        //$sheet->mergeCellsByColumnAndRow(0, 2, $maxColumns, 3);

        $row = 2;
        $columns = 0;
        foreach ($header as $value) {
            if ($columns < 3) {
                $sheet->mergeCellsByColumnAndRow($columns, $row, $columns, $row + 1);
                $sheet
                    ->setCellValueByColumnAndRow($columns, $row, $value);
            } else {
                $sheet
                    ->setCellValueByColumnAndRow($columns, $row, self::$days[$value->format('N') - 1]);
                $sheet
                    ->setCellValueByColumnAndRow($columns, $row + 1, $value->format('d'));
            }


            $columns++;
        }

        ++$row;
        ++$row;
        foreach ($reports as $report) {
            $columns = 0;
            $sheet
                ->setCellValueByColumnAndRow($columns, $row, $report['name'])
                ->setCellValueByColumnAndRow(++$columns, $row, $report['firstname'])
                ->setCellValueByColumnAndRow(++$columns, $row, $report['site']);

            foreach ($report['times'] as $time) {
                $cell = $sheet
                    ->setCellValueByColumnAndRow(++$columns, $row, $time['amount'], true);
                if (0 === (int)$time['amount']) {
                    $phpExcelObject->getActiveSheet()->getStyle($cell->getCoordinate())->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E05CC2')
                            )
                        )

                    );
                }
            }

            $sheet
                ->setCellValueByColumnAndRow(++$columns, $row, $report['totalHour'], true);

            $row++;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $phpExcelObject->getDefaultStyle()->applyFromArray($styleArray);
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        return $this->writeFile($phpExcelObject);
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

    private function writeFile(\PHPExcel $phpExcelObject)
    {
        // create the writer
        $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->phpExcel->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}
