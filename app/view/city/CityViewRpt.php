<?php
namespace app\view\city;

use core\mvc\view\HtmlPage;


class CityViewRpt extends HtmlPage{

    //..atributos para guardar os dados da consulta e opções do form
    protected $name;
    protected $state;
    protected $urlRpt;

    public function __construct($model = null, $sqlData = null, $regPerPage = null, $currentPage = null, $previousPage = null, $nextPage = null, $lastPage = null)
    {
        parent::__construct($model,$sqlData, $regPerPage,$currentPage,$previousPage,$nextPage,$lastPage);
        $this->htmlFile = 'app/view/city/city_view_rpt.phtml';
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setState($state){
        $this->state = $state;
    }

    public function setUrlRpt($urlRpt){
        $this->urlRpt = $urlRpt;
    }

}