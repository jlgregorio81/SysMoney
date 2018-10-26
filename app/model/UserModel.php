<?php
namespace app\model;

use core\mvc\Model;
use app\model\CityModel;

class UserModel extends Model
{

    private $name;
    private $gender;
    private $password;
    private $status;
    private $type;
    private $email;
    private $city;

    public function __construct(
        $id = null,
        $name = null,
        $gender = null,
        $password = null,
        $status = null,
        $type = null,
        $email = null,
        CityModel $city = null
    )
    {
        parent::__construct($id);
        $this->name = $name;
        $this->gender = $gender;
        $this->password = $password;
        $this->status = $status;
        $this->type = $type;
        $this->email = $email;
        $this->city = is_null($city) ? new CityModel() : $city;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setGender($gender){
        $this->gender = $gender;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setCity(CityModel $city){
        $this->city = $city;
    }

    public function getName(){
        return $this->name;
    }

    public function getGender(){
        return $this->gender;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getType(){
        return $this->type;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getCity(){
        return $this->city;
    }

    public function show() {

    }

    public function getCityAsString(){
        return "{$this->city->getName()}/{$this->city->getState()}";
    }

}