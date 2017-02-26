<?php

namespace AppBundle\Export;

/**
 * Class ExcelReportBuilder
 */
class ExcelReportBuilder
{
    /**
     * @param \PHPExcel $phpExcel
     * @param array     $reports
     */
    public function build(\PHPExcel $phpExcel, array $reports)
    {
        $sheet = $phpExcel->getActiveSheet();
        $row = 4;
        foreach ($reports as $report) {
            $columns = 0;
            $cellName = $sheet->setCellValueByColumnAndRow($columns, $row, $report['name'], true);
            $cellFirstName = $sheet->setCellValueByColumnAndRow(++$columns, $row, $report['firstname'], true);
            $cellSite = $sheet->setCellValueByColumnAndRow(++$columns, $row, $report['site'], true);

            ksort($report['times']);
            foreach ($report['times'] as $time) {
                $cell = $sheet
                    ->setCellValueByColumnAndRow(++$columns, $row, $time['amount'], true);
                $this->applyStyle($phpExcel, $cell, $time);
            }

            $cell = $sheet
                    ->setCellValueByColumnAndRow(++$columns, $row, $report['totalHour'], true);
            $this->applyStyleSummary($phpExcel, $cell);

            $cell= $sheet
                    ->setCellValueByColumnAndRow(++$columns, $row, $report['nbSaturday'], true);
            $this->applyStyleSummary($phpExcel, $cell);

            $sheet->getRowDimension($row)->setRowHeight(15);

            $row++;
        }

    }

    /**
     * @param \PHPExcel      $phpExcel
     * @param \PHPExcel_Cell $cell
     * @param null           $value
     * @throws \PHPExcel_Exception
     */
    private function applyStyle(\PHPExcel $phpExcel, \PHPExcel_Cell $cell, $value = null)
    {
        $phpExcel
            ->getActiveSheet()
            ->getStyle($cell->getCoordinate())
            ->applyFromArray($this->getStyle($value));
    }

    /**
     * @param \PHPExcel      $phpExcel
     * @param \PHPExcel_Cell $cell
     * @throws \PHPExcel_Exception
     */
    private function applyStyleSummary(\PHPExcel $phpExcel, \PHPExcel_Cell $cell)
    {
        $phpExcel
            ->getActiveSheet()
            ->getStyle($cell->getCoordinate())
            ->applyFromArray($this->getStyleSummary());
    }

    /**
     * @return array
     */
    private function getStyle($value)
    {
        return array_merge(
            [
                'borders' => [
                    'allborders' => [
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ],
            ],
            $this->getColor($value)
        );
    }

    /**
     * @param $cellValue
     * @return array
     */
    private function getColor($cellValue)
    {
        if (in_array($cellValue['date']->format('w'), [0, 6])) {
            return [
                'fill'=> [
                    'type'=> \PHPExcel_Style_Fill::FILL_SOLID,
                    'color'=> [
                        'rgb' => '7DA7B5'
                    ]
                ],
            ];
        }

        if ($cellValue['amount'] !== 0) {
            return [];
        }

        return [
            'fill'=> [
                'type'=> \PHPExcel_Style_Fill::FILL_SOLID,
                'color'=> [
                    'rgb' => 'A34488'
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    private function getStyleSummary()
    {
        return [
            'borders' => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
            'fill'=> [
                'type'=> \PHPExcel_Style_Fill::FILL_SOLID,
                'color'=> [
                    'rgb' => 'FCB400'
                ]
            ],
        ];
    }
}
