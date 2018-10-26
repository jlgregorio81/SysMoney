<?php
namespace app\controller;

use core\mvc\Controller;
use app\model\CategoryModel;
use app\view\category\CategoryView;
use app\dao\CategoryDao;
use app\view\category\CategoryList;

final class CategoryCtr extends Controller{

    public function __construct()
    {
        parent::__construct();
        //..instanciar os objetos que o controller irá manipular
        $this->model = new CategoryModel();
        $this->view = new CategoryView();
        $this->dao = new CategoryDao();        
        $this->viewList = new CategoryList();
    }

    public function viewToModel()
    {
        //..se existir algo no post, então...
        if($this->post){
            //..alimenta o model com os dados vindos da view
            $this->model->setId($this->post['id']);
            $this->model->setName($this->post['name']);
        }
    }

    public function showList()
    {
        if($this->post){
            $this->criteria = "upper (" . 
                CategoryDao::TBL_NAME . 
                ") like upper('{$this->post['data'][0]}')";
            
                $this->orderBy = CategoryDao::TBL_NAME;
        }
        parent::showList();
    }

}