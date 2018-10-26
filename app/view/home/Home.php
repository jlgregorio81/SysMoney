<?php
namespace app\view\home;

use core\mvc\view\HtmlPage;

class Home extends HtmlPage{

    protected $msgError;

    public function __construct($msgError = null)
    {        
        $this->htmlFile = 'app/view/home/home.phtml';
        $this->msgError = $msgError;
    }


}