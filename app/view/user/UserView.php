<?php

namespace app\view\user;
use core\mvc\view\HtmlPage;
use app\model\UserModel;

class UserView extends HtmlPage{

    //..armazena as cidades cadastradas
    protected $cities; 

    public function __construct(UserModel $model = null, $cities = null) {
        $this->model = \is_null($model) ? new UserModel() : $model;
        $this->htmlFile = 'app/view/user/user_view.phtml';
        $this->cities = $cities;
    }

    public function setCities($cities){
        $this->cities = $cities;
    }

    public function getCities(){
        $this->cities;
    }


}