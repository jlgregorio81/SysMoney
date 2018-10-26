<?php

require_once('autoload.php');

use app\dao\UserDao;
use app\dao\CategoryDao;
use app\model\BillModel;
use app\dao\BillDao;
use app\view\bill\BillView;

/*
$user = (new UserDao())->findById(2);
$cat = (new CategoryDao())->findById(1);

$bill = new BillModel(null,'Almoço com amigos',$user,$cat,
        '16/10/2018',35.50,'16/10/2018','D','16/10/2018',
        'Restaurante XYZ');

$billDao = new BillDao($bill);


$billDao->insertUpdate();
*/

//$categories = (new CategoryDao())->selectAll();

//(new BillView(null,$categories))->show();

$bill = (new BillDao())->selectAll();

var_dump($bill);