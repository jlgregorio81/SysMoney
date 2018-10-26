<?php

namespace app\model;

final class CityModel extends \core\mvc\Model{
    
    private $name;
    private $state;

    public function __construct($id = null, $name = null, $state = null) {
        parent::__construct($id);
        $this->name = $name;
        $this->state = $state;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setState($state){
        $this->state = $state;
    }

    public function getName(){
        return $this->name;
    }

    public function getState(){
        return $this->state;
    }

    public function show() {
        
    }
    



}