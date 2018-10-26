<?php

namespace app\view\city;

use core\mvc\view\HtmlPage;
use app\model\CityModel;

final class CityView extends HtmlPage{

    public function __construct(CityModel $model = null) {
        $this->model = is_null($model) ? new CityModel() : $model;
        $this->htmlFile = 'app\view\city\city_view.phtml';
    }

    


}