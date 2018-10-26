<?php
namespace app\view\bill;

use core\mvc\view\HtmlPage;
use app\model\BillModel;


final class BillView extends HtmlPage{

    protected $categories;

    public function __construct(BillModel $model = null, $categories = null)
    {
        $this->model = is_null($model) ? new BillModel() : $model;
        $this->categories = $categories;
        $this->htmlFile = 'app/view/bill/bill_view.phtml';
    }


    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */ 
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }
}