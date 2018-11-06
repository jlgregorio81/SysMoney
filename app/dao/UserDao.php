<?php
namespace app\dao;

use core\dao\Dao;
use app\model\UserModel;
use app\model\CityModel;
use app\dao\CityDao;
use core\dao\SqlObject;
use core\dao\Connection;
use app\dao\UserDao;

final class UserDao extends Dao
{

    //..constantes para mapear colunas da tabela do bd
    const COL_NAME = 'name_user';
    const COL_GENDER = 'gender_user';
    const COL_PASSWD = 'password_user';
    const COL_STATUS = 'status_user';
    const COL_TYPE = 'type_user';
    const COL_EMAIL = 'email_user';
    const COL_CITY = 'id_city';

    public function __construct(UserModel $model = null)
    {
        $this->model = is_null($model) ? new UserModel() : $model;
        $this->tableName = 'users'; //..nome da tabela
        $this->tableId = 'id_user'; //..nome do campo de id
        $this->setColumns(); //..abstrato - deve ser codificado aqui!
    }

    //..pegar os dados do model (objeto) e criar um array...
    protected function setColumns()
    {
        $this->columns[self::COL_NAME] = $this->model->getName();
        $this->columns[self::COL_GENDER] = $this->model->getGender();
        //..cria um hash md5 para armazenar a senha
        $this->columns[self::COL_PASSWD] = \md5($this->model->getPassword());
        $this->columns[self::COL_STATUS] = $this->model->getStatus();
        $this->columns[self::COL_TYPE] = $this->model->getType();
        $this->columns[self::COL_EMAIL] = $this->model->getEmail();
        //..armazena o id da cidade
        $this->columns[self::COL_CITY] = $this->model->getCity()->getId();
    }

    public function findById($id)
    {
        try {
            /* esse método executa um 'select * from ... '*/
            $data = parent::findById($id);
            if ($data) { //..se retornar valor, então...
                /*
                $userModel = new UserModel(
                    $data[$this->tableId],
                    $data[self::COL_NAME],
                    $data[self::COL_GENDER],
                    null, $data[self::COL_STATUS],
                    $data[self::COL_TYPE], $data[self::COL_EMAIL],
                    (new CityDao())->findById($data[self::COL_CITY])
                );*/

                /*Obs: a palavra self:: faz referência à classe e é usada para acessar atributos estáticos e/ou constantes */

                $userModel = new UserModel();
                $userModel->setId($data[$this->tableId]);
                //$userModel->setName($data['name_user']);
                $userModel->setName($data[self::COL_NAME]);
                $userModel->setGender($data[self::COL_GENDER]);
                //$userModel->setPassword()
                $userModel->setStatus($data[self::COL_STATUS]);
                $userModel->setType($data[self::COL_TYPE]);
                $userModel->setEmail($data[self::COL_EMAIL]);
                //..cria uma nova instância de CityDao
                $cityDao = new CityDao();
                //..cria uma nova instância de CityModel que recebe uma instância de CityDao
                $cityModel = $cityDao->findById($data[self::COL_CITY]);
                //..seta o CityModel no UserModel
                $userModel->setCity($cityModel);
                return $userModel;
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function selectAll(
        $criteria = null,
        $orderBy = null,
        $groupBy = null,
        $limit = null,
        $offSet = null
    ) {
        try {
            $data = parent::selectAll(
                $criteria,
                $orderBy,
                $groupBy,
                $limit,
                $offSet
            );
            if ($data) {
                $arrayList = null;
                foreach ($data as $reg) {
                    $userModel = new UserModel(
                        $reg[$this->tableId],
                        $reg[self::COL_NAME],
                        $reg[self::COL_GENDER],
                        null,
                        $reg[self::COL_STATUS],
                        $reg[self::COL_TYPE],
                        $reg[self::COL_EMAIL],
                        (new CityDao())->findById($reg[self::COL_CITY])
                    );
                    $arrayList[] = $userModel;
                }
                return $arrayList;
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Busca um usuário por login e senha
     * @param string $login O email do usuário
     * @param string $pass A senha do usuário
     * @return UserModel
     */
    public function findForLogin($login, $pass)
    {
        try {
            $sqlObj = new SqlObject(Connection::getConnection());
            $criteria = self::COL_EMAIL . " = '{$login}' and ";
            $criteria .= self::COL_STATUS . " = 'A' and ";
            $criteria .= self::COL_PASSWD . " = md5('{$pass}')";
            $user = $sqlObj->select($this->tableName, '*', $criteria);
            if ($user) {
                $user = $user[0]; //..pega a primeira posição do array
                return new UserModel(
                    $user[$this->tableId], //..id do usuário
                    $user[self::COL_NAME], //..nome
                    $user[self::COL_GENDER], //..gênero
                    null, //..senha
                    $user[self::COL_STATUS], //..status
                    $user[self::COL_TYPE], //..tipo
                    $user[self::COL_EMAIL], //..email
                    (new CityDao())->findById($user[self::COL_CITY]) //..recupera o objeto CityModel
                );
            } else
                return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Verifica se um determinado e-mail está cadastrado no banco de dados.
     * @param string $email O email usado para a busca
     * @return bool True se já estiver cadastrado e False caso não esteja cadastrado. 
     */
    public function emailExists($email){
        try{
            $sqlObj = new SqlObject(Connection::getConnection());
            $user = $sqlObj->select($this->tableName, '*', "email_user = '{$email}'");
            if($user)
                return true;
            else
                return false;
        } catch(\Exception $ex){
            throw $ex;
        }
    }

}