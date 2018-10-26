<?php
namespace app\dao;

use core\dao\Dao;
use app\model\CategoryModel;

final class CategoryDao extends Dao{

    //..colunas da tabela
    const TBL_ID = 'id_category';
    const TBL_NAME = 'name_category';

    public function __construct(CategoryModel $model = null)
    {
        $this->model = is_null($model) ? new CategoryModel() : $model;
        $this->tableName = 'category'; //..nome da tabela
        $this->tableId = 'id_category';  //..nome do campo id da tabela
        $this->setColumns(); //..método abstrato na superclasse.
    }

    //..mapeamento: campos da tabela --> métodos get do objeto model
    public function setColumns(){
        $this->columns = array(
                self::TBL_NAME => $this->model->getName()
        );
    }

    public function findById($id)
    {
        try{
            $data = parent::findById($id);
            if($data){
                return new CategoryModel(
                    $data[self::TBL_ID],
                    $data[self::TBL_NAME]);
            } else{
                return null;
            }
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    
    public function selectAll($criteria = null, $orderBy = null, 
        $groupBy = null, $limit = null, $offSet = null)
    {
        try{
            $data = parent::selectAll($criteria, $orderBy, $groupBy, 
                $limit, $offSet);
            if($data){
                $list = null;
                foreach($data as $row){
                    $list[] = new CategoryModel($row[self::TBL_ID],
                        $row[self::TBL_NAME]);
                }
                return $list;
            } else {
                return null;
            }                
        } catch (\Exception $ex){
            throw $ex;
        }
    }
    

    /*
    public function selectAll($criteria = null, $orderBy = null, 
        $groupBy = null, $limit = null, $offSet = null)
    {
        try{
            $data = parent::selectAll($criteria, $orderBy, $groupBy, 
                $limit, $offSet);
            if($data){
                $arrayObj = new \ArrayObject();
                foreach($data as $row){
                    $arrayObj->append(
                        new CategoryModel($row[self::TBL_ID],
                        $row[self::TBL_NAME])
                    ); 
                }
                return $arrayObj;
            } else {
                return null;
            }                
        } catch (\Exception $ex){
            throw $ex;
        }
    }
    */







}