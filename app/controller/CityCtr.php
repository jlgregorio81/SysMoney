<?php

namespace app\controller;

use core\mvc\Controller;
use app\dao\CityDao;
use app\model\CityModel;
use app\view\city\CityView;
use app\view\city\CityList;

class CityCtr extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model = new CityModel();
        $this->dao = new CityDao();
        $this->view = new CityView();
        $this->viewList = new CityList(); //..instanciar a view de listagem.
    }

    public function viewToModel() {
        $this->model->setId($this->post['id']);
        $this->model->setName($this->post['name']);
        $this->model->setState($this->post['state']);
    }

    public function showList() {
        if($this->post){
            $this->criteria = "upper (" . CityDao::COL_NAME . ") like upper('{$this->post['data'][0]}')";
            $this->orderBy = CityDao::COL_NAME;
        }
        parent::showList();
    }

    public function getCities(){
        if(isset($this->get['name'])){            
            $name = $this->get['name'];
            $criteria = "upper (" . CityDao::COL_NAME . ") like upper('{$name}%')";
            $cities = (new CityDao())->selectAllAsJson($criteria,CityDao::COL_NAME);            
            echo $cities;            
        }
    }

    public function getCity(){
        if(isset($this->get['idcity'])){
            $idCity = $this->get['idcity'];            
            $city = (new CityDao())->findByIdAsJson($idCity);
            if($city){
                echo $city;
            } else{
                echo "null";
            }
        }
    }

}