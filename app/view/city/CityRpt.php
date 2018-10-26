<?php

namespace app\view\city;

use core\rpt\Report;


class CityRpt extends Report
{

    //..método abstrato na superclasse deve ser implementado aqui.
    public function tableHeader()
    {
        //..cor de preenchimento
        $this->SetFillColor(220);
        $this->SetFont('helvetica','B',16);
        $this->Cell(0, null, 'Relatório de Cidades Cadastradas', 1, 1, 'C', 1);
        $this->SetFont('helvetica','B',14);
        $this->Cell(20, null, 'ID', 1, 0, 'C', 1);
        $this->Cell(120, null, 'Nome', 1, 0, 'C', 1);
        $this->Cell(30, null, 'UF', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetFont('helvetica',null,12);
    }

    //..método abstrato na superclasse deve ser implementado aqui.
    public function body()
    {
        if ($this->data) {
            foreach ($this->data as $city) {
                $this->Cell(20, null, $city->getId(), 1, 0, 'C');
                $this->Cell(120, null, $city->getName(), 1, 0);
                $this->Cell(30, null, $city->getState(), 1, 0,'C');
                $this->Ln();
            }
        }
    }



}