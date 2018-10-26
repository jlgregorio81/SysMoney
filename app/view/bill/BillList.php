<?php
namespace app\view\bill;

use core\mvc\view\HtmlPage;

final class BillList extends HtmlPage
{
    public function __construct($model = null, $sqlData = null, $regPerPage = null, $currentPage = null, $previousPage = null, $nextPage = null, $lastPage = null)
    {
        parent::__construct($model, $sqlData, $regPerPage, $currentPage, $previousPage, $nextPage, $lastPage);
        $this->htmlFile = 'app/view/bill/bill_list.phtml';
    }

}