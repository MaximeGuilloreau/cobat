<?php

namespace AppBundle\Export;

class ExcelHeaderBuilder
{
    private static $days = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];

    public function build(\PHPExcel $phpExcel, array $header)
    {
        $sheet = $phpExcel->getActiveSheet();
        $row = 2;
        $columns = 0;
        foreach ($header as $value) {
            // TODO: SPLIT LOGIC
            if ($columns < 3) {
                $sheet->mergeCellsByColumnAndRow($columns, $row, $columns, $row + 1);
                $cell = $sheet->setCellValueByColumnAndRow($columns, $row, $value, true);
                $this->applyStyle($phpExcel, $cell);

            } else {
                $cell = $sheet
                    ->setCellValueByColumnAndRow($columns, $row, self::$days[$value->format('N') - 1], true);
                $this->applyStyleCalendar($phpExcel, $cell, $value);
                $cell = $sheet
                    ->setCellValueByColumnAndRow($columns, $row + 1, $value->format('d'), true);
                $this->applyStyleCalendar($phpExcel, $cell, $value);
            }

            $columns++;
        }

        $sheet->mergeCellsByColumnAndRow($columns, $row, $columns, $row + 1);
        $cell = $sheet->setCellValueByColumnAndRow($columns, $row, 'cumul heures normales (hors samedi)', true);
        $this->applyStyleSummary($phpExcel, $cell);

        $sheet->getColumnDimension($cell->getColumn())->setWidth(20);

        $sheet->mergeCellsByColumnAndRow(++$columns, $row, $columns, $row + 1);
        $cell = $sheet->setCellValueByColumnAndRow($columns, $row, 'nombre de samedis', true);
        $this->applyStyleSummary($phpExcel, $cell);

        $sheet->getColumnDimension($cell->getColumn())->setWidth(20);

        $sheet->getRowDimension(2)->setRowHeight(35);
        $sheet->getRowDimension(3)->setRowHeight(15);
    }

    private function applyStyleCalendar(\PHPExcel $phpExcel, \PHPExcel_Cell $cell, \DateTime $date)
    {
        $phpExcel
            ->getActiveSheet()
            ->getStyle($cell->getCoordinate())
            ->applyFromArray($this->getStyle($date));
    }

    private function applyStyle(\PHPExcel $phpExcel, \PHPExcel_Cell $cell)
    {
        $phpExcel
            ->getActiveSheet()
            ->getStyle($cell->getCoordinate())
            ->applyFromArray($this->getStyle());
    }

    private function applyStyleSummary(\PHPExcel $phpExcel, \PHPExcel_Cell $cell)
    {
        $phpExcel
            ->getActiveSheet()
            ->getStyle($cell->getCoordinate())
            ->applyFromArray(
                array_merge(
                    $this->getStyle(),
                    $this->getSummaryStyle()
                ));
    }

    private function getStyle($date = null)
    {
        $style = [
            'borders' => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
        ];

        if ($date !== null && in_array($date->format('w'), [0, 6])) {
            return array_merge(
                $style,
                [
                    'fill'=> [
                        'type'=> \PHPExcel_Style_Fill::FILL_SOLID,
                        'color'=> [
                            'rgb' => '7DA7B5'
                        ]
                    ],
                ]
            );
        }

        return $style;
    }

    private function getSummaryStyle()
    {
        return [
            'fill'=> [
                'type'=> \PHPExcel_Style_Fill::FILL_SOLID,
                'color'=> [
                    'rgb' => 'FCB400'
                ]
            ],
        ];
    }
}
